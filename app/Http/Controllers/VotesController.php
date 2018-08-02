<?php

namespace App\Http\Controllers;

use App\Votes;
use Illuminate\Http\Request;

class VotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        $userVote = new \App\Votes;
        $userVote->voter_id = \Auth::user()->id;        
        $userVote->doodle_id = $request->input('doodle_id');        
        $userVote->vote = $request->input('vote');        
        $userVote->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Votes  $votes
     * @return \Illuminate\Http\Response
     */
    public function show(Votes $votes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Votes  $votes
     * @return \Illuminate\Http\Response
     */
    public function edit(Votes $votes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Votes  $votes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->input('vote'));
        $userVote = \App\Votes::where('voter_id', '=', \Auth::user()->id)->where('doodle_id', '=', $id)->get()[0];
        $userVote->vote = $request->input('vote');
        // dd($userVote);
        $userVote->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Votes  $votes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        \App\Votes::destroy($id);
    }
}
