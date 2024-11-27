<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mascota;
use Illuminate\Http\Request;

class MascotaController extends Controller
{
    public function index()
    {
        $mascotas = Mascota::all();
        foreach ($mascotas as $mascota) {
            if ($mascota->imagen) {
                $mascota->imagen_url = asset('storage/' . $mascota->imagen);
            }
        }
        return view('mascotas', compact('mascotas'));
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
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:51200',
        ]);

        $imagenRuta = null;

        if ($request->hasFile('imagen')) {
            $imagenRuta = $request->file('imagen')->store('imagenes/mascotas', 'public');
        }

        Mascota::create([
            'nombre' => $request->nombre,
            'especie' => $request->especie,
            'raza' => $request->raza,
            'edad' => $request->edad,
            'peso' => $request->peso,
            'nombre_dueño' => $request->nombre_dueño,
            'telefono' => $request->telefono,
            'imagen' => $imagenRuta,
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
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:51200',
        ]);

        $mascota = Mascota::findOrFail($id);
        if ($request->hasFile('imagen')) {
            if ($mascota->imagen && \Storage::disk('public')->exists($mascota->imagen)) {
                \Storage::disk('public')->delete($mascota->imagen);
            }
            $imagenRuta = $request->file('imagen')->store('imagenes/mascotas', 'public');
        } else {
            $imagenRuta = $mascota->imagen;
        }
        $mascota->update([
            'nombre' => $request->nombre,
            'especie' => $request->especie,
            'raza' => $request->raza,
            'edad' => $request->edad,
            'peso' => $request->peso,
            'nombre_dueño' => $request->nombre_dueño,
            'telefono' => $request->telefono,
            'imagen' => $imagenRuta,
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
