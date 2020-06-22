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
    public function show($id){
        $user = User::findOrFail($id);
        $posts =  DB::table('articles')->join('users','articles.user_id','=','users.id')->join('products','articles.product_id','=','products.id')->select('name', 'articles.id','product_name','articles.created_at','articles.updated_at','articles.title')->get();
        if($user->is_admin == 0){
            $posts = DB::table('articles')->join('users','articles.user_id','=','users.id')->join('products','articles.product_id','=','products.id')->select('name', 'articles.id','product_name','articles.created_at','articles.updated_at','articles.title')->where('articles.user_id','=',$user->id)->get();
        }
        $users = User::all();
        $product = DB::table('products')->get();
        return view('users.index',['user'=>$user,'users'=>$users,'posts'=>$posts,'products'=>$product]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $id = Auth::id();
        $user = User::findOrFail($id);

        $posts =  DB::table('articles')->join('users','articles.user_id','=','users.id')->join('products','articles.product_id','=','products.id')->select('name', 'articles.id','product_name','articles.created_at','articles.updated_at','articles.title','articles.product_id')->get();
        if($user->is_admin == 0){
            $posts = DB::table('articles')->join('users','articles.user_id','=','users.id')->join('products','articles.product_id','=','products.id')->select('name', 'articles.id','product_name','articles.created_at','articles.updated_at','articles.title','articles.product_id')->where('articles.user_id','=',$user->id)->get();
        }
        $users = User::all();
        $product = DB::table('products')->get();
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
        $user->phone = $request->input('phone');
        if(Hash::check($request->input('password'),$hashedPassword)!=true)
        {
            if(($request->input('password'))==($request->input('password-confirm')))
            {
               $user->fill([
                    'password' => Hash::make($request->input('password'))
                ])->save();
            }
        }

        if($request->hasFile('image')){
           
            $image = $request->file('image');
           
            $image->move('images', $user->id.$image->clientExtension());
            $user->img = $user->id.$image->clientExtension();
        }
        
        $user->save();
        return redirect('user/'.$id);
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
                    $detail_button ="";
                    if($user->is_admin==1){
                        $role = "Admin";
                    }else
                    {
                        $role = "User";
                        $detail_button = "<input  type = 'button' class = 'btn btn-success btn-sm' value = 'Detail' id = 'view_pro' onclick = 'view_user(".$user->id.")'>";
                        $delete_button = "<button type = 'button' class = 'btn btn-danger btn-sm' value = 'Delete' id = 'del_user' onclick = 'del_user(".$user->id.")'><span class='glyphicon glyphicon-trash'></span></button>";
                    }
                    $output .= "<tr>
                    <td class='cart_description'><h5>" . $user->name . "</h5></td>
                    <td class='cart_description'><h5>" . $user->email . "</h5></td>
                    <td class='cart_description'><h5>" . $update . "</h5></td>
                    <td class='cart_description'><h5>" . $user->phone . "</h5></td>
                    <td class='cart_description'><h5>" . $role . "</h5></td>
                    <td class='cart_description' style = 'border-right:none;padding-right:1px'>" . $delete_button . "</td>
                    <td class='cart_description' style = 'border-left:none;padding-left:0px;'>" . $detail_button . "</td>
                    </tr>";
                }
            }

            return Response($output);
        }
    }
    public function post_search(Request $request)
    {
        $user = Auth::user();
        if ($request->ajax()) {

            $posts = DB::table('articles')->join('users','articles.user_id','=','users.id')->join('products','articles.product_id','=','products.id')->select('name', 'articles.id','product_name','articles.created_at','articles.updated_at','articles.title','articles.product_id')->where([['title', 'LIKE', '%' . $request->search . '%']])->get();
            if($user->is_admin == 0){
                $posts = DB::table('articles')->join('users','articles.user_id','=','users.id')->join('products','articles.product_id','=','products.id')->select('name', 'articles.id','product_name','articles.created_at','articles.updated_at','articles.title','articles.product_id')->where([['title', 'LIKE', '%' . $request->search . '%'],['articles.user_id','=',$user->id]])->get();
            }
            $output_post = "";
            if ($posts) {
                foreach ($posts as $post) {
                    $create= Carbon::parse($post->created_at)->format('d/m/Y g:i A');
                    $update= Carbon::parse($post->updated_at)->format('d/m/Y g:i A');
                    $delete_button = " <button class = 'btn btn-danger btn-sm' value = 'Delete' id = 'del_user' onclick = 'del_post(".$post->id.")'><span class='glyphicon glyphicon-trash'></span></button>";
                    $detail_button = "<button class = 'btn btn-success btn-sm' value = 'Detail'  onclick = 'view_post(".$post->id.",".$post->product_id.")'>Detail </button>";
                    $output_post .= "<tr>
                    <td class='cart_description'><h5>" . $post->name . "</h5></td>
                    <td class='cart_description'><h5>" . $post->title . "</h5></td>
                    <td class='cart_description'><h5>" . $post->product_name . "</h5></td>
                    <td class='cart_description'><h5>" . $create . "</h5></td>
                    <td class='cart_description'><h5>" . $update . "</h5></td>
                    <td class='cart_description' style = 'border-right:none;padding-right:1px'>" . $delete_button . "</td>
                    <td class='cart_description' style = 'border-left:none;padding-left:0px;'>" . $detail_button . "</td>
                    </tr>";
                }
            }

            return Response($output_post);
        }
    }
    public function pro_search(Request $request)
    {
        if ($request->ajax()) {
            $products = DB::table('products')->where([['product_name', 'LIKE', '%' . $request->search . '%']])->get();
            $output_pro = "";
            if ($products) {
                foreach ($products as $pro) {
                    $delete_button = " <button class = 'btn btn-danger btn-sm' value = '' id = 'del_pro' onclick = 'del_pro(".$pro->id."'><span class='glyphicon glyphicon-trash'></span></button>";
                    $detail_button = " <input type = 'button' class = 'btn btn-success btn-sm' value = 'Detail' id = 'del_user' onclick = 'view_pro(".$pro->id.")' \>";
                    $output_pro .= "<tr>
                    <td class='cart_description'><h5>" . $pro->product_name . "</h5></td>
                    <td class='cart_description'><h5>" . $pro->CPU. "</h5></td>
                    <td class='cart_description'><h5>" . $pro->RAM. "</h5></td>
                    <td class='cart_description'><h5>" . $pro->OS . "</h5></td>
                    <td class='cart_description'><h5>" . $pro->price . "</h5></td>
                    <td class='cart_description' style = 'border-right:none;padding-right:1px'>" . $delete_button . "</td>
                    <td class='cart_description' style = 'border-left:none;padding-left:0px;'>" . $detail_button . "</td>
                    </tr>";
                }
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

        $posts =  DB::table('articles')->join('users','articles.user_id','=','users.id')->join('products','articles.product_id','=','products.id')->select('name', 'articles.id','product_name','articles.created_at','articles.updated_at','articles.title','articles.product_id')->get();
        if($user->is_admin == 0){
            $posts = DB::table('articles')->join('users','articles.user_id','=','users.id')->join('products','articles.product_id','=','products.id')->select('name', 'articles.id','product_name','articles.created_at','articles.updated_at','articles.title','articles.product_id')->where('articles.user_id','=',$user->id)->get();
        }
        if ($users) {
            foreach ($users as $user) {
                $update= Carbon::parse($user->updated_at)->format('d/m/Y g:i A');
                $delete_button="";
                $detail_button ="";
                if($user->is_admin==1){
                    $role = "Admin";
                }else
                {
                    $role = "User";
                    $detail_button = "<input  type = 'button' class = 'btn btn-success btn-sm' value = 'Detail' id = 'view_pro' onclick = 'view_user(".$user->id.")'>";
                    $delete_button = "<button type = 'button' class = 'btn btn-danger btn-sm' value = 'Delete' id = 'del_user' onclick = 'del_user(".$user->id.")'><span class='glyphicon glyphicon-trash'></span></button>";
                }
                $output .= "<tr>
                <td class='cart_description'><h5>" . $user->name . "</h5></td>
                <td class='cart_description'><h5>" . $user->email . "</h5></td>
                <td class='cart_description'><h5>" . $update . "</h5></td>
                <td class='cart_description'><h5>" . $user->phone . "</h5></td>
                <td class='cart_description'><h5>" . $role . "</h5></td>
                <td class='cart_description' style = 'border-right:none;padding-right:1px'>" . $delete_button . "</td>
                <td class='cart_description' style = 'border-left:none;padding-left:0px;'>" . $detail_button . "</td>
                </tr>";
            }
        }
        $output_post = "";
        if ($posts) {
            foreach ($posts as $post) {
                $create= Carbon::parse($post->created_at)->format('d/m/Y g:i A');
                $update= Carbon::parse($post->updated_at)->format('d/m/Y g:i A');
                $delete_button = " <button class = 'btn btn-danger btn-sm' value = 'Delete' id = 'del_user' onclick = 'del_post(".$post->id.")'><span class='glyphicon glyphicon-trash'></span></button>";
                $detail_button = "<button class = 'btn btn-success btn-sm' value = 'Detail'  onclick = 'view_post(".$post->id.",".$post->product_id.")'>Detail </button>";
                $output_post .= "<tr>
                <td class='cart_description'><h5>" . $post->name . "</h5></td>
                <td class='cart_description'><h5>" . $post->title . "</h5></td>
                <td class='cart_description'><h5>" . $post->product_name . "</h5></td>
                <td class='cart_description'><h5>" . $create . "</h5></td>
                <td class='cart_description'><h5>" . $update . "</h5></td>
                <td class='cart_description' style = 'border-right:none;padding-right:1px'>" . $delete_button . "</td>
                <td class='cart_description' style = 'border-left:none;padding-left:0px;'>" . $detail_button . "</td>
                </tr>";
            }
        }

        return response()->json(['users' => $output, 'posts' => $output_post]);;
    }
    public function destroy_post(Request $request)
    {
        $user = Auth::user();
        $posts_del =DB::table('articles')->where('id','=',$request->id)->delete();

        $posts =  DB::table('articles')->join('users','articles.user_id','=','users.id')->join('products','articles.product_id','=','products.id')->select('name', 'articles.id','product_name','articles.created_at','articles.updated_at','articles.title','articles.product_id')->get();
        if($user->is_admin == 0){
            $posts = DB::table('articles')->join('users','articles.user_id','=','users.id')->join('products','articles.product_id','=','products.id')->select('name', 'articles.id','product_name','articles.created_at','articles.updated_at','articles.title','articles.product_id')->where('articles.user_id','=',$user->id)->get();
        }
        $output_post = "";
        if ($posts) {
            foreach ($posts as $post) {
                $create= Carbon::parse($post->created_at)->format('d/m/Y g:i A');
                $update= Carbon::parse($post->updated_at)->format('d/m/Y g:i A');
                $delete_button = " <button class = 'btn btn-danger btn-sm' value = 'Delete' id = 'del_user' onclick = 'del_post(".$post->id.")'><span class='glyphicon glyphicon-trash'></span></button>";
                $detail_button = "<button class = 'btn btn-success btn-sm' value = 'Detail'  onclick = 'view_post(".$post->id.",".$post->product_id.")'>Detail </button>";
                $output_post .= "<tr>
                <td class='cart_description'><h5>" . $post->name . "</h5></td>
                <td class='cart_description'><h5>" . $post->title . "</h5></td>
                <td class='cart_description'><h5>" . $post->product_name . "</h5></td>
                <td class='cart_description'><h5>" . $create . "</h5></td>
                <td class='cart_description'><h5>" . $update . "</h5></td>
                <td class='cart_description' style = 'border-right:none;padding-right:1px'>" . $delete_button . "</td>
                <td class='cart_description' style = 'border-left:none;padding-left:0px;'>" . $detail_button . "</td>
                </tr>";
            }
        }
        return Response($output_post);
    }
    public function destroy_pro(Request $request)
    {
        $pro_del =DB::table('products')->where('id','=',$request->id)->delete();
        $products = DB::table('products')->get();
        $output_pro = "";
        if ($products) {
            foreach ($products as $pro) {
                $delete_button = " <button class = 'btn btn-danger btn-sm' value = '' id = 'del_pro' onclick = 'del_pro(".$pro->id."'><span class='glyphicon glyphicon-trash'></span></button>";
                $detail_button = " <input type = 'button' class = 'btn btn-success btn-sm' value = 'Detail' id = 'del_user' onclick = 'view_pro(".$pro->id.")' \>";
                $output_pro .= "<tr>
                <td class='cart_description'><h5>" . $pro->product_name . "</h5></td>
                <td class='cart_description'><h5>" . $pro->CPU. "</h5></td>
                <td class='cart_description'><h5>" . $pro->RAM. "</h5></td>
                <td class='cart_description'><h5>" . $pro->OS . "</h5></td>
                <td class='cart_description'><h5>" . $pro->price . "</h5></td>
                <td class='cart_description'>" . $delete_button . $detail_button. "</td>
                </tr>";
            }
        }
        return Response($output_pro);
    }
    public function saveImage(Request $request){
        $user_id = Auth::id();
        request()->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
 
        if ($files = $request->file('image')) {
 
            $image = $request->image->store('public/images');
            $request->photo->storeAs('image', $user_id.'.jpg');
            return Response()->json([
                "success" => true,
                "image" => $image
            ]);
 
        }
 
        return Response()->json([
                "success" => false,
                "image" => ''
            ]);
    }
}
