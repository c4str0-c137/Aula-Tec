<?php

namespace App\Http\Controllers;

use App\Models\AmbienteHorario;
use App\Models\dia;
use App\Models\EstadoHorario;
use Illuminate\Http\Request;
use App\Models\Horario;
use App\Models\Ambiente;
use App\Models\TipoAmbiente;


class AmbienteHorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ambienteHorarios = AmbienteHorario::all();
        $departamentos = Ambiente::all()->pluck('departamento')->unique();
        $ambientes = Ambiente::all();
        $horarios = Horario::all();
        $dias = dia::all();
        $estados=EstadoHorario::all();
        return view('Horario.index', compact('ambienteHorarios','ambientes','departamentos','horarios','dias',"estados"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Recuperar los datos del seeder para los estados
        $estados = EstadoHorario::all();
        $dias = dia::all();
        $horarios = Horario::all();
        return view('Horario.create', compact('estados', 'dias', 'horarios'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_ambiente' => 'required',
            'id_estado_horario' => 'required',
            'id_dia' => 'required',
            'id_horario' => 'required|array',
        ]);
        // Obtener el primer valor seleccionado para el campo id_dia
        $id_dia = $request->id_dia;
        // Validar si ya existe un registro con el mismo día y horario
        $existingRecord = AmbienteHorario::where('id_dia', $id_dia)
                                        ->whereIn('id_horario', $request->id_horario)
                                        ->exists();
        if ($existingRecord) {
            return response()->json(['error' => ''], 422);
        }
        // Guardar el registro en la base de datos
        foreach ($request->id_horario as $id_horario) {
            $ambienteHorario = new AmbienteHorario();
            // Asignar los valores del formulario a los campos del modelo
            $ambienteHorario->id_ambiente = $request->id_ambiente;
            $ambienteHorario->id_horario = $id_horario;
            $ambienteHorario->id_dia = $id_dia;
            $ambienteHorario->id_estado_horario = $request->id_estado_horario;
            $ambienteHorario->save();
        }
        return response()->json(['success' => 'Los ambientes han sido registrados correctamente.'], 200);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ambiente_horario  $ambiente_horario
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ambienteHorario = AmbienteHorario::findOrFail($id);
        $ambientes = Ambiente::all(); 
        $horarios = Horario::all();
        $dias = Dia::all();
        $estados = EstadoHorario::all();
        $tipoambientes = TipoAmbiente::all(); 

        return view('Horario.edit', compact('ambienteHorario', 'ambientes', 'horarios', 'dias', 'estados', 'tipoambientes')); 
    } 
/**
 * Remove the specified resource from storage.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
    public function destroy($id)
    {
        $ambienteHorario = AmbienteHorario::find($id);
        if ($ambienteHorario) {
            $ambienteHorario->id_estado_horario = 2; 
            $ambienteHorario->save();
            return redirect('/Horario')->with('success', 'El horario se ha desactivado correctamente.');
        } else {
            return redirect('/Horario')->with('error', 'El horario no se encontró.');
        }
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_horario' => 'required',
            'id_dia' => 'required',
            'id_estado_horario' => 'required',
            'id_tipoAmbiente' => 'required',
        ]);

        $ambienteHorario = AmbienteHorario::findOrFail($id);

        $ambienteHorario->id_horario = $request->id_horario;
        $ambienteHorario->id_dia = $request->id_dia;
        $ambienteHorario->id_estado_horario = $request->id_estado_horario;
        $ambienteHorario->ambiente->id_tipoAmbiente = $request->id_tipoAmbiente;

        $ambienteHorario->ambiente->save();

        $ambienteHorario->save();
        return redirect()->route('Horario.index')->with('success', 'El ambiente y horario se han actualizado correctamente.');
    }
    
    


}
