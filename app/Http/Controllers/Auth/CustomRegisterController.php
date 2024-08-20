<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Roles;
use App\Models\Personas;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CustomRegisterController extends Controller
{
    use RegistersUsers {
        register as registration;
    }

    protected $redirectTo = '/users'; // Redirigir a la vista de índice de usuarios

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showCustomRegistrationForm()
    {
        $roles = Roles::all();
        $personas = Personas::all(); // Asegúrate de tener el modelo Personas
        return view('auth.register_custom', compact('roles', 'personas'));
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'COD_PERSONAS' => ['nullable', 'exists:personas,COD_PERSONAS'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'COD_ROL' => ['required', 'exists:roles,COD_ROL'],
            'IND_USER' => ['required', 'in:1,0'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'COD_PERSONAS' => $data['COD_PERSONAS'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'COD_ROL' => $data['COD_ROL'],
            'IND_USER' => $data['IND_USER'],
            'USR_ADD' => Auth::user()->name,
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $this->create($request->all());

        return redirect($this->redirectPath())->with('success', 'Usuario creado exitosamente.');
    }

    public function checkUsername(Request $request)
    {
        $username = $request->username;
        $available = !User::where('name', $username)->exists();
        return response()->json(['available' => $available]);
    }
}
