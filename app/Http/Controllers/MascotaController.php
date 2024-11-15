<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mascota;

class MascotaController extends Controller
{
    public function index()
{
    $mascotas = Mascota::all();
    foreach ($mascotas as $mascota) {
        if ($mascota->imagen) {
            $mascota->imagen_base64 = base64_encode(stream_get_contents($mascota->imagen));
            dump($mascota);
        }
    }

    return view('mascotas', compact('mascotas'));
}

public function getImagen($id)
{
    $mascota = Mascota::find($id);
    
    if ($mascota && $mascota->imagen) {
        // Decodificar la imagen base64 (suponiendo que la imagen está guardada en la base de datos como base64)
        $raw_image_string = base64_encode(stream_get_contents($mascota->imagen));
        
        // Retornar la imagen con el tipo MIME adecuado
        return response($raw_image_string)
            ->header('Content-Type', $mascota->imagen_mime);
    }

    // Si no hay imagen o no se encuentra la mascota, retornar un 404
    return abort(404, 'Imagen no disponible');
}


    public function create()
    {
        return view('mascotas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'especie' => 'required|string|max:100',
            'raza' => 'nullable|string|max:100',
            'edad' => 'nullable|integer',
            'peso' => 'nullable|numeric',
            'nombre_dueño' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:15',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  
        ]);
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $imagenBase64 = base64_encode(file_get_contents($imagen));
        } else {
            $imagenBase64 = null;
        }

        Mascota::create([
            'nombre' => $request->nombre,
            'especie' => $request->especie,
            'raza' => $request->raza,
            'edad' => $request->edad,
            'peso' => $request->peso,
            'nombre_dueño' => $request->nombre_dueño,
            'telefono' => $request->telefono,
            'imagen' => $imagenBase64,  
        ]);
    
        return redirect()->route('mascotas.index')->with('success', 'Mascota agregada con éxito.');
    }
    

    public function edit($id)
    {
        $mascota = Mascota::findOrFail($id);
        return response()->json($mascota); 
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'especie' => 'required|string|max:100',
            'raza' => 'nullable|string|max:100',
            'edad' => 'nullable|integer',
            'peso' => 'nullable|numeric',
            'nombre_dueño' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:15',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        $mascota = Mascota::findOrFail($id);
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $imagenBase64 = base64_encode(file_get_contents($imagen));
        } else {
            $imagenBase64 = $mascota->imagen;
        }

        $mascota->update([
            'nombre' => $request->nombre,
            'especie' => $request->especie,
            'raza' => $request->raza,
            'edad' => $request->edad,
            'peso' => $request->peso,
            'nombre_dueño' => $request->nombre_dueño,
            'telefono' => $request->telefono,
            'imagen' => $imagenBase64,  
        ]);
    
        return redirect()->route('mascotas.index')->with('success', 'Mascota actualizada con éxito.');
    }
    

    public function destroy($id)
    {
        $mascota = Mascota::findOrFail($id);
        $mascota->delete();
        return redirect()->route('mascotas.index')->with('success', 'Mascota eliminada con éxito.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        if (empty($query)) {
            $mascotas = Mascota::all();
        } else {
            $mascotas = Mascota::where('nombre', 'like', '%' . $query . '%')
                                ->orWhere('especie', 'like', '%' . $query . '%')
                                ->get();
        }
        return response()->json(['mascotas' => $mascotas]);
    }
}