<?php

namespace App\Http\Controllers\Api\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Repositories\Api\CategoryRepository;

class CategoryBaseController extends Controller
{
    public function __construct(protected CategoryRepository $repository) {}
}
