<?php

namespace App\Http\Controllers;


use App\Pest;
use App\User;
use App\Answer;
use App\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PestController extends Controller
{
    protected $scores = [3 => 60, 4 => 70, 5 => 80, 6 => 90, 7 => 100];

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
        }

        if ($type == 2) {
            $user = User::where('number', $request->input('number'))->first();
            if ( !$user) return $this->resFail('学号不正确');
        }

        return $this->resOk(['user_id' => $user->id]);
    }

    /**
     * 获取问题
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function pest(Request $request)
    {
        $data = Pest::orderBy('order')->limit(2)->get(['id', 'name', 'img', 'time']);

        return $this->resOk($data);
    }

    /**
     * 获取问题详情
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function pestInfo(Request $request)
    {
        $pest = Pest::find($request->input('pest_id'));
        $info = $pest->only(['id', 'name', 'img', 'time']);
        $info['answers'] = Answer::select('id', 'title')->where('pest_id', $pest->id)->get()->shuffle();
        $info['count'] = Answer::select('id', 'title')->where('pest_id', $pest->id)->where('is_right', 1)->count();

        return $this->resOk($info);
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
        $validator = Validator::make($request->all(), [
            'pest_id'    => 'required',
            'answer_ids' => 'required|array',
        ]);

        if ($validator->fails()) return $this->resFail('提交失败');
        $param = $request->all();

        $user = isset($param['user_id']) ? User::findOrFail($param['user_id']) : User::firstOrCreate(['name' => '游客']);
        $pest = Pest::find($param['pest_id']);
        $count = $pest->answers->where('is_right', 1)->count();
        $param['answer_ids'] = array_unique(array_slice($param['answer_ids'], 0, $count));

        $rightAnswersCount = $pest->answers->where('is_right', 1)->whereIn('id', $param['answer_ids'])->count();
        $score = $this->scores[$rightAnswersCount] ?? ($rightAnswersCount > max(array_keys($this->scores)) ? 100 : 0);

        Record::create([
            'user_id'    => $user->id,
            'pest_id'    => $param['pest_id'],
            'answer_ids' => implode(';', $param['answer_ids']),
            'score'      => $score,
        ]);

        return $this->resOk([
            'right_answers' => $pest->answers->where('is_right', 1)->pluck('title'),
            'is_pass'       => $score >= 60 ? true : false,
            'score'         => $score,
            'name'          => $pest->name,
        ]);
    }
}
