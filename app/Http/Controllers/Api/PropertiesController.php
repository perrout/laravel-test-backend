<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiRestController;
use App\Http\Controllers\Controller;

class PropertiesController extends Controller
{
	use ApiRestController;

    const MODEL = '\App\Models\Property';
    const CREATE = '\App\Jobs\CreateProperty';
}
