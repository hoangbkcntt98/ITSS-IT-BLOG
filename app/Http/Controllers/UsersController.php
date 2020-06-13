<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
class  UsersController extends Controller
{
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        return view('.create',['user'=>$user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $card = new CreditCard();
        $card->id = $user->id;
        $card->card_number = $request->input('card_number');
        $card->expiration_date = Carbon::createFromFormat('d/m/Y', $request->input('date')); 
        $card->ccv = $request->input('ccv');
        $card->save();
        return redirect()->route('user.edit',$user->id);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $card = CreditCard::where('card_id',$id)->first();
        $user = Auth::user();
        return view('card.update',['card'=>$card,'user'=>$user]);
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
        $user = Auth::user();
        $card = CreditCard::where('card_id',$id)->first();
        $card->card_number = $request->input('card_number');
        $card->expiration_date = Carbon::createFromFormat('d/m/Y', $request->input('date'));
        $card->ccv = $request->input('ccv');
        $card->save();
        return redirect()->route('user.edit',$user->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $card = CreditCard::where('card_id',$id)->first();
        $card->delete();
        return redirect()->route('user.edit',$user->id);

    }
}