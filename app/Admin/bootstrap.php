<?php

use Encore\Admin\Grid;
use Encore\Admin\Form;

Form::forget(['map', 'editor']);

Grid::init(function (Grid $grid) {
    $grid->disableRowSelector();
    $grid->disableColumnSelector();
    $grid->actions(function (Grid\Displayers\Actions $actions) {
        $actions->disableView();
    });
});

Form::init(function (Form $form) {
    $form->disableEditingCheck();
    $form->disableCreatingCheck();
    $form->disableViewCheck();
    $form->tools(function (Form\Tools $tools) {
        $tools->disableView();
    });
});
