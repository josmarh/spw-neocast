<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Resources\ArticleResource;
use App\Models\Articles;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        return ArticleResource::collection(Articles::paginate(10));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string'
        ]);

        Articles::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'ahash' => strtolower(Str::random(32))
        ]);

        return response([
            'message' => 'Article created!'
        ], 201);
    }

    public function edit(Request $request, $id)
    {
        $article = Articles::findOrFail($id);

        return response([
            'data' => new ArticleResource($article)
        ]);
    }

    public function update(Request $request, $id)
    {
        $article = Articles::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string'
        ]);

        $article->update([
            'title' => $data['title'],
            'content' => $data['content']
        ]);

        return response([
            'message' => 'Article updated!'
        ]);
    }

    public function delete($id)
    {
        $article = Articles::findOrFail($id);

        $article->delete();

        return response([
            'message' => 'Article deleted!'
        ]);
    }

    public function show(Request $request, $name)
    {
        $article = Articles::findOrFail(explode('-', $name)[0]);

        return response([
            'data' => new ArticleResource($article)
        ]);
    }

    public function terms()
    {
        return view('terms');
    }
}
