<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ambiente;
use App\Models\Ubicacion;
use App\Models\TipoAmbiente;
use Illuminate\Support\Facades\Auth;

class AmbienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->id_rol !== 1) {
            return redirect()->route('home');
        }
        $ambientes = Ambiente::where('id_estado', 1)->get();
        return view('Ambiente.index')->with('ambientes', $ambientes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
{
    $ubicaciones = Ubicacion::all();
    $tipoambientes = TipoAmbiente::all();
    return view('Ambiente.create', compact('ubicaciones', 'tipoambientes'));
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
        'departamento' => 'required',
        'capacidad' => 'required|numeric',
        'tipoAmbiente' => 'required',
        'ubicacion' => 'required',
        'numeroaula' =>'required'
    ]);

    $ambiente = new Ambiente();
    $ambiente->departamento = $request->input('departamento');
    $ambiente->capacidad = $request->input('capacidad');
    $ambiente->id_tipoAmbiente = $request->get('tipoAmbiente');
    $ambiente->id_ubicacion = $request->get('ubicacion');
    $ambiente->numeroaula = $request->input('numeroaula');
    

    $ambiente->save();

    return redirect('/Ambiente')->with('success', 'Ambiente creado exitosamente');
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
    // public function edit($id)
    // {
    //     $ambiente = Ambiente::find($id);

    //     return view('Ambiente.edit')->with('Ambiente',$ambiente);
    // }

   

    public function edit($id)
    {
        $ambiente = Ambiente::with('tipoAmbiente', 'ubicacion')->find($id);
        $ubicaciones = Ubicacion::all();
        $tipoambientes = TipoAmbiente::all(); // Agregar esta línea
     
        return view('Ambiente.edit')->with(['Ambiente' => $ambiente, 'ubicaciones' => $ubicaciones, 'tipoambientes' => $tipoambientes]); 
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
        //  $request->validate([
        //      'departamento' => 'required',
        //      'capacidad' => 'required|numeric',
        //      'tipo' => 'required',
        //      'ubicacion' => 'required',
        // ]);
    
        $ambiente = Ambiente::find($id);

        $ambiente->departamento = $request->get('departamento');
        $ambiente->capacidad = $request->get('capacidad');
        $ambiente->id_tipoAmbiente = $request->get('tipoAmbiente');
        $ambiente->id_ubicacion= $request->get('ubicacion');
        $ambiente->numeroaula = $request->get('numeroaula');
    
        $ambiente->save();
    
        return redirect('/Ambiente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ambiente = Ambiente::find($id);
        $ambiente->id_estado = 2;
        $ambiente->save();
        return redirect('/Ambiente')->with('success', 'Ambiente actualizado correctamente');;
    }
    public function getAmbientes()
    {
    $ambientes = Ambiente::all();
    return response()->json($ambientes);
    }
    
}
