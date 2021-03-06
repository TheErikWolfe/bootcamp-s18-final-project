<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $doodles = \App\Doodle::orderBy('created_at', 'desc')->get();
        foreach ($doodles as $doodle)
        {
            $doodle->numberOfUpvotes = $doodle->votes()->where('vote', '=', 1)->count();
            $doodle->numberOfDownvotes = $doodle->votes()->where('vote', '=', -1)->count();
            if($doodle->votes()->where('voter_id', '=', \Auth::user()->id)->where('doodle_id', '=', $doodle->id)->exists())
            {
                $doodle->userVote = $doodle->votes()->where('voter_id', '=', \Auth::user()->id)->where('doodle_id', '=', $doodle->id)->get()[0]->vote;
            }
            else
            {
                $doodle->userVote = null;
            }
            if($doodle->reports()->where('reporter_id', '=', \Auth::user()->id)->where('doodle_id', '=', $doodle->id)->exists() || $doodle->reports()->where('doodle_id', '=', $doodle->id)->count() > 3 || $doodle->reports()->where('reporter_id', '=', 1)->where('doodle_id', '=', $doodle->id)->exists()) //Made it greater than 3 as a placeholder for now. Eventually I could make it so that it would compare it to number of users logged in at a current moment.
            {
                $doodle->show = false;
            }
            else
            {
                $doodle->show = true;
            }
            $doodle->signature = \App\Signature::where('creator_id', '=', $doodle->creator_id)->first();
        }
        
        return view('main.home', compact('doodles'));
    }
}
