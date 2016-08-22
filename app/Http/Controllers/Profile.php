<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class Profile extends Controller
{
    public function show(){
        setlocale(LC_TIME, 'Russian');
        Carbon::setLocale(config('app.locale'));
        $data = [
          'regtime' => Auth::user()->created_at->diffForHumans()
        ];
        return view('pages.profile', $data);
    }
}
