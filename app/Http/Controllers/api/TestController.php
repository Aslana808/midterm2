<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FillRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\BalanceHistory;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function register(RegisterRequest $request){
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'money' => $request->get('money'),
            'password' => bcrypt($request->get('password')),
            'is_admin' => $request->get('is_admin')
        ]);
        return response(['user' => $user]);
    }

    public function login(LoginRequest $request){
        if (auth()->attempt($request->all())){
            $token = auth()->user()->createToken('Api Token')->accessToken;
            return response(['user' => auth()->user(), 'Token' => $token]);
        }
        return response(['message'=> 'Incorrect credentials, please try again!']);
    }

    public function fill_balance(FillRequest $request){
        $user = User::find($request->get('user_id'));
        $user->money += $request->get('amount');
        $history = BalanceHistory::create([
            'added_amount' => $request->get('amount'),
            'user_id' => $request->get('user_id')
        ]);
        $user->update();
        return response(['user' => $user]);
    }

    public function history(){
        return  BalanceHistory::all();
    }

    public function transfer(FillRequest $request){
        $destinationUser = User::find( $request->get('user_id'));
        $sourceUser = User::find(auth()->user()->id);
        $amount = $request->get('amount');
        $destinationUser->money += $amount;
        $sourceUser->money = $sourceUser->money - ($amount + ($amount*1)/100);
        $transaction = Transaction::create([
            'sender_user_id' => auth()->user()->id,
            'recipient_user_id' => $request->get('user_id'),
            'amount' => $amount,
            'commission_amount' => ($amount*1)/100
        ]);
        $destinationUser->update();
        $sourceUser->update();
        $transaction->update();
        return User::all();
    }

    public function showBalance(){
        $user = Transaction::where('sender_user_id', '=', auth()->user()->id)->get();
        return $user;
    }

    public function transactions(){
        $user = User::find(auth()->user()->id);
        if( $user->is_admin == 1 || $user->is_admin == null){
            return Transaction::all();
        }
        else{
            return response(['message'=> 'You are not an Admin!']);
        }
    }
}
