<?php
namespace App\Repositories;

use App\Models\Blog;
use Illuminate\Support\Facades\Request;

interface BlogRepositoryInterface{
    public function all();
    public function find(int $id);
    public function create(array $data);
    public function update(array $data,$image, int $id);
    public function delete(int $id):bool;
}