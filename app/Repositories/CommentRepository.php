<?php 
namespace App\Repositories;

use App\Models\Comment;

class CommentRepository implements CommentRepositoryInterface{
    public function get(){
        $comments = Comment::orderBy('created_at','desc')->paginate(10);
        return $comments;
    }

    public function delete($id):bool{
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return true;
    }

    public function createComment(array $data, $id)
    {
        $data['blog_id'] = $id;
        return Comment::create($data);
    }


}