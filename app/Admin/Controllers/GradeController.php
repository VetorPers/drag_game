<?php

namespace App\Admin\Controllers;

use App\Grade;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class GradeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '班级';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Grade);

        $grid->id('Id');
        $grid->name('班级名称');
        $grid->created_at('创建时间');
        $grid->updated_at('更新时间');

        $grid->disableExport();

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Grade);

        $form->text('name', '班级名称');

        return $form;
    }
}
