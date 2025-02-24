<?php


namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Metadata;
use Illuminate\Support\Facades\Auth;

use function App\Helper\apiResponse;
use function App\Helper\handleException;

class MetaDataController extends Controller
{
    public function incrementViews($blogId)
    {
        return handleException(function() use($blogId){

            $metadata = Metadata::findOrFail($blogId);
            if (!$metadata) {
                // If no metadata record exists for the blog, create one
                $metadata = Metadata::create([
                    'blog_id' => $blogId,
                    'user_id' => null, // Since authentication is not required, set user_id to null
                ]);
            }
            // Increment views count
            $views = $metadata->increment('views');
        
            // Return the updated view count
            return apiResponse($views,"view count updated",201);

        });

    }


    public function like($blogId)
    {
        return handleException(function() use($blogId){
            $userId = Auth::id(); // Get authenticated user ID

            // Fetch the metadata for the blog and the user
            $metadata = Metadata::firstOrCreate(
                ['blog_id' => $blogId, 'user_id' => $userId],
                ['likes' => 0, 'dislikes' => 0, 'views' => 0] // Default values if no record found
            );

            // If the user has already disliked, set dislikes to 0
            if ($metadata->dislikes > 0) {
                $metadata->dislikes = 0;
            }

            // Set the user's like to 1 (liked)
            $metadata->likes = 1;
            
            // Save the metadata record
            $metadata->save();
    
            return response()->json([
                'message' => 'Blog liked successfully',
                'status' => 201,
                'likes' => $metadata->likes,
                'dislikes' => $metadata->dislikes
            ]);
        });

    }


    public function dislike($blogId)
    {
        return handleException(function() use($blogId){
            $userId = Auth::id(); // Get authenticated user ID

            // Fetch the metadata for the blog and the user
            $metadata = Metadata::firstOrCreate(
                ['blog_id' => $blogId, 'user_id' => $userId],
                ['likes' => 0, 'dislikes' => 0, 'views' => 0] // Default values if no record found
            );

            // If the user has already liked, set likes to 0
            if ($metadata->likes > 0) {
                $metadata->likes = 0;
            }

            // Set the user's dislike to 1 (disliked)
            $metadata->dislikes = 1;

            // Save the metadata record
            $metadata->save();

            return response()->json([
                'message' => 'Blog disliked successfully',
                'status' => 201,
                'likes' => $metadata->likes,
                'dislikes' => $metadata->dislikes
            ]);
        });

    }



    // public function getMetadata($blogId)
    // {
    //     return handleException(function() use($blogId){
    //         // Retrieve the metadata for the blog
    //         $metadata = Metadata::where('blog_id', $blogId)->get();

    //         // If no metadata exists, return default values
    //         if (!$metadata) {
    //             return response()->json([
    //                 'views' => 0,
    //                 'likes' => 0,
    //                 'dislikes' => 0,
    //             ]);
    //         }

    //         // Return existing metadata
    //         return response()->json([
    //             'views' => $metadata->views,
    //             'likes' => $metadata->likes,
    //             'dislikes' => $metadata->dislikes,
    //         ]);
    //     });
    // }

    public function getMetadata($blogId)
    {
        return handleException(function() use ($blogId) {
            // Aggregate total likes and dislikes for the blog
            $totals = Metadata::where('blog_id', $blogId)
                ->selectRaw('SUM(likes) as total_likes, SUM(dislikes) as total_dislikes, SUM(views) as total_views')
                ->first();

            // Return the computed totals
            return response()->json([
                'total_likes' => $totals->total_likes ?? 0,
                'total_dislikes' => $totals->total_dislikes ?? 0,
                'total_views' => $totals->total_views ?? 0,
            ]);
        });
    }


}
