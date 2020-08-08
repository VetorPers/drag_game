<?php

namespace App\Admin\Extensions;


use Encore\Admin\Grid\Exporters\ExcelExporter;
use Maatwebsite\Excel\Concerns\WithMapping;

class RecordsExporter extends ExcelExporter implements WithMapping
{
    protected $fileName = '学生成绩.xlsx';
    protected $columns = [
        'id'              => 'Id',
        'user_id'         => '用户Id',
        'user.name'       => '姓名',
        'user.grade_id'   => '班级Id',
        'user.grade.name' => '班级',
        'user.number'     => '学号',
        'score'           => '分数',
    ];

    public function map($recod): array
    {
        return [
            $recod->id,
            $recod->user_id,
            data_get($recod, 'user.name'),
            data_get($recod, 'user.grade_id'),
            data_get($recod, 'user.grade.name'),
            data_get($recod, 'user.number'),
            $recod->score,
        ];
    }
}
