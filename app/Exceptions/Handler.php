<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Database\Eloquent\MassAssignmentException;

class Handler extends ExceptionHandler
{
    use ApiResponser;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        ModelNotFoundException::class,
        ValidationException::class
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

    /**
     * Report or log an exception.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if (substr($request->path(), 0, 4) === 'http:') {
            return false;
        }

        if ($exception instanceof ModelNotFoundException) {
            $model = strtolower(class_basename($exception->getModel()));
            return $this->errorResponse("Does not exits any instance of {$model} with the given", 404);
        }
        if ($exception instanceof AuthorizationException) {
            return $this->errorResponse($exception->getMessage(), 403);
        }
        if ($exception instanceof AuthenticationException) {
            return $this->errorResponse("Please login again", 401);
        }
        if ($exception instanceof ValidationException) {
            return $this->errorResponse($exception->validator->errors()->getMessages(), 414);
        }
        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse("Method not allowed", 405);
        }
        if ($exception instanceof QueryException) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
        if ($exception instanceof TokenInvalidException) {
            return $this->errorResponse("Token valid", 463);
        }
        if ($exception instanceof TokenExpiredException) {
            return $this->errorResponse("Token expired", 406);
        }
        if ($exception instanceof JWTException) {
            return $this->errorResponse($exception->getMessage(), 410);
        }
        if ($exception instanceof UnauthorizedHttpException) {
            return $this->errorResponse($exception->getMessage(), 406);
        }
        if ($exception instanceof FatalErrorException) {
            return $this->errorResponse($exception->getMessage(), 407);
        }
        if ($exception instanceof MassAssignmentException) {
            return $this->errorResponse($exception->getMessage(), 408);
        }
        if ($exception instanceof ErrorException) {
            return $this->errorResponse($exception->getMessage(), 409);
        }
        if ($exception instanceof InvalidArgumentException) {
            return $this->errorResponse($exception->getMessage(), 411);
        }
        if ($exception instanceof NotFoundHttpException) {
            return $this->errorResponse("URL not found", 415);
        }

        if (env('APP_DEBUG') == false) {
            return parent::render($request, $exception);
        }

        if (env('APP_DEBUG') == true && !$exception instanceof NotFoundHttpException) {
            throw $exception;
        }

        return $this->errorResponse("Unexpected error. Try later \n", $exception->getCode());
    }
}
