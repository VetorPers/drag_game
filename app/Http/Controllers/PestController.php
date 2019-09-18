<?php

namespace App\Http\Controllers;


use App\Pest;
use App\Record;
use App\Question;
use App\RecordDetail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PestController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login(Request $request)
    {
        return view('login');
    }

    /**
     * 登陆
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginPost(Request $request)
    {
        $type = $request->input('type', 1);
        if ($type == 1) {
            $user = User::firstOrCreate(['name' => '游客']);
            Auth::loginUsingId($user->id);

            return $this->resOk();
        }

        if ($type == 2) {
            $user = User::where('number', $request->input('number'))->first();
            if ( !$user) return $this->resFail('学号不正确');

            Auth::loginUsingId($user->id);

            return $this->resOk();
        }

        return $this->resFail();
    }

    /**
     * 获取问题
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function questions(Request $request, $tree_sign)
    {
        $imgs = ['A', 'B', 'C', 'D'];
        $pest = Pest::where('tree_sign', $tree_sign)->inRandomOrder()->first();

        $level1 = Question::select('id', 'title', 'type', 'desc', 'img')->with('answers:id,question_id,title,is_right')->where('pest_id', $pest->id)->where('level', 1)->inRandomOrder()->limit(1)->get();
        $level2 = Question::select('id', 'title', 'type', 'desc', 'img')->with('answers:id,question_id,title,is_right')->where('pest_id', $pest->id)->where('level', 2)->inRandomOrder()->limit(8)->get();
        $level3 = Question::select('id', 'title', 'type', 'desc', 'img')->with('answers:id,question_id,title,is_right')->where('pest_id', $pest->id)->where('level', 3)->inRandomOrder()->limit(1)->get();
        $questions = $level1->merge($level2)->merge($level3);

        return view('questions', compact('tree_sign', 'questions', 'imgs'));
    }

    /**
     * 保存答题
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeUserAnswer(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->input('data');
            $userId = Auth::id();

            if (empty($data)) throw  new \Exception('data is empty');
            $record = Record::create(['user_id' => $userId]);

            $details = [];
            foreach ($data as $item) {
                $questionId = $item['question_id'];
                $answerIds = $item['answer_ids'] ?? [];
                $isRight = Question::find($questionId)->is_right($answerIds);

                $details[] = [
                    'record_id'   => $record->id,
                    'user_id'     => $userId,
                    'question_id' => $questionId,
                    'answer_ids'  => implode(';', $answerIds),
                    'is_right'    => $isRight,
                    'score'       => $isRight ? 10 : 0,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ];
            }

            RecordDetail::insert($details);
            $record->score = collect($details)->pluck('score')->sum();
            $record->save();
            DB::commit();

            return response()->json([
                'result' => true,
                'id'     => $record->id,
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();

            return response()->json([
                'result' => true,
                'id'     => null,
            ]);
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function result(Request $request)
    {
        $score = 0;
        $is_pass = false;
        $record = Record::find($request->input('id'));
        if ($record && $record->score >= 60) $is_pass = true;
        if ($record) $score = $record->score;

        return view('result', compact('is_pass', 'score'));
    }
}
