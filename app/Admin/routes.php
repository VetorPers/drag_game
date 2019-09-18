<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->resource('users', UserController::class);
    $router->resource('questions', QuestionController::class);
    $router->resource('records', RecordController::class);
    $router->resource('grades', GradeController::class);
    $router->get('charts', 'ChartController@index');
    $router->post('charts', 'ChartController@getData');
    $router->get('treePest', 'PestController@treePest');
    $router->resource('pests', PestController::class);
});
