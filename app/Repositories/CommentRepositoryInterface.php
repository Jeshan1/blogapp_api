<?php
namespace App\Repositories;

interface CommentRepositoryInterface{
    public function get();
    public function delete(int $id):bool;
    public function createComment(array $data,$id);
}