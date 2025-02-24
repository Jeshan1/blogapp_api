<?php
namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository implements CategoryRepositoryInterface{
    public function all(){
        return Category::orderBy('created_at','desc')->paginate(4);
    }

    public function find(int $id):?Category{
        return Category::findOrFail($id);
    }

    public function create(array $data):Category{
        return Category::create($data);
    }

    public function update(array $data, int $id):Category{
        $category = Category::findOrFail($id);
        $category->update($data);
        return $category;
    }

    public function delete(int $id):bool{
        $category = Category::findOrFail($id);
        if (!$category) {
            return false;
        }

        if($category->blogs()->exists()) {
            return false;
        }
        
        $category->delete();
        return true;
    }
}