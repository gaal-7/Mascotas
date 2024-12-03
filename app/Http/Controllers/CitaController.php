<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Mascota;
use App\Models\Servicio;
use Illuminate\Http\Request;

class CitaController extends Controller
{

    public function index()
    {
        $citas = Cita::with('mascota', 'servicio')->get();
        $servicios = Servicio::all();
        $mascotas = Mascota::all();
        return view('citas', compact('citas', 'servicios', 'mascotas'));
    }
    
    public function create()
    {
        $mascotas = Mascota::all();
        $servicios = Servicio::all();
        return view('citas.create', compact('mascotas', 'servicios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mascota_id' => 'required|exists:mascotas,id',
            'servicio_id' => 'required|exists:servicios,id',
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'estado' => 'required|string|max:50',
        ]);

        Cita::create([
            'mascota_id' => $request->mascota_id,
            'servicio_id' => $request->servicio_id,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'estado' => $request->estado,
        ]);

        return redirect()->route('citas.index')->with('success', 'Cita agendada con éxito.');
    }

    public function edit($id)
    {
        $cita = Cita::findOrFail($id);
        return response()->json($cita);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'mascota_id' => 'required|exists:mascotas,id',
            'servicio_id' => 'required|exists:servicios,id',
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'estado' => 'required|string|max:50',
        ]);

        $cita = Cita::findOrFail($id);
        $cita->update([
            'mascota_id' => $request->mascota_id,
            'servicio_id' => $request->servicio_id,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'estado' => $request->estado,
        ]);

        return redirect()->route('citas.index')->with('success', 'Cita actualizada con éxito.');
    }

    public function destroy($id)
    {
        $cita = Cita::findOrFail($id);
        $cita->delete();

        return redirect()->route('citas.index')->with('success', 'Cita eliminada con éxito.');
    }
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (empty($query)) {
            $citas = Cita::with('mascota', 'servicio')->get();
        } else {
            $citas = Cita::with('mascota', 'servicio')
                ->whereHas('mascota', function ($q) use ($query) {
                    $q->where('nombre', 'like', '%' . $query . '%');
                })
                ->orWhereHas('servicio', function ($q) use ($query) {
                    $q->where('nombre', 'like', '%' . $query . '%');
                })
                ->orWhere('fecha', 'like', '%' . $query . '%')
                ->orWhere('hora', 'like', '%' . $query . '%')
                ->get();
        }
        return response()->json(['citas' => $citas]);
    }
}

