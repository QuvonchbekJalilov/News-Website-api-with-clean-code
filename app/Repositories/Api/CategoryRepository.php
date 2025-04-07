<?php

namespace App\Repositories\Api;

use App\Http\Resources\CategoryResource;
use App\Interfaces\CategoryInterface;
use App\Models\Category;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Collection;

class CategoryRepository implements CategoryInterface
{
    use ApiResponseTrait;
    public function __construct(protected Category $model) {}

    // Get all categories
    public function index()
    {
        try {
            $categories = $this->model::all();
            return $this->successResponse(CategoryResource::collection($categories), 'Categories retrieved successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve categories: ' . $e->getMessage(), 500);
        }
    }

    // Get a single category
    public function show($id)
    {
        try {
            $category = $this->model::findOrFail($id);
            return $this->successResponse(new CategoryResource($category), 'Category retrieved successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve category: ' . $e->getMessage(), 500);
        }
    }

    // Create a new category
    public function store(array $data)
    {
        try {
            $category = $this->model::create($data);
            return $this->successResponse(new CategoryResource($category), 'Category created successfully.', 201);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while creating the category.', 500);
        }
    }

    // Update a category
    public function update($id, array $data)
    {
        try {
            $category = $this->model::findOrFail($id);
            $category->update($data);
            return $this->successResponse(new CategoryResource($category), 'Category updated successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while updating the category.', 500);
        }
    }

    // Delete a category
    public function delete($id)
    {
        try {
            $category = $this->model::findOrFail($id);
            $category->delete();
            return $this->successResponse(null, 'Category deleted successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while deleting the category.', 500);
        }
    }

    // Force delete a category
    public function forceDelete($id)
    {
        try {
            $category = $this->model::withTrashed()->findOrFail($id);
            $category->forceDelete();
            return $this->successResponse(null, 'Category permanently deleted successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while permanently deleting the category.', 500);
        }
    }

    // Restore a deleted category
    public function restore($id)
    {
        try {
            $category = $this->model::withTrashed()->findOrFail($id);
            $category->restore();
            return $this->successResponse(new CategoryResource($category), 'Category restored successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while restoring the category.', 500);
        }
    }
}
