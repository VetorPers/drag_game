<?php

namespace App\Admin\Extensions;


use Encore\Admin\Grid\Exporters\ExcelExporter;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExporter extends ExcelExporter implements WithMapping
{
    protected $fileName = '用户列表.xlsx';
    protected $columns = [
        'id'       => 'Id',
        'name'     => '姓名',
        'number'   => '学号',
        'grade_id' => '班级Id',
        'gname'    => '班级',
    ];

    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->number,
            $user->grade_id,
            data_get($user, 'grades.name'),
        ];
    }
}
