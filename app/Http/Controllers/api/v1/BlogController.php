<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Repositories\BlogRepository;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use function App\Helper\apiResponse;
use function App\Helper\handleException;

class BlogController extends Controller
{
    protected $blogrepository, $categoryRepository;

    public function __construct(BlogRepository $blogrepository, CategoryRepository $categoryRepository)
    {
        $this->blogrepository = $blogrepository;
        $this->categoryRepository = $categoryRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return handleException(function(){
            $blogs = $this->blogrepository->all();
            $blogs->getCollection()->transform(function ($blog) {
                $blog->image = $blog->getFirstMediaUrl('blogs'); // Get image URL
                return $blog;
            });
            return apiResponse($blogs,"Blog fetched successfully",200);
        });
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return handleException(function() use($request){
            $data = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'categories' => 'nullable', // Accept JSON string
                'image' => 'nullable|image|mimes:png,jpg,jpeg|max:27008',
            ]);

            $data = $this->blogrepository->create($data);
            
            if ($data) {
                return apiResponse($data,"Blog created successfully",200);
            }
            
            return apiResponse([], "Error occurred while creating new blog.", 500);
            
        });
        
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        // Debugging: Log request data and files
        // Log::info('Request Data:', $request->all());
        // Log::info('Uploaded Files:', $request->file());

        return handleException(function() use($request,$id){
            $data = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'categories' => 'nullable', // Accept JSON string
                'image' => 'nullable|image|mimes:png,jpg,jpeg|max:27008',
            ]);

            $image = $request->file('image');

            $blog = $this->blogrepository->update($data, $image, $id);

            // If update was successful, return response
            if ($blog) {
                return apiResponse($blog,"Blog updated successfully",201);
            }

            return apiResponse([],"Something Went Wrong",400,["error"=>"something Went Wront.please try again later."]);
        });

        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        
        return handleException(function() use($id){

            $deleted = $this->blogrepository->delete($id);
            if ($deleted) {
                return apiResponse($deleted,"Blog deleted successfully",201);
            }
            return apiResponse([],"Something went wront",400,["error"=>"Something went wront. Please try again later"]);
        });

        
    }
}
