<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function store(Request $request)
    {
        $userReport = new \App\Reports;
        $userReport->doodle_id = $request->input('doodle_id');
        $userReport->report_description = $request->input('report');
        $userReport->reporter_id = \Auth::user()->id;
        $userReport->save();
        dd((\App\Doodle::where('id', '=', $userReport->doodle_id)->first())->creator_id);
        return ['redirect' => route('home')];
        \Mail::to()->send(new Welcome($data['name']));
    }
}
