<?php

namespace App\Admin\Actions;

use App\Imports\QuestionsImport;
use Encore\Admin\Actions\Action;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class QsImport extends Action
{
    public $name = '导入';

    protected $selector = '.import-post';

    public function handle(Request $request)
    {
        $file = $request->file('file');

        $fileName = rand(1, 100) . $file->getClientOriginalName();

        $file->storeAs('files', $fileName);
        Excel::import(new QuestionsImport(), 'files/' . $fileName);

        return $this->response()->success('导入完成！')->refresh();
    }

    public function form()
    {
        $this->file('file', '请选择文件');
    }

    public function html()
    {
        return <<<HTML
        <a class="btn btn-sm btn-default import-post"><i class="fa fa-upload"></i> 导入</a>
HTML;
    }
}
