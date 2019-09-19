<?php

namespace App\Admin\Controllers;

use App\Pest;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Widgets\Table;

class PestController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '游戏';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Pest);

        $grid->column('id', __('Id'));
        $grid->column('name', '名称')->modal('可选项', function ($model) {
            $answers = $model->answers()->get()->map(function ($answer) {
                $answer = $answer->only(['id', 'title', 'is_right', 'created_at', 'updated_at']);
                $answer['is_right'] = $answer['is_right'] ? '是' : '否';

                return $answer;
            });

            return new Table(['ID', '内容', '是否正确', '创建时间', '更新时间'], $answers->toArray());
        });
        $grid->column('ascore', '每题分数');
        $grid->column('pass_score', '通关分数');
        $grid->column('time', '答题时间');
        $grid->column('created_at', '创建时间');
        $grid->column('updated_at', '更新时间');
        $grid->disableExport();
        $grid->model()->orderBy('order');

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Pest);

        $form->text('name', '名称')->required();
        $form->image('img', '图片')->required();
        $form->text('ascore', '每题分数')->required();
        $form->text('order', '排序')->default(255)->required();
        $form->text('pass_score', '通关分数')->required();
        $form->text('time', '答题时间(s)')->required();
        $form->fieldset('出题设置', function (Form $form) {
            $form->text('right_num', '正确选项(个)')->default(10)->required();
            $form->text('disturb_num', '干扰选项(个)')->default(5)->required();
        });
        $form->hasMany('answers', '可选项', function (Form\NestedForm $form) {
            $form->text('title', '内容');
            $form->select('is_right', '是否正确')->options([
                0 => '否',
                1 => '是',
            ]);
        })->mode('table');

        return $form;
    }
}
