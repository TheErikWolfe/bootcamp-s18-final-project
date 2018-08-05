<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SignatureController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function create()
    {
        return view('auth.signature');
    }
    public function store(Request $request)
    {
        $signature = new \App\Signature;
        $signature->creator_id = \Auth::user()->id;
        $signature->source = $request->input('signature');
        $signature->save();

        return ['redirect' => route('home')];
        
    }
    public function edit(Request $request, $id)
    {
        //
    }
}
