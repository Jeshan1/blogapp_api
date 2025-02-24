<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Repositories\CommentRepository;
use Illuminate\Http\Request;

use function App\Helper\apiResponse;
use function App\Helper\handleException;

class CommentController extends Controller
{
    protected $commentrepository;

    public function __construct(CommentRepository $commentrepository)
    {
        $this->commentrepository = $commentrepository;
    }
    public function index(){

        return handleException(function(){
            $comments = $this->commentrepository->get();
            if ($comments) {
                return apiResponse($comments,"Comments fetched successfully",200);
            }
    
            return apiResponse([],"Comments Not found.",404);
        });

    }

    public function destroy($id){
        return handleException(function() use($id){
            $deleted = $this->commentrepository->delete($id);

            if ($deleted) {
                return apiResponse($deleted,"Comment deleted successfully",201);
            }

            return apiResponse([],"Error Occured when deleting comment",400);
        });
    }

    public function create(Request $request,$id){
        
        return handleException(function() use($request,$id){
            // Validate the incoming request data
            $data = $request->validate([
                'name' => 'required|string',
                'comment' => 'required|string',
            ]);

            $postedComment = $this->commentrepository->createComment($data, $id);
            
            // Check if the comment was successfully posted
            if ($postedComment) {
                return apiResponse($postedComment,"Comment posted successfully",201);
            }
    
            return apiResponse([],"Error occured when posting comment",400);
        });

    }

    public function getClientComments($id){
        return handleException(function() use($id){
            $comments = Comment::where('blog_id', $id)->get();
        
            if (!empty($comments)) {
                return apiResponse($comments,"Comment fetched successfully",200);
            }

            return apiResponse([],"No any comments found in this blog",404);
        });

    }
}
