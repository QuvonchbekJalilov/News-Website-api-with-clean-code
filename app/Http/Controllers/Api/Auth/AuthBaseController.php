<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\Api\UserRepository;

class AuthBaseController extends Controller
{
    public function __construct(protected UserRepository $repository) {}
}
