<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Servicio;

class ServicioController extends Controller
{
    public function index()
    {
        $servicios = Servicio::all();
        return view('servicios', compact('servicios'));
    }

    public function create()
    {
        return view('servicios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
        ]);

        Servicio::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
        ]);

        return redirect()->route('servicios.index')->with('success', 'Servicio agregado con éxito.');
    }

    public function edit($id)
{
    $servicio = Servicio::findOrFail($id);
    return response()->json($servicio); 
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
        ]);

        $servicio = Servicio::findOrFail($id);

        $servicio->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
        ]);

        return redirect()->route('servicios.index')->with('success', 'Servicio actualizado con éxito.');
    }

    public function destroy($id)
    {
        $servicio = Servicio::findOrFail($id);
        $servicio->delete(); 

        return redirect()->route('servicios.index')->with('success', 'Servicio eliminado con éxito.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');       
        if (empty($query)) {
            $servicios = Servicio::all();
        } else {
            $servicios = Servicio::where('nombre', 'like', '%' . $query . '%')
                                ->orWhere('descripcion', 'like', '%' . $query . '%')
                                ->get();
        }
        return response()->json(['servicios' => $servicios]);
    }
}
