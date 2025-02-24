<?php

use App\Http\Controllers\api\v1\AuthController;
use App\Http\Controllers\api\v1\BlogController;
use App\Http\Controllers\api\v1\CategoryController;
use App\Http\Controllers\api\v1\CommentController;
use App\Http\Controllers\api\v1\ContactController;
use App\Http\Controllers\api\v1\DashboardController;
use App\Http\Controllers\api\v1\MetaDataController;
use App\Http\Controllers\BlogPdfController;
use App\Http\Controllers\client\HomeController;
use App\Http\Controllers\SocialAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['auth:sanctum','role:admin'])->group(function(){
    Route::get('/dashboard',[DashboardController::class, 'index']);
    Route::get('/available-years',[DashboardController::class, 'getAvailableYears']);
    Route::get('/getblog-analytics',[DashboardController::class, 'getBlogAnalytics']);
    Route::apiResource('category',CategoryController::class);
    Route::apiResource('blog', BlogController::class);
    Route::get('/contacts',[ContactController::class,'index']);
    Route::delete('/contacts/{id}',[ContactController::class,'delete']);
    Route::get('/comments',[CommentController::class,'index']);
    Route::delete('/comments/{id}',[CommentController::class,'destroy']);
});

Route::post('/register',[AuthController::class,'register'])->name('register');
Route::post('/login',[AuthController::class,'login'])->name('login');
Route::delete('/logout',[AuthController::class,'logout'])->name('logout');
Route::post('/send-reset-password-email',[AuthController::class, 'send_reset_password_email']);
Route::post('/reset-password/{token}',[AuthController::class, 'reset_password']);
Route::get('/auth/google', [SocialAuthController::class, 'redirectToProvider']);
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleProviderCallback']);

//client
Route::group(['prefix'=>'client'], function(){
    Route::get('/blogs',[HomeController::class, 'getBlogs']);
    Route::get('/blogs/search',[HomeController::class, 'searchBlogs']);
    Route::get('/blogs/{id}',[HomeController::class, 'singleBlog']);
    Route::post('/blogs/{id}/download-pdf',[HomeController::class,'downloadBlogPdf']);

    //contact
    Route::post('/contact',[ContactController::class,'create']);
    //likes,dislikes,views
    Route::get('/blog/metadata/{blogId}', [MetaDataController::class, 'getMetadata']);
    Route::post('/blog/view/{blogId}', [MetadataController::class, 'incrementViews']);
    Route::post('/blog/like/{blogId}', [MetadataController::class, 'like'])->middleware('auth:sanctum');
    Route::post('/blog/dislike/{blogId}', [MetadataController::class, 'dislike'])->middleware('auth:sanctum');

    //comment
    Route::post('/comment/{id}',[CommentController::class,'create'])->middleware('auth:sanctum');
    Route::get('/comment/{id}',[CommentController::class,'getClientComments']);

    //download blog pdf
    Route::get('/blog/{id}/pdf', [BlogPdfController::class, 'generateBlogPdf']);

});

