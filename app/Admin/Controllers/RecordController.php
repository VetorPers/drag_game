<?php

namespace App\Admin\Controllers;

use App\Answer;
use App\Pest;
use App\User;
use App\Grade;
use App\Record;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Admin\Extensions\RecordsExporter;
use Encore\Admin\Controllers\AdminController;

class RecordController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '作答';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Record);

        $grid->id('Id');
        $grid->column('user.name', '姓名');
        $grid->column('', '班级')->display(function () {
            return $this->user->grade->name;
        });
        $grid->column('user.number', '学号');
        $grid->column('pest.name', '游戏');
        $grid->column('answer_ids', '所选项')->display(function ($ids) {
            return Answer::find(explode(';', $ids))->pluck('title')->map(function ($title) {
                return "<span class='label label-success'>$title</span>&nbsp";
            })->implode('');
        });
        $grid->score('分数')->sortable();
        $grid->created_at('创建时间');

        $grid->filter(function ($filter) {
            $filter->where(function ($query) {
                $user = User::where('number', $this->input)->first();
                $query->where('user_id', optional($user)->id);
            }, '学号');

            $filter->where(function ($query) {
                $userIds = User::where('grade_id', $this->input)->get()->pluck('id');
                $query->whereIn('user_id', $userIds);
            }, '班级')->select(Grade::all()->pluck('name', 'id'));

            $filter->where(function ($query) {
                $query->where('pest_id', $this->input);
            }, '游戏')->select(Pest::all()->pluck('name', 'id'));
        });

        $grid->disableActions();
        $grid->disableCreateButton();

        $grid->exporter(new RecordsExporter());

        return $grid;
    }
}
