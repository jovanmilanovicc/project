<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminPostsController;
use App\Http\Controllers\HomneController;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
Route::get('/home',[HomneController::class,'home'])->name('home');

Route::get('/contact',[MailController::class,'index'])->name('contact');
Route::post('contact/send',[MailController::class,'sendEmail'])->name('send.email');

Route::get('/about',function(){
    return view('home.about');
})->name('about');

Route::get('posts',[HomneController::class,'index'])->name('posts.index');
Route::get('post/{slug}',[HomneController::class,'show'])->name('post.detail');
Route::get('profile/user/{slug}',[HomneController::class,'userProfile'])->name('user.profile');
Route::post('profile/user/{slug}/update',[HomneController::class,'profileUpdate'])->name('profile.update');
Route::get('users/posts',[HomneController::class,'userPosts'])->name('posts.user');
Route::get('users/post/create',[HomneController::class,'create'])->name('user.post.create');
Route::get('users/post/{slug}/edit',[HomneController::class,'edit'])->name('user.posts.edit');
Route::patch('users/post/{slug}/update',[HomneController::class,'update'])->name('users.posts.update');
Route::delete('users/post/{slug}/delete',[HomneController::class,'destroy'])->name('users.posts.delete');
Route::delete('post/comment/{id}/delete',[HomneController::class,'deleteComment'])->name('comment.delete');
Route::post('comment/create/{post_id}',[HomneController::class,'commentCreate'])->name('comment.create');




Route::group(['middleware'=>'admin'],function(){
    Route::get('/admin',[AdminController::class,'index'])->name('admin');
    Route::get('admin/users',[AdminController::class,'allUsers'])->name('admin.users');
    Route::get('admin/users/create',[AdminController::class,'create'])->name('admin.create');
    Route::post('admin/users/s',[AdminController::class,'store'])->name('admin.store');
    Route::get('admin/users/{slug}/edit',[AdminController::class,'edit'])->name('admin.edit');
    Route::patch('admin/users/{slug}/update',[AdminController::class,'update'])->name('admin.update');
    Route::delete('admin/users/{slug}/delete',[AdminController::class,'destroy'])->name('admin.delete');
    Route::get('admin/posts',[AdminPostsController::class,'index'])->name('admin.posts');
    Route::get('admin/posts/create',[AdminPostsController::class,'create'])->name('admin.posts.create');
    Route::post('admin/posts/store',[AdminPostsController::class,'store'])->name('admin.posts.store');
    Route::get('admin/posts/{slug}/edit',[AdminPostsController::class,'edit'])->name('admin.posts.edit');
    Route::patch('admin/posts/{slug}/update',[AdminPostsController::class,'update'])->name('admin.posts.update');
    Route::delete('admin/posts/{slug}/delete',[AdminPostsController::class,'destroy'])->name('admin.posts.delete');

});





