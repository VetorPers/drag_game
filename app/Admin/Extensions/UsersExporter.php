<?php

namespace App\Admin\Extensions;


use Encore\Admin\Grid\Exporters\ExcelExporter;

class UsersExporter extends ExcelExporter
{
    protected $fileName = '用户列表.xlsx';
    protected $columns = [
        'id'     => 'Id',
        'name'   => '姓名',
        'number' => '学号',
        'gname'  => '班级',
    ];

    public function query()
    {
        return $this->getQuery()->select('users.id', 'users.name', 'users.number', 'grades.name as gname')->leftJoin('grades', 'grade_id', 'grades.id');
    }
}
