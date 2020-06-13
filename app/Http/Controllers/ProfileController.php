<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function index()
    {
        $id = Auth::id();
        $user = User::findOrFail($id);
        $posts =  DB::table('article')->join('users','article.user_id','=','users.id')->join('product','article.product_id','=','product.id')->select('name', 'article.id','product_name','article.created_at','article.updated_at','article.title')->get();
        $user_article = collect([]);
        $users = User::all();
        $product = DB::table('product')->get();
        return view('users.index',['user'=>$user,'users'=>$users,'posts'=>$posts,'products'=>$product]);        
    }  
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.update',['user'=>$user]);        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $user = User::findOrFail($id);
        $hashedPassword = $user->password;
        $user->name = $request->input('name');
        $user->is_admin = $request->input('is_admin');
        if(Hash::check($request->input('password'),$hashedPassword)!=true)
        {
            if(($request->input('password'))==($request->input('password-confirm')))
            {
               $user->fill([
                    'password' => Hash::make($request->input('password'))
                ])->save();
            }
        }
        $user->save();
        return redirect('user');
    }
    public function search(Request $request)
    {
        $id = Auth::id(); 
        if ($request->ajax()) {
            $output = '';
            $users = DB::table('users')->where([['name', 'LIKE', '%' . $request->search . '%']])->get();
            if ($users) {
                foreach ($users as $user) {
                    $update= Carbon::parse($user->updated_at)->format('d/m/Y g:i A');
                    $delete_button="";
                    if($user->is_admin==1){
                        $role = "Admin";
                    }else
                    {
                        $role = "User";
                        $delete_button = " <input type = 'button' class = 'btn btn-danger btn-sm' value = 'Delete' id = 'del_user' onclick = 'del_user(".$user->id.")' \>";
                    }
                    $output .= "<tr>
                    <td class='cart_description'><h5>" . $user->name . "</h5></td>
                    <td class='cart_description'><h5>" . $user->email . "</h5></td>
                    <td class='cart_description'><h5>" . $update . "</h5></td>
                    <td class='cart_description'><h5>" . $user->phone . "</h5></td>
                    <td class='cart_description'><h5>" . $role . "</h5></td>
                    <td class='cart_description'><h5>" . $delete_button . "</h5></td>
                    </tr>";
                }
            }
            
            return Response($output);
        }
    }
    public function post_search(Request $request)
    {
        if ($request->ajax()) {
            $posts = DB::table('article')->join('users','article.user_id','=','users.id')->join('product','article.product_id','=','product.id')->where([['title', 'LIKE', '%' . $request->search . '%']])->get();
            $output_post = "";
            if ($posts) {
                foreach ($posts as $post) {
                    $create= Carbon::parse($post->created_at)->format('d/m/Y g:i A');
                    $update= Carbon::parse($post->updated_at)->format('d/m/Y g:i A');
                    $delete_button = " <input type = 'button' class = 'btn btn-danger btn-sm' value = 'Delete' id = 'del_user' onclick = 'del_post(".$post->id.")' \>";
                    $output_post .= "<tr>
                    <td class='cart_description'><h5>" . $post->name . "</h5></td>
                    <td class='cart_description'><h5>" . $post->title . "</h5></td>
                    <td class='cart_description'><h5>" . $post->product_name . "</h5></td>
                    <td class='cart_description'><h5>" . $create . "</h5></td>
                    <td class='cart_description'><h5>" . $update . "</h5></td>
                    <td class='cart_description'><h5>" . $delete_button . "</h5></td>
                    </tr>";
                }
            }
            
            return Response($output_post);
        }
    }
    public function pro_search(Request $request)
    {
        if ($request->ajax()) {
            $products = DB::table('product')->where([['product_name', 'LIKE', '%' . $request->search . '%']])->get();
            $output_pro = "";
            if ($products) {
                $output_pro = "1";
                foreach ($products as $pro) {
                    $delete_button = " <input type = 'button' class = 'btn btn-danger btn-sm' value = 'Delete' id = 'del_user' onclick = 'del_pro(".$pro->id.")' \>";
                    $output_pro .= "<tr>
                    <td class='cart_description'><h5>" . $pro->product_name . "</h5></td>
                    <td class='cart_description'><h5>" . $pro->CPU. "</h5></td>
                    <td class='cart_description'><h5>" . $pro->RAM. "</h5></td>
                    <td class='cart_description'><h5>" . $pro->OS . "</h5></td>
                    <td class='cart_description'><h5>" . $pro->price . "</h5></td>
                    <td class='cart_description'><h5>" . $delete_button . "</h5></td>
                    </tr>";
                }
            }else{
                $output_pro = "w";
            }
            
            return Response($output_pro);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
       //$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        $user = Auth::user();
        $us = User::findOrFail($request->id); 
        $us->delete();
        $output = '';
        $delete_button="";
        $users = User::all();
        $posts =  DB::table('article')->join('users','article.user_id','=','users.id')->join('product','article.product_id','=','product.id')->get();
        if ($users) {
            foreach ($users as $user) {
                $update= Carbon::parse($user->updated_at)->format('d/m/Y g:i A');
                $delete_button="";
                if($user->is_admin==1){
                    $role = "Admin";
                }else
                {
                    $role = "User";
                    $delete_button = " <input type = 'button' class = 'btn btn-danger btn-sm' value = 'Delete' id = 'del_user' onclick = 'del_user(".$user->id.")' \>";
                }
                $output .= "<tr>
                <td class='cart_description'><h5>" . $user->name . "</h5></td>
                <td class='cart_description'><h5>" . $user->email . "</h5></td>
                <td class='cart_description'><h5>" . $update . "</h5></td>
                <td class='cart_description'><h5>" . $user->phone . "</h5></td>
                <td class='cart_description'><h5>" . $role . "</h5></td>
                <td class='cart_description'><h5>" . $delete_button . "</h5></td>
                </tr>";
            }
        }
        $output_post = "";
        if ($posts) {
            foreach ($posts as $post) {
                $create= Carbon::parse($post->created_at)->format('d/m/Y g:i A');
                $update= Carbon::parse($post->updated_at)->format('d/m/Y g:i A');
                $delete_button = " <input type = 'button' class = 'btn btn-danger btn-sm' value = 'Delete' id = 'del_user' onclick = 'del_post(".$post->id.")' \>";
                $output_post .= "<tr>
                <td class='cart_description'><h5>" . $post->name . "</h5></td>
                <td class='cart_description'><h5>" . $post->title . "</h5></td>
                <td class='cart_description'><h5>" . $post->product_name . "</h5></td>
                <td class='cart_description'><h5>" . $create . "</h5></td>
                <td class='cart_description'><h5>" . $update . "</h5></td>
                <td class='cart_description'><h5>" . $delete_button . "</h5></td>
                </tr>";
            }
        }
      
        return response()->json(['users' => $output, 'posts' => $output_post]);;
    }
    public function destroy_post(Request $request)
    {
        $posts_del =DB::table('article')->where('id','=',$request->id)->delete();
        $posts =  DB::table('article')->join('users','article.user_id','=','users.id')->join('product','article.product_id','=','product.id')->get();
        $output_post = "";
        if ($posts) {
            foreach ($posts as $post) {
                $create= Carbon::parse($post->created_at)->format('d/m/Y g:i A');
                $update= Carbon::parse($post->updated_at)->format('d/m/Y g:i A');
                $delete_button = " <input type = 'button' class = 'btn btn-danger btn-sm' value = 'Delete' id = 'del_user' onclick = 'del_post(".$post->id.")' \>";
                $output_post .= "<tr>
                <td class='cart_description'><h5>" . $post->name . "</h5></td>
                <td class='cart_description'><h5>" . $post->title . "</h5></td>
                <td class='cart_description'><h5>" . $post->product_name . "</h5></td>
                <td class='cart_description'><h5>" . $create . "</h5></td>
                <td class='cart_description'><h5>" . $update . "</h5></td>
                <td class='cart_description'><h5>" . $delete_button . "</h5></td>
                </tr>";
            }
        }
        return Response($output_post);
    }
    public function destroy_pro(Request $request)
    {
        $pro_del =DB::table('product')->where('id','=',$request->id)->delete();
        $products = DB::table('product')->get();
        $output_pro = "";
        if ($products) {
            $output_pro = "1";
            foreach ($products as $pro) {
                $delete_button = " <input type = 'button' class = 'btn btn-danger btn-sm' value = 'Delete' id = 'del_user' onclick = 'del_pro(".$pro->id.")' \>";
                $output_pro .= "<tr>
                <td class='cart_description'><h5>" . $pro->product_name . "</h5></td>
                <td class='cart_description'><h5>" . $pro->CPU. "</h5></td>
                <td class='cart_description'><h5>" . $pro->RAM. "</h5></td>
                <td class='cart_description'><h5>" . $pro->OS . "</h5></td>
                <td class='cart_description'><h5>" . $pro->price . "</h5></td>
                <td class='cart_description'><h5>" . $delete_button . "</h5></td>
                </tr>";
            }
        }    
        return Response($output_pro);
    }
}