<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::where('status', 'published')
                           ->with('author')
                           ->latest()
                           ->paginate(12);
                           
        return view('owner.articles.index', compact('articles'));
    }

    public function show(Article $article)
    {
        if ($article->status !== 'published') {
            abort(404);
        }
        
        return view('owner.articles.show', compact('article'));
    }
}
