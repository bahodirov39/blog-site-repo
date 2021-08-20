<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentLikeController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\UserPageController;
use App\Http\Controllers\WritersController;
use App\Models\CommentLike;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use TCG\Voyager\Facades\Voyager;

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

// BOOKMARK
Route::get('/addbookmark/{blog_id}', [BookmarkController::class, 'addBookmark'])->name('addBookmark');
Route::get('/delbookmark/{blog_id}', [BookmarkController::class, 'deleteBookmark'])->name('deleteBookmark');
Route::get('/userpage/bookmark', [BookmarkController::class, 'index'])->name('indexBookmark');

// LIKE 
Route::get('/addlike/{blog_id}', [LikeController::class, 'addLike'])->name('addLike');
Route::get('/dellike/{blog_id}', [LikeController::class, 'deleteLike'])->name('deleteLike');
Route::get('/userpage/like', [LikeController::class, 'index'])->name('indexLikes');

// COMMENTLIKE
Route::get('/addcommentlike/{blog_id}/{comment_id}', [CommentLikeController::class, 'addCommentLike'])->name('addCommentLike');

// COMMENT
Route::post('/comment/{blog_id}/{slug}', [CommentController::class, 'createComment'])->name('createComment');
Route::get('/delcomment/{comment_id}', [CommentController::class, 'deleteComment'])->name('deleteComment');

// FOLLOW
Route::get('/addfollow/{from_user_id}/{to_user_id}', [FollowController::class, 'addFollow'])->name('addFollow');
Route::get('/delfollow/{from_user_id}/{to_user_id}', [FollowController::class, 'delFollow'])->name('delFollow');
Route::get('/follows', [FollowController::class, 'index'])->name('followIndex');
Route::get('/followers', [FollowController::class, 'followers'])->name('followers');

// USERPAGE
Route::resource('userpage', UserPageController::class);

// FEED
Route::get('/feed', [UserPageController::class, 'feed'])->name('feed');

// WRITERS
Route::resource('writers', WritersController::class);

// BLOG
Route::resource('blog', BlogController::class);
Route::get('/search/', [BlogController::class, 'search'])->name('search');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});