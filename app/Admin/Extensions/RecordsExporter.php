<?php

namespace App\Admin\Extensions;


use Encore\Admin\Grid\Exporters\ExcelExporter;

class RecordsExporter extends ExcelExporter
{
    protected $fileName = '学生成绩.xlsx';
    protected $columns = [
        'id'     => 'Id',
        'name'   => '姓名',
        'gname'  => '班级',
        'number' => '学号',
        'score'  => '分数',
    ];

    public function query()
    {
        return $this->getQuery()->select('records.id', 'users.name', 'grades.name as gname', 'users.number', 'score')
            ->leftJoin('users', 'user_id', 'users.id')
            ->leftJoin('grades', 'users.grade_id', 'grades.id');
    }
}
