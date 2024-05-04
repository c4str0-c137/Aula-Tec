<?php

namespace App\Http\Controllers;

use App\Models\Acontecimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AcontecimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

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
     * @param  \App\Models\Acontecimiento  $acontecimiento
     * @return \Illuminate\Http\Response
     */
    public function show(Acontecimiento $acontecimiento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Acontecimiento  $acontecimiento
     * @return \Illuminate\Http\Response
     */
    public function edit(Acontecimiento $acontecimiento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Acontecimiento  $acontecimiento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Acontecimiento $acontecimiento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Acontecimiento  $acontecimiento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Acontecimiento $acontecimiento)
    {
        //
    }
}
