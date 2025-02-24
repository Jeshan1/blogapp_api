<?php
namespace App\Repositories;

use App\Jobs\SendBlogNotificationJob;
use App\Models\Blog;
use Illuminate\Support\Facades\Log;

class BlogRepository implements BlogRepositoryInterface{
    public function all(){
        $blogs = Blog::with('categories')->orderBy('created_at','desc')->paginate(4);
        return $blogs;
    }

    public function find(int $id):?Blog{
        $blog= Blog::with('categories')->findOrFail($id);
        return $blog;
    }

    public function create(array $data){
        $blog = Blog::create([
                'title'=>$data['title'],
                'description'=>$data['description']
            ]);
        
            SendBlogNotificationJob::dispatch($blog);

            if(isset($data['categories'])){
                $categories = json_decode($data['categories']);
                $blog->categories()->attach($categories);
            }

            $imageUrl = null;
            if (isset($data['image'])) {
                $media = $blog->addMedia($data['image'])->toMediaCollection('blogs');
                $imageUrl = $media->getUrl();
            }

            return [
                "blog"=>$blog,
                "image"=>$imageUrl
            ];

    }

    public function update(array $data, $image, int $id)
    {
        $blog = Blog::findOrFail($id);
    
        // Ensure title and description exist
        if (!isset($data['title']) || !isset($data['description'])) {
            throw new \Exception("Title and description are required.");
        }
    
        // Update title & description
        $blog->update([
            'title' => $data['title'],
            'description' => $data['description'],
        ]);
    
        // Handle categories (Ensure JSON decoding)
        if (!empty($data['categories'])) {
            $categories = json_decode($data['categories'], true);
            if (is_array($categories)) {
                $blog->categories()->sync($categories);
            } else {
                Log::error("Invalid categories format: " . $data['categories']);
            }
        }
    
        // Handle image upload
        if ($image instanceof \Illuminate\Http\UploadedFile) {
            $blog->clearMediaCollection('blogs');
            $media = $blog->addMedia($image)->toMediaCollection('blogs');
            $imageUrl = $media->getUrl();
        } else {
            $imageUrl = null;
            Log::error("Invalid image file type: " . gettype($image));
        }
    
        // Log updated blog
        Log::info("Updated Blog: " . json_encode($blog));
    
        return [
            'blog' => $blog,
            'imageUrl' => $imageUrl,
        ];
    }
    

    public function delete(int $id): bool
    {
        $blog = Blog::findOrFail($id);
        $deleted = $blog->delete();
        if ($deleted) {
            $blog->clearMediaCollection('blogs');
            return true;
        }
        return false;
        
    }
}