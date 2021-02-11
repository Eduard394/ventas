<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BuyController extends Controller
{
    public function home(){
    	return view('users.index');
    }

    public function comprar(){
    	return view('users.comprar');
    }


}
