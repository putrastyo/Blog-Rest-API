<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $articleId = $request->route('articleId');

        $comments = Comment::with(['user', 'article'])->where('article_id', $articleId)->get();

        return response()->json($comments);
    }

    public function comment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required'
        ]);

        $articleId = $request->route('articleId'); // Get parameter Article ID

        $comment = new Comment();
        $comment->content = $request->content;
        $comment->article_id = $articleId;
        $comment->user_id = auth()->user()->id;
        $comment->save();

        return response()->json(['message' => 'Comment created successfuly']);
    }

    public function destroy(Request $request)
    {
        $commentId = $request->route('commentId'); // Get parameters Comment Id

        $comment = Comment::find($commentId);

        if(!$comment){
            return response()->json(['message' => 'Comment not found'], 404);
        }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfuly']);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required'
        ]);

        $commentId = $request->route('commentId');
        $articleId = $request->route('articleId');

        $comment = Comment::where('id', $commentId)->first();
        $comment->content = $request->content;
        $comment->article_id = $articleId;
        $comment->user_id = auth()->user()->id;
        $comment->save();

        return response()->json(['message' => 'Comment updated successfuly']);
    }
}
