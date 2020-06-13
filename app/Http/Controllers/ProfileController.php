<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        $cards =$user->creditcards;
        return view('users.index',['user'=>$user,'cards'=>$cards]);        
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
        $cards =$user->creditcards;
        return view('users.update',['user'=>$user,'cards'=>$cards]);        
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
        $user->username = $request->input('username');
        $user->type = $request->input('type');
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
        return redirect()->away(url()->current().'/edit');
    }

}
