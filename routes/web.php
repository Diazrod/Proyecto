<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ObjetosController;
use App\Http\Controllers\PermisosController;
use App\Http\Controllers\Auth\CustomRegisterController;
use App\Http\Controllers\Personacontroller;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\SacramentosController;
use App\Http\Controllers\BienesController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\ComunidadController;
use App\Http\Controllers\BecasController;
use App\Http\Controllers\FinanzasController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CalendarController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;


// Rutas de autenticación
//Auth::routes();

// Ruta de inicio de sesión
// Ruta raíz muestra el formulario de login
//Route::get('/', [LoginController::class, 'showLoginForm'])->name('root.login');


// Rutas de autenticación
Route::middleware('guest')->group(function () {
    // Ruta raíz muestra el formulario de login
    Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    
    // Rutas de Restablecimiento de Contraseña (Password Reset)
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
    // Otras rutas para usuarios no autenticados, como registro
});


// Grupo de rutas protegidas por autenticación y verificación de email
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', [DashboardController::class, 'dashboard'])->name('home');


    Route::resource('roles', RoleController::class);
    Route::resource('objetos', ObjetosController::class);
    Route::resource('permisos', PermisosController::class);
    
    // Rutas de autenticación
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [CustomRegisterController::class, 'showCustomRegistrationForm'])->name('users.create');
    Route::post('users', [CustomRegisterController::class, 'register'])->name('users.store');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('users/checkUsername', [CustomRegisterController::class, 'checkUsername'])->name('users.checkUsername');

Route::get('custom-register', [CustomRegisterController::class, 'showCustomRegistrationForm'])->name('custom-register');
Route::post('custom-register', [CustomRegisterController::class, 'register']);
Route::get('/Feligreses', [PersonaController::class, 'Feligreses']); 

   
    Route::post('/crearPersona', [PersonaController::class, 'crearPersona'])->name('crearPersona');
    Route::put('/personas/{id}', [PersonaController::class, 'actualizarPersona'])->name('actualizarPersona');
    Route::get('/personas/{id}', [PersonaController::class, 'obtenerPersonaPorId'])->name('obtenerPersonaPorId');




// Ruta para obtener personas
Route::get('/personas/obtener', [PersonaController::class, 'obtenerPersonas'])->name('personas.obtener');

// Rutas para empleados
Route::resource('empleados', EmpleadoController::class);



//--------------------- MODULO SACRAMENTOS  -----------------



//********  RUTAS DE GENERAL ***********
Route::get('/sacramentos/general', [SacramentosController::class, 'general'])->name('sacramentos.general');  



//********  RUTAS DE BAUTIZO ***********
Route::get('/sacramentos/bautizo', [SacramentosController::class, 'bautizo'])->name('sacramentos.bautizo');
Route::get('/ins_bautizo', function () {
    return view('ins_bautizo');
})->name('insBautizo');

Route::post('/crearBautizo', [SacramentosController::class, 'crearBautizo'])->name('crearBautizo');
Route::put('/bautizo/{id}', [SacramentosController::class, 'updateBautizo'])->name('bautizo.update');



//********  RUTAS DE CONFIRMACIÓN ***********
Route::get('/sacramentos/confirmacion', [SacramentosController::class, 'confirmacion'])->name('sacramentos.confirmacion');
Route::get('/ins_confirmacion', function () {
    return view('ins_confirmacion');
})->name('insconfirmacion');


Route::post('/crearConfirmacion', [SacramentosController::class, 'crearConfirmacion'])->name('crearConfirmacion');
Route::put('/confirmacion/{id}', [SacramentosController::class, 'updateConfirmacion'])->name('confirmacion.update');



//********  RUTAS DE PRIMERA COMUNIÓN ***********
Route::get('/sacramentos/comunion', [SacramentosController::class, 'comunion'])->name('sacramentos.comunion');
Route::get('/ins_comunion', function () {
    return view('ins_comunion');
})->name('inscomunion');

