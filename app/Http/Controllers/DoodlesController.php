<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DoodlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $doodles = \App\Doodle::orderBy('created_at', 'desc')->get();
        return view('users.index', compact('doodles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $doodle = new \App\Doodle;
        $doodle->creator_id = \Auth::user()->id;
        $doodle->source = $request->input('doodle');
        $doodle->save();

        return ['redirect' => route('home')];
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public static function show($id)
    {
        $doodle = \App\Doodle::find($id);
        $doodle->previous = \App\Doodle::where('id', '<', $doodle->id)->max('id');
        $doodle->next = \App\Doodle::where('id', '>', $doodle->id)->min('id');
        
        return view('main.show', compact('doodle'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
