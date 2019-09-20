<?php

namespace App\Admin\Controllers;


use App\Grade;
use App\Record;
use App\User;
use Illuminate\Http\Request;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function index(Content $content)
    {
        $all = $this->getScoreData();
        $total = array_sum($all);
        $today = Record::whereDate('created_at', now()->toDateString())->count();
        $grades = Grade::all();

        return $content
            ->header('首页')
            ->body(view('admin.chart', compact('total', 'today', 'grades', 'all')));
    }

    public function getData(Request $request)
    {
        $gradeId = $request->input('grade_id');

        return response()->json(['data' => $this->getScoreData($gradeId)]);
    }

    protected function getScoreData($gradeId = 0)
    {
        if ($gradeId) {
            $userIds = User::where('grade_id', $gradeId)->pluck('id');
            $record = Record::select('id', 'user_id', DB::raw("max(score) as score"))->whereIn('user_id', $userIds)->groupBy('user_id')->get();
        } else {
            $record = Record::all();
        }

        return [
            $record->where('score', '<', 60)->count(),
            $record->where('score', '>=', 60)->where('score', '<', 70)->count(),
            $record->where('score', '>=', 70)->where('score', '<', 80)->count(),
            $record->where('score', '>=', 80)->count(),
        ];
    }
}
