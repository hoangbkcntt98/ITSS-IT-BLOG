<?php

namespace App\Http\Controllers;
use App\Comment;
use App\User;
use App\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class ArticleController extends Controller
{
    public function index($prod_id, $id_article){
//        dd($prod_id, $id_article);
        $article = DB::table('articles')->where('id',$id_article)->first();
        $author = User::where('id',$article->user_id)->first();
        $comments = Comment::where('article_id','=',$id_article)
            ->join('users','comments.user_id','=','users.id')
            ->select( 'comments.content','comments.published_at','users.name')->get();

        return view('articles.index',['article'=>$article,'comments'=>$comments,'author'=>$author]);
    }

    public function comment(Request $request, $prod_id, $id_article){
        $new_comment = new Comment();


        $new_comment->content = $request->comment;

        $new_comment->article_id = $id_article;
        $new_comment->user_id = Auth::id();
        $new_comment->published_at = \Carbon\Carbon::now();

        $new_comment->save();
        // add user
        $user = Auth::user();
        return response()->json(array('html'=>view('articles.comment',['comment'=>$new_comment,'user'=>$user])->render()));
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
        return redirect()->route('show_product_details', ['id' => $new_article->product_id]);
    }
}
