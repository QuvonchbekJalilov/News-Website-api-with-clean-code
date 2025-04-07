<?php 

namespace App\Interfaces;

interface CategoryInterface
{
    public function index();
    public function show($id);
    public function store(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function forceDelete($id);
    public function restore($id);
}