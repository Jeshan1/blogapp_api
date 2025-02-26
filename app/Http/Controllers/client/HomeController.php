<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Message;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


use function App\Helper\apiResponse;
use function App\Helper\handleException;

class HomeController extends Controller
{
    public function getBlogs(){
        return handleException(function(){
            $blogs = Blog::with('categories')->orderBy('created_at','desc')->take(8)->get();
            $blogs->transform(function ($blog) {
                $blog->image = $blog->getFirstMediaUrl('blogs'); // Get image URL
                return $blog;
            });

            if (!empty($blogs)) {
                return apiResponse($blogs,"Blog fetched successfully",200);
            }
            return apiResponse([],"Blog Not found",400);
        });
    }

    public function singleBlog($id)
    {
        return handleException(function() use($id){
            $blog = Blog::with('categories')->findOrFail($id);
            $recentBlogs = Blog::with('categories')->orderBy('created_at','desc')->take(5)->get();
            $blog->image = $blog->getFirstMediaUrl('blogs');
            return response()->json([
                'message'=>'Single Blog fetched successfully',
                "statusCode"=>200,
                "blog"=>$blog,
                "recentBlogs"=>$recentBlogs
            ]);
        });

    }

    public function searchBlogs(Request $request)
    {
        try {
            // Get the search query parameter
            $search = $request->query('search');

            if (empty($search)) {
                return response()->json([
                    "message" => "Search parameter is required.",
                    "statusCode" => 400,
                ], 400);
            }

            // Search blogs by title or description or category or date
            $blogs = Blog::where('title', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%')
                        ->orWhereHas('categories', function($q) use($search){
                            $q->where('cat_name','like','%' . $search . '%');
                        })
                        ->orWhereDate('created_at','like','%' . $search . '%')
                        ->get();
            
            $blogs->transform(function ($blog) {
                $blog->image = $blog->getFirstMediaUrl('blogs'); // Get image URL
                return $blog;
            });

            return response()->json([
                "message" => "Blogs searched successfully.",
                "statusCode" => 200,
                "data" => $blogs,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                "message" => "An error occurred while searching blogs.",
                "statusCode" => 500, 
                "error" => $e->getMessage(),
            ], 500);
        }
    }

    public function welcomeMessage(){
       
        return handleException(function(){
            $message = Message::latest()->first();
            return apiResponse($message,"Welcome Message Fetched Successfully",200);
        });

    }

    


}
