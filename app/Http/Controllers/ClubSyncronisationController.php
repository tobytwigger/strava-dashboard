<?php

namespace App\Http\Controllers;

use App\Models\ClubSyncronisation;
use Illuminate\Http\Request;

class ClubSyncronisationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sync');
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
     * @param  \App\Models\ClubSyncronisation  $clubSyncronisation
     * @return \Illuminate\Http\Response
     */
    public function show(ClubSyncronisation $clubSyncronisation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClubSyncronisation  $clubSyncronisation
     * @return \Illuminate\Http\Response
     */
    public function edit(ClubSyncronisation $clubSyncronisation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClubSyncronisation  $clubSyncronisation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClubSyncronisation $clubSyncronisation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClubSyncronisation  $clubSyncronisation
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClubSyncronisation $clubSyncronisation)
    {
        //
    }
}
