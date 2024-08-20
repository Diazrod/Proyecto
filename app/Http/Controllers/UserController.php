<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Roles;
use App\Models\Personas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
      

        $users = User::with('role')->get();
        $roles = Roles::all();
        $personas = Personas::all(); // Cargar todas las personas
        return view('users.index', compact('users', 'roles', 'personas'));
    }

    public function edit(User $user)
    {
        $roles = Roles::all();
        $personas = Personas::all(); // Cargar todas las personas
        return view('users.edit', compact('user', 'roles', 'personas'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'COD_ROL' => 'required|exists:roles,COD_ROL',
            'IND_USER' => 'required|in:1,0',
            'COD_PERSONAS' => ['nullable', 'exists:personas,COD_PERSONAS'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'COD_ROL' => $request->COD_ROL,
            'IND_USER' => $request->IND_USER,
            'COD_PERSONAS' => $request->COD_PERSONAS,
            'USR_ADD' => Auth::user()->name,
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}