Route::post('/crearComunion', [SacramentosController::class, 'crearComunion'])->name('crearComunion');
Route::put('/comunion/{id}', [SacramentosController::class, 'updateComunion'])->name('comunion.update');



//********  RUTAS DE MATRIMONIO ***********
Route::get('/sacramentos/matrimonio', [SacramentosController::class, 'matrimonio'])->name('sacramentos.matrimonio');
Route::get('/ins_matrimonio', function () {
    return view('ins_matrimonio');
})->name('insmatrimonio');

Route::post('/crearMatrimonio', [SacramentosController::class, 'crearMatrimonio'])->name('crearMatrimonio');
Route::put('/matrimonio/{id}', [SacramentosController::class, 'updateMatrimonio'])->name('matrimonio.update');




//********  RUTAS DE UNCIÓN ENFERMOS ***********
Route::get('/sacramentos/uncion', [SacramentosController::class, 'uncion'])->name('sacramentos.uncion');
Route::get('/ins_uncion', function () {
    return view('ins_uncion');
})->name('insuncion');

Route::post('/crearUncion', [SacramentosController::class, 'crearUncion'])->name('crearUncion');
Route::put('/uncion/{id}', [SacramentosController::class, 'updateUncion'])->name('uncion.update');



//********  RUTAS DE ORDEN SACERSOTAL ***********

Route::get('/sacramentos/orden', [SacramentosController::class, 'orden'])->name('sacramentos.orden');
Route::get('/ins_orden', function () {
    return view('ins_orden');
})->name('insorden');

Route::post('/crearOrden', [SacramentosController::class, 'crearOrden'])->name('crearOrden');
Route::put('/orden/{id}', [SacramentosController::class, 'updateOrden'])->name('orden.update');


//********  RUTAS DE RECONCILIACIÓN ***********
Route::get('/sacramentos/reconciliacion', [SacramentosController::class, 'reconciliacion'])->name('sacramentos.reconciliacion');
Route::get('/ins_reconciliacion', function () {
    return view('ins_reconciliacion');
})->name('insBautizo');

Route::post('/crearREeconciliacion', [SacramentosController::class, 'crearREeconciliacion'])->name('crearREeconciliacion');
Route::get('/reconciliacion/{id}/edit', [SacramentosController::class, 'editReconciliacion'])->name('reconciliacion.edit');
Route::put('/reconciliacion/{id}', [SacramentosController::class, 'updateReconciliacion'])->name('reconciliacion.update');


//********  RUTAS DE DATOS DE LA PERSONA  ***********
Route::get('/obtener_personas', [SacramentosController::class, 'obtenerPersonas'])->name('personas.obtener');




//--------------------- MODULO BIENES RUTAS -----------------


//********  RUTAS DE BIENES***********

Route::get('/bienes', [BienesController ::class, 'bienes'])->name('bienes');
Route::post('/insertarBien', [BienesController::class, 'insertarBien']);
Route::put('/updateBien/{id}', [BienesController::class, 'updateBien'])->name('updateBien');



//--------------------- MODULO SOCIAL RUTAS -----------------


//********  RUTAS DE SOLICITUD DE AYUDA SOCIAL ***********


Route::get('/solicitud', [SocialController::class, 'solicitudAyudaSocial']);
Route::post('/solicitud_INS', [SocialController::class, 'crearSolicitud']);
Route::put('/social/{id}', [SocialController::class, 'updateSocial'])->name('social.update');

//********  RUTAS DE TIPO PROYECTOS ***********

Route::get('/tipo_Proyectos', [SocialController::class, 'tipo_proyectos']);
Route::post('/Tipo_INS', [SocialController::class, 'crearTipo']);
Route::put('/tipo/{id}', [SocialController::class, 'updatetipo'])->name('tipo.update');
Route::get('/buscar_proyecto', [SocialController::class, 'buscar_proyecto']);


//********  RUTAS DE REGISTROS PROYECTOS ***********
Route::get('/Proyectos', [SocialController::class, 'proyectos']);
Route::post('/Proyecto_INS', [SocialController::class, 'crearProyectos']);
Route::put('/Proyecto/{id}', [SocialController::class, 'updateProyecto'])->name('Proyecto.update');


