<?php

namespace App\Http\Controllers\Admin;

use App\Models\Interpreter;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InterpreterController extends Controller
{
    use ApiResponser;

    /**
     * @return mixed
     */
    public function index()
    {
        $interpreters = Interpreter::get();

        return $this->successResponse($interpreters->toArray());
    }
}
