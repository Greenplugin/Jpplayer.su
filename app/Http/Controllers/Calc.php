<?php

namespace App\Http\Controllers;

use App\Key;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class Calc extends Controller
{

    protected function getHistory(Request $request) {
        $histories = Key::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return $histories;
    }


}
