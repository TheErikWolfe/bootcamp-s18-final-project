<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Mail\Report;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store(Request $request)
    {
        $userReport = new \App\Reports;
        $userReport->doodle_id = $request->input('doodle_id');
        $userReport->report_description = $request->input('report');
        $userReport->reporter_id = \Auth::user()->id;
        $userReport->save();
        $doodle = \App\Doodle::where('id', '=', $userReport->doodle_id)->first();
        $creator_user = \App\User::find($doodle->creator_id);
        \Mail::to($creator_user->email)->send(new Report($creator_user, $doodle));
    }
}
