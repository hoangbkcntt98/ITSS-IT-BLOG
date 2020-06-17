<?php

namespace App\Http\Controllers;
use App\Comment;
use App\User;
use App\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index($id){

        $article = Article::where('id',$id)->first();
        $author = User::where('id',$article->user_id)->first();
        $comments = Comment::where('article_id','=',$id)
            ->join('users','comments.user_id','=','users.id')
            ->select( 'comments.content','comments.published_at')->get();

        return view('articles.index',['article'=>$article,'comments'=>$comments,'author'=>$author]);
    }

    public function comment(Request $request, $id){
        $new_comment = new Comment();


        $new_comment->content = $request->comment;

        $new_comment->article_id = $id;
        $new_comment->user_id = Auth::id();

        $new_comment->published_at = \Carbon\Carbon::now();

        $new_comment->save();
        return redirect()->back();
    }

    public function show_form($id){
        return view('articles.create',['product_id'=>$id]);
    }

    public function create(Request $request){
        $new_article = new Article();

        if($request->hasFile('article_image')){
            $file = $request->article_image;
            $file->move('images', $file->getClientOriginalName());
            $new_article->image = $file->getClientOriginalName();
        }
        else {
            $new_article->image = "default.jpg";
        }

        $new_article->title = $request->title;
        $new_article->product_id = $request->product_id;
        $new_article->description = $request->description;
        $new_article->content = $request->text;
        $new_article->published = 1;
        $new_article->published_at = \Carbon\Carbon::now();

        $new_article->user_id = Auth::id();
        $new_article->save();

        return redirect('/articles/'.$new_article->id);
    }
}
