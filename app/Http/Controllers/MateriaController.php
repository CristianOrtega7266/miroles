<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materia;

class MateriaController extends Controller
{
    public function index()
    {
        $materias = Materia::all();
        return view('materias.index', compact('materias'));
    }

    public function create()
    {
        return view('materias.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:10|unique:materias',
            'creditos' => 'required|integer|min:1',
            'descripcion' => 'nullable|string',
            'semestre' => 'required|integer',
        ]);

        Materia::create($validated);
        return redirect()->route('materias.index')->with('success', 'Materia creada con éxito.');
    }

    public function edit($id)
    {
        $materia = Materia::findOrFail($id);
        return view('materias.edit', compact('materia'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:10',
            'creditos' => 'required|integer|min:1',
            'descripcion' => 'nullable|string',
            'semestre' => 'required|integer',
        ]);

        $materia = Materia::findOrFail($id);
        $materia->update($validated);
        return redirect()->route('materias.index')->with('success', 'Materia actualizada con éxito.');
    }

    public function destroy($id)
    {
        $materia = Materia::findOrFail($id);
        $materia->delete();
        return redirect()->back()->with('success', 'Materia eliminada con éxito.');
    }
}
