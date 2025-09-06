<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        // CSRF Token Mismatch (419 Error) の処理
        if ($exception instanceof TokenMismatchException) {
            // お問い合わせフォーム関連のリクエストの場合
            if ($request->is('contact/*') || $request->is('/')) {
                return redirect()->route('contact.index')
                    ->with('error', 'セッションが切れました。もう一度入力してください。')
                    ->withInput();
            }

            // 管理画面関連のリクエストの場合
            if ($request->is('admin/*')) {
                return redirect()->route('login')
                    ->with('error', 'セッションが切れました。再度ログインしてください。');
            }
        }

        return parent::render($request, $exception);
    }
}
