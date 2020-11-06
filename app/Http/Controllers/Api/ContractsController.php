<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiRestController;
use App\Http\Controllers\Controller;

class ContractsController extends Controller
{
    use ApiRestController;

    const MODEL = 'App\Models\Contract';
}
