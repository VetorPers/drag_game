<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param $data
     * @param string $msg
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function resOk($data = [], $msg = '操作成功')
    {
        return response()->json([
            'result' => true,
            'msg'    => $msg,
            'data'   => $data,
        ]);
    }

    /**
     * @param string $msg
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function resFail($msg = '操作失败，请重试')
    {
        return response()->json([
            'result' => false,
            'msg'    => $msg,
            'data'   => null,
        ]);
    }
}
