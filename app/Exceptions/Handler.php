<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function report(Exception $e)
    {

        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {

        if (in_array('api', $e->guards())) {
            if ($e instanceof \Illuminate\Auth\AuthenticationException) {
                $msg = '未授权';

                return response()->json([ 'success' => false, 'message' => $msg ,'status_code'=>400], 200);
            }
            if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                $msg = '该模型未找到';

                return response()->json([ 'success' => false, 'message' => $msg ,'status_code'=>400], 200);
            }

       }

        if ($e instanceof UnauthorizedException) {
            $msg = $e->getMessage() ? $e->getMessage() : '出现异常';

            return response()->json([ 'success' => false, 'message' => $msg ,'status_code'=>400], 200);
        }
        if ($e instanceof \Illuminate\Validation\ValidationException) {
            $data =$e->validator->getMessageBag();
            $msg = collect($data)->first();
            if(is_array($msg)){
                $msg = $msg[0];
            }
            return response()->json(['message'=>$msg,'status_code'=>400], 200);
        }
        return parent::render($request, $e);
    }
}