//--------------------- MODULO COMUNIDAD RUTAS -----------------


//********  RUTAS DE COMUNIDADES ***********

Route::get('/comunidad', [ComunidadController::class, 'comunidad'])->name('comunidad.data');
Route::post('/Comunidad_INS', [ComunidadController::class, 'crearComunidad']);
Route::put('/comunidad/{id}', [ComunidadController::class, 'updateComunidad'])->name('comunidad.update');


//********  RUTAS DE HOGARES ***********
Route::get('/comunidadReg', [ComunidadController::class, 'comunidadRegistro']);
Route::post('/Rcomunidad_INS', [ComunidadController::class, 'crearRegComunidad']);
Route::put('/Rcomunidad/{id}', [ComunidadController::class, 'updateComunidadReg'])
    ->name('rcomunidad.update');



// web.php (Archivo de rutas de Laravel)
Route::get('/buscar-comunidad', [ComunidadController::class, 'buscar_Comunidad'])->name('comunidad.buscar');




// Rutas de get de Finanzas


Route::get('/cuenta', [FinanzasController::class, 'cuenta']);
Route::get('/consulta_mes', [FinanzasController::class, 'consultaMes']);
Route::get('/finanza', [FinanzasController::class, 'financa']);
Route::get('/obtener-cuentas', [FinanzasController::class, 'obtenerCuentas'])->name('obtener.cuentas');

//rutas de modificar de finanzas
Route::post('/finanzas/crear', [FinanzasController::class, 'crearFinanzas'])->name('crear.finanzas');
//rutas de Ingresar de Cuenta
Route::post('/cuenta/crear', [FinanzasController::class, 'crearcuenta'])->name('crear.Cuenta');
// Ruta para actualizar finanzas
Route::post('/finanzas/actualizar', [FinanzasController::class, 'actualizarFinanzas'])->name('actualizar.finanzas');
Route::put('/cuentas/{id}', [FinanzasController::class, 'updateFinanzas'])->name('cuenta.update');
Route::put('/finanzas/{id}', [FinanzasController::class, 'updateREGFinanzas'])->name('finanzas.update');

// --------- Modulo de Becas -----------

//ruta get
Route::get('/becas', [BecasController::class, 'becas']);
Route::post('/insertarBeca', [BecasController::class, 'insertarBeca'])->name('becas.insertar');
Route::put('/updateBeca/{id}', [BecasController::class, 'updateBeca'])->name('updateBeca');


//AGENDAA

Route::get('/tipo_eventos', [CalendarController::class, 'tipo_eventos']);
Route::get('/agenda', [CalendarController::class, 'agenda']);
Route::get('/solicitud_servicios', [CalendarController::class, 'solicitud_servicios']);


Route::post('/agenda', [CalendarController::class, 'crearAgenda'])->name('agenda.crear');

Route::post('/crearAgenda', [CalendarController::class, 'crearAgenda'])->name('crearAgenda');

Route::post('/crearEvento', [CalendarController::class, 'crearEvento'])->name('crearEvento');

Route::post('/crearSolicitud', [CalendarController::class, 'crearSolicitud'])->name('crearSolicitud');



Route::put('/updateTipo_evento/{id}', [CalendarController::class, 'updateTipo_evento'])->name('updateTipo_evento');

Route::put('/updateAgenda/{id}', [CalendarController::class, 'updateAgenda'])->name('updateAgenda');

Route::put('/updateSolicitud/{id}', [CalendarController::class, 'updateSolicitud'])->name('updateSolicitud');


Route::get('Calendar', [CalendarController::class, 'index'])->name('Calendar/index');

});


Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Ruta que muestra la vista de verificación de email
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Ruta que maneja el enlace de verificación en el email
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

// Ruta para reenviar el email de verificación
Route::post('/email/verification-notification', function () {
    $user = Auth::user(); // Obtén el usuario autenticado

    if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail()) {
        $user->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    }

    return back()->with('message', 'Your email is already verified.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');



