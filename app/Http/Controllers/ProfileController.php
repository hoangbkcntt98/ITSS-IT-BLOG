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
        $posts = Article::all();
        $users = User::all();
        return view('users.index',['user'=>$user,'users'=>$users,'posts'=>$posts]);        
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
                    $update= Carbon::parse($user->updated_at)->format('d/m/Y');
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
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = Auth::user();
        $us = User::findOrFail($request->id); 
        $us->delete();
        $output = '';
        $delete_button="";
        $users = User::all();
        if ($users) {
            foreach ($users as $user) {
                $update= Carbon::parse($user->updated_at)->format('d/m/Y');
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
