<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | Esta opción define el guard de autenticación predeterminado y el broker
    | de restablecimiento de contraseñas para tu aplicación. Puedes cambiar
    | estos valores según sea necesario.
    |
    */

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Aquí puedes definir cada guard de autenticación para tu aplicación.
    | La configuración predeterminada utiliza almacenamiento de sesión
    | más el proveedor de usuarios Eloquent.
    |
    | Soportado: "session"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | Todos los guards de autenticación tienen un proveedor de usuarios, que
    | define cómo se recuperan los usuarios de tu base de datos o sistema
    | de almacenamiento utilizado por la aplicación. Normalmente, se utiliza
    | Eloquent.
    |
    | Si tienes múltiples tablas o modelos de usuarios, puedes configurar
    | múltiples proveedores para representar cada modelo/tabla. Estos
    | proveedores se pueden asignar a cualquier guard adicional que
    | hayas definido.
    |
    | Soportado: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\User::class),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | Aquí puedes definir la configuración para el restablecimiento de
    | contraseñas, incluyendo la tabla que se utilizará para almacenar
    | los tokens y el proveedor que se invocará para recuperar los
    | usuarios. También puedes definir la expiración del token.
    |
    | El tiempo de expiración es el número de minutos durante los cuales
    | cada token de restablecimiento será válido. Esta característica de
    | seguridad hace que los tokens sean de corta duración para que
    | tengan menos tiempo de ser adivinados. Puedes cambiar esto según
    | sea necesario.
    |
    | La configuración de throttle es el número de segundos que un usuario
    | debe esperar antes de generar más tokens de restablecimiento de
    | contraseñas. Esto previene que los usuarios generen rápidamente
    | una gran cantidad de tokens de restablecimiento.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Aquí puedes definir la cantidad de segundos antes de que una ventana de
    | confirmación de contraseña expire y los usuarios deban volver a ingresar
    | su contraseña a través de la pantalla de confirmación. Por defecto, la
    | expiración dura tres horas.
    |
    */

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
