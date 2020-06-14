<?php

namespace App\Http\Controllers;
use App\Comment;
use App\User;
use App\Article;

class ArticleController extends Controller
{
    public function index($id){
//        $article = DB::table('article')->where('id',$id)->first();
        $article = Article::where('id',$id)->first();
        $author = User::where('id',$article->user_id)->first();
        $comments = Comment::where('article_id',$id)->get();
        return view('articles.index',['article'=>$article,'comments'=>$comments,'author'=>$author]);
    }

    public function comment($request){
        $new_comment = new Comment();

        $new_comment->content = "hohohha";
        $new_comment->article_id = 1;
        $new_comment->user_id = 1;
        $new_comment->published_at = "2020/07/14";
        $new_comment->user_name = User::where('id',$new_comment->user_id)->get('name');

        $new_comment->save();
        return redirect()->back();
    }

    public function createNew(){

    }
}
