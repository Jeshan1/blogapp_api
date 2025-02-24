<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

use function App\Helper\apiResponse;
use function App\Helper\handleException;

class CategoryController extends Controller
{
    protected $categoryrepository;
    public function __construct(CategoryRepository $categoryrepository)
    {
        $this->categoryrepository = $categoryrepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return handleException(function(){
            $categories = $this->categoryrepository->all();
            return apiResponse($categories,"Category fetched successfully",200);
        });
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return handleException(function() use($request){
            $category = $request->all();
            $data = $this->categoryrepository->create($category);
            return apiResponse($data,"Category Created Successfully",201);
        }); 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return handleException(function() use($request,$id){
            $data = $request->all();
            $updatedData = $this->categoryrepository->update($data,$id);
            return apiResponse($data,"Category Updated Successfully",201);
        });
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return handleException(function() use ($id){
            $deletedCategory = $this->categoryrepository->delete($id);
            //check it the category is associated with the blogs
            if (!$deletedCategory) {
                return apiResponse("Category associated with blogs",102);
            }
       
            return apiResponse($deletedCategory,"Category Deleted Successfully",201);
        });
        
    }
}
