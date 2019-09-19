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
        $data = Pest::orderBy('order')->limit(2)->get()->map(function ($pest) {
            $answers = [];

            $rpest = $pest->answers()->where('is_right', 1)->get(['id', 'title']);
            if ($rpest->isNotEmpty()) {
                $rpest = $rpest->random($rpest->count() > $pest->right_num ? $pest->right_num : $rpest->count())->all();
                $answers = array_merge($answers, $rpest);
            }

            $dpest = $pest->answers()->where('is_right', 0)->get(['id', 'title']);
            if ($dpest->isNotEmpty()) {
                $dpest = $dpest->random($dpest->count() > $pest->disturb_num ? $pest->disturb_num : $dpest->count())->all();
                $answers = array_merge($answers, $dpest);
            }

            shuffle($answers);
            $pest->answers = $answers;

            return $pest;
        });

        return $this->resOk($data);
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
            'user_id'    => 'required',
            'pest_id'    => 'required',
            'answer_ids' => 'required|array',
        ]);

        if ($validator->fails()) return $this->resFail('提交失败');
        $param = $request->all();

        $user = User::find($param['user_id']) ?? User::firstOrCreate(['name' => '游客']);
        $pest = Pest::find($param['pest_id']);
        $rightAnswersCount = Answer::whereIn('id', $param['answer_ids'])->where('pest_id', $param['pest_id'])->where('is_right', 1)->count();
        $score = $rightAnswersCount * $pest->ascore;

        Record::create([
            'user_id'    => $user->id,
            'pest_id'    => $param['pest_id'],
            'answer_ids' => implode(';', $param['answer_ids']),
            'score'      => $score,
        ]);

        return $this->resOk(['is_pass' => $score >= $pest->pass_score ? true : false]);
    }
}
