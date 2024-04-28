<?php

use App\Http\Controllers\api\ArticleController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CommentController;
use App\Http\Middleware\CheckToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/register', [AuthController::class, 'register']);

Route::get('articles', [ArticleController::class, 'index']);
Route::get('articles/{articleId}', [ArticleController::class, 'show']);

Route::get('articles/{articleId}/comments', [CommentController::class, 'index']);

Route::middleware([CheckToken::class])->group(function() {
    // Auth
    Route::get('auth/logout', [AuthController::class, 'logout']);
    Route::get('auth/current', [AuthController::class, 'current']);

    // Article
    Route::post('articles', [ArticleController::class, 'store']);
    Route::put('articles/{articleId}', [ArticleController::class, 'update']);
    Route::delete('articles/{articleId}', [ArticleController::class, 'destroy']);

    // Comment
    Route::post('articles/{articleId}/comments', [CommentController::class, 'comment']);
    Route::delete('articles/{articleId}/comments/{commentId}', [CommentController::class, 'destroy']);
    Route::put('articles/{articleId}/comments/{commentId}', [CommentController::class, 'update']);
});
