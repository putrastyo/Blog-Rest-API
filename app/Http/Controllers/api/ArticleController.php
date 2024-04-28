<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Article::query();

        // get query parameter user_id: /api/articles?user_id=1
        if($request->has('user_id')){
            $query->where('user_id', $request->input('user_id'));
        }

        $articles = $query->with('user')->get();

        return response()->json($articles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'category' => 'required'
        ]);
        if($validator->fails()){
            return response()->json(['message' => 'Invalid field'], 400);
        }

        $article = new Article();
        $article->title = $request->title;
        $article->content = $request->content;
        $article->category = $request->category;
        $article->user_id = auth()->user()->id;
        $article->save();

        return response()->json(['message' => 'Create article successfuly'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $article = Article::with('user')->find($id);
        if(!$article){
            return response()->json(['message' => 'Article not found'], 404);
        }
        return response()->json($article);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'category' => 'required'
        ]);
        if($validator->fails()){
            return response()->json(['message' => 'Invalid field'], 400);
        }

        $article = Article::find($id);
        $article->title = $request->title;
        $article->content = $request->content;
        $article->category = $request->category;
        $article->user_id = auth()->user()->id;
        $article->save();

        return response()->json(['message' => 'article updated successfuly']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $article = Article::find($id);

        if(!$article){
            return response()->json(['message' => 'Article not found'], 404);
        }

        $article->delete();

        return response()->json(['message' => 'Article deleted successful']);
    }
}
