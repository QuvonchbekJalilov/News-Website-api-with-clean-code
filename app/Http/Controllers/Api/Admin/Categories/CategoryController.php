<?php

namespace App\Http\Controllers\Api\Admin\Categories;


use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Traits\ApiResponseTrait;

class CategoryController extends CategoryBaseController
{
    use ApiResponseTrait;

    public function index()
    {
        try {
            $categories = $this->repository->index();
            return $this->successResponse($categories, 'Categories retrieved successfully.');
        } catch (\Exception $exception) {
            return $this->errorResponse('An error occurred while retrieving categories.', 500);
        }
    }

    public function show($id)
    {
        try {
            $category = $this->repository->show($id);
            if (!$category) {
                return $this->errorResponse('Category not found.', 404);
            }
            return $this->successResponse($category, 'Category retrieved successfully.');
        } catch (\Exception $exception) {
            return $this->errorResponse('An error occurred while retrieving the category.', 500);
        }
    }
    public function store(StoreCategoryRequest $request)
    {
        try {

            $category = $this->repository->store($request->validated());
            return $category;
        } catch (\Exception $exception) {
            return $this->errorResponse('An error occurred while creating the category.', 500);
        }
    }
    public function update(UpdateCategoryRequest $request, $id)
    {
        try {
            $category = $this->repository->update($id, $request->validated());
            return $category;
        } catch (\Exception $exception) {
            return $this->errorResponse('An error occurred while updating the category.', 500);
        }
    }
    public function destroy($id)
    {
        try {
            $category = $this->repository->delete($id);
            return $category;
        } catch (\Exception $exception) {
            return $this->errorResponse('An error occurred while deleting the category.', 500);
        }
    }
    public function forceDelete($id)
    {
        try {
            $category = $this->repository->forceDelete($id);
            return $category;
        } catch (\Exception $exception) {
            return $this->errorResponse('An error occurred while permanently deleting the category.', 500);
        }
    }
    public function restore($id)
    {
        try {
            $category = $this->repository->restore($id);
            return $category;
        } catch (\Exception $exception) {
            return $this->errorResponse('An error occurred while restoring the category.', 500);
        }
    }
}
