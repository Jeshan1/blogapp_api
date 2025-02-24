<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Http\Request;

use function App\Helper\apiResponse;
use function App\Helper\handleException;

class DashboardController extends Controller
{
    public function index(){
        try {
            $totalComments = Comment::count();
            $totalContacts = Contact::count();
            $totalCategories = Category::count();
            $totalBlogs = Blog::count();
            
            return response()->json([
                "message"=>"Dashboard card fetched successfully",
                "statusCode"=>200,
                "data"=>[
                    "comments"=>$totalComments,
                    "blogs"=>$totalBlogs,
                    "categories"=>$totalCategories,
                    "contacts"=>$totalContacts
                ]
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                "message"=>$e->getMessage(),
                "statusCode"=>500,
                "status"=>"error"
            ]);
        }
    }

    public function getAvailableYears(){

        $years = Blog::selectRaw("YEAR(created_at) as year")
                    ->distinct()
                    ->orderBy("year",'desc')
                    ->pluck("year");
        
        return response()->json([
            "message"=>"Available years fetched",
            "statusCode"=>200,
            "data"=>$years
        ]);

    }

    public function getBlogAnalytics(Request $request)
    {
        return handleException(function() use($request){
            $year = $request->query('year', Carbon::now()->year); // Default: current year
            $type = $request->query('type', 'daily'); // Default: daily

            if ($type === 'daily') {                        //daily aggregation
                $blogData = Blog::selectRaw('DATE(created_at) as date, COUNT(*) as total')
                    ->whereYear('created_at', $year)
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get();
            }
            else {                                              // Monthly aggregation
                $blogData = Blog::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as total')
                    ->whereYear('created_at', $year)
                    ->groupBy('month')
                    ->orderBy('month')
                    ->get();
            }
            return apiResponse($blogData,'',200);
        });

    }
}
