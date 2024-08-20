<?php
// app/Http/Controllers/RoleController.php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Roles::all();
        return view('roles.index', compact('roles'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'NOM_ROL' => 'required|max:255',
            'DES_ROL' => 'required|max:255',
            'IND_ROL' => 'required|in:1,0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Roles::create([
            'NOM_ROL' => $request->NOM_ROL,
            'DES_ROL' => $request->DES_ROL,
            'IND_ROL' => $request->IND_ROL,
            'USR_ADD' => Auth::user()->name, // Asumiendo que el nombre del usuario se guarda en el campo 'name'
        ]);

        return redirect()->route('roles.index')->with('success', 'Rol creado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'NOM_ROL' => 'required|max:255',
            'DES_ROL' => 'required|max:255',
            'IND_ROL' => 'required|in:1,0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $role = Roles::findOrFail($id);
        $role->update([
            'NOM_ROL' => $request->NOM_ROL,
            'DES_ROL' => $request->DES_ROL,
            'IND_ROL' => $request->IND_ROL,
            'USR_ADD' => Auth::user()->name, // Asumiendo que el nombre del usuario se guarda en el campo 'name'
        ]);

        return redirect()->route('roles.index')->with('success', 'Rol actualizado exitosamente.');
    }
}
