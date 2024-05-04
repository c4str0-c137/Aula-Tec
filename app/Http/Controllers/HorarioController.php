<?php

namespace App\Http\Controllers;

use App\Models\Ambiente;
use App\Models\EstadoHorario;
use Illuminate\Http\Request;
use App\Models\Horario;
use App\Models\dia;
use App\Models\AmbienteHorario;


class HorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {}
        /**$horarios = Horario::all();
        $horarios = Horario::with('ambiente')->get();
        return view('Horario.index')->with('horarios',$horarios);
        /*
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ambientes = Ambiente::all();
        $horarios = Horario::all();
        $estados = EstadoHorario::all();
        $dias = dia::all();
        return view('Horario.create', compact('ambientes', 'horarios', 'estados', 'dias'));
    }

    
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $horario = new Horario();
        $horario->horaini = $request->get('horaini');
        $horario->horafin = $request->get('horafin');
        $horario->id_ambiente = $request->get('ambiente');
        $horario->estado = $request->estado;

        $horario->save();

        return redirect('/Horario');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
