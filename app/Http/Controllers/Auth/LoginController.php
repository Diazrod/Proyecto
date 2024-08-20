<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Permiso;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';  // Ruta a la que se redirige después de login

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Middleware para asegurar que solo los invitados pueden acceder a la página de login
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Muestra el formulario de login con encabezados que previenen el caché.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return response(view('auth.login'))->withHeaders([
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    /**
     * Maneja la autenticación después de un login exitoso.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    protected function authenticated(Request $request, $user)
    {
        // Regenerar la sesión de Laravel
        $request->session()->regenerate();

        // Verificar e iniciar la sesión PHP nativa si no ha sido iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Obtener permisos del usuario
        $permisos = Permiso::where('COD_ROL', $user->COD_ROL)->get()->toArray();

        // Guardar los permisos en la sesión de Laravel y la sesión PHP nativa
        Session::put('user_permisos', $permisos);
        $_SESSION['user_permisos'] = $permisos;

        // Log exitoso de autenticación
        Log::info('User logged in successfully', ['user_id' => $user->id]);

        // Redireccionar al dashboard después del login
        return redirect()->intended($this->redirectPath());
    }

    /**
     * Maneja la solicitud de cierre de sesión.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Destruir la sesión PHP nativa
        session_unset();
        session_destroy();

        // Desconectar al usuario de Laravel
        $user = Auth::user();
        Auth::logout();

        // Invalidar la sesión de Laravel
        $request->session()->invalidate();

        // Regenerar el token de la sesión
        $request->session()->regenerateToken();

        // Log de salida de usuario
        Log::info('User logged out', ['user_id' => $user->id]);

        return redirect('/');
    }

    /**
     * Responde a un intento fallido de inicio de sesión.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        // Mensaje de error personalizado
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    /**
     * Obtiene el nombre de usuario utilizado para la autenticación.
     *
     * @return string
     */
    public function username()
    {
        return 'email'; // Campo utilizado para la autenticación
    }
}
