<?php

namespace App\Http\Controllers;

use App\Models\StravaConnectionLog;
use Illuminate\Http\Request;

class StravaConnectionLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('logs');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StravaConnectionLog  $stravaConnectionLog
     * @return \Illuminate\Http\Response
     */
    public function show(StravaConnectionLog $stravaConnectionLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StravaConnectionLog  $stravaConnectionLog
     * @return \Illuminate\Http\Response
     */
    public function edit(StravaConnectionLog $stravaConnectionLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StravaConnectionLog  $stravaConnectionLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StravaConnectionLog $stravaConnectionLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StravaConnectionLog  $stravaConnectionLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(StravaConnectionLog $stravaConnectionLog)
    {
        //
    }
}
