<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\HomeController;
use \App\Http\Controllers\HomePageController;
use \App\Http\Controllers\PostController;
use \App\Http\Controllers\CategoryController;
use \App\Http\Controllers\ProfileController;
use \App\Http\Controllers\SettingsController;
use \App\Http\Controllers\CommentsController;
use \App\Http\Controllers\DeleteController;
use \App\Http\Controllers\SearchController;

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


Auth::routes(['verify' => true]);

Route::prefix('admin')->group(function () {
        Route::get('/', function () {
                return view("admin.dashboard");
        });
});

Route::get('/', [HomePageController::class, 'index']);
Route::get('/posts', [HomeController::class, 'index'])
        ->name('home');
Route::resource('/posts', PostController::class)
        ->middleware('auth');
Route::resource('/posts', PostController::class)
        ->only('show')
        ->withoutMiddleware('auth');
Route::resource('/categories', CategoryController::class);
Route::get('/{username}', [ProfileController::class, 'index']);
Route::resource('/settings', SettingsController::class)
        ->only('edit', 'update')
        ->middleware(['auth', 'SettingsChecker', 'password.confirm']);
Route::resource('/users/comments', CommentsController::class);
Route::get('posts/delete/{id}', [DeleteController::class, 'destroy'])
        ->name('delete');
Route::get('/users/comments/{id}', [DeleteController::class, 'destroyComment'])
        ->name('delete.comment');
Route::get('/user/delete/{id}', [DeleteController::class, 'deleteUser'])
        ->name('delete.user');
Route::any('/search/posts/', [SearchController::class, 'index'])
        ->name('search');
Route::fallback(function() {
    return view("errors.404");
});
