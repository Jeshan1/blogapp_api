<?php
namespace App\Repositories;
use App\Models\Category;

interface CategoryRepositoryInterface{
    public function all();
    public function find(int $id):?Category;
    public function create(array $data):Category;
    public function update(array $data,int $id):Category;
    public function delete(int $id):?bool;
}