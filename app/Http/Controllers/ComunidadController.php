<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


use Illuminate\Http\Request;


class ComunidadController extends Controller
{



    public function comunidad()
{
    $tipo = 'COMUNIDAD'; // O 'REGISTRO_COMUNIDAD', dependiendo de lo que quieras consultar

    try {
        // Llamar a la API del servidor
        $response = Http::get('http://localhost:3000/Comunidad/' . $tipo);

        // Verificar si la respuesta es exitosa
        if ($response->ok()) {
            return view('comunidad')->with('comunidades', $response->json());
        } else {
            // Redirigir a la página principal en caso de error
            return redirect('/')->with('error', 'Error al obtener datos de la API');
        }
    } catch (\Exception $e) {
        // Redirigir a la página principal en caso de excepción
        return response()->json(['error' => 'Excepción capturada', 'message' => $e->getMessage()], 500);
    }
}



public function buscar_Comunidad()
{
    $tipo = 'COMUNIDAD';

    try {
        // Llamar a la API del servidor
        $response = Http::get('http://localhost:3000/Comunidad/' . $tipo);

        // Verificar si la respuesta es exitosa
        if ($response->successful()) {
            // Retornar los datos como JSON para DataTables
            return response()->json([
                'data' => $response->json() // Asegúrate de que esta es la propiedad correcta en la respuesta
            ]);
        } else {
            // Redirigir a la página principal en caso de error
            return response()->json(['error' => 'No se pudo obtener los datos de tipo de proyectos.'], 500);
        }
    } catch (\Exception $e) {
        // Redirigir a la página principal en caso de excepción
        return response()->json(['error' => 'Error en la solicitud: ' . $e->getMessage()], 500);
    }
}






public function comunidadRegistro()
{
    $tipo = 'REGISTRO_COMUNIDAD'; // O 'REGISTRO_COMUNIDAD', dependiendo de lo que quieras consultar

    try {
        // Llamar a la API del servidor
        $response = Http::get('http://localhost:3000/Comunidad/' . $tipo);

        // Verificar si la respuesta es exitosa
        if ($response->ok()) {
            return view('comunidadReg')->with('registros', $response->json());
        } else {
            // Redirigir a la página principal en caso de error
            return redirect('/')->with('error', 'Error al obtener datos de la API');
        }
    } catch (\Exception $e) {
        // Redirigir a la página principal en caso de excepción
        return response()->json(['error' => 'Excepción capturada', 'message' => $e->getMessage()], 500);
    }
}


public function crearComunidad(Request $request)
{
    $tipo = 'INSERTAR_COMUNIDAD'; // Asumo que 'INSERTAR_REGISTRO' es el valor de P_ACCION que deseas

    // Datos de la comunidad obtenidos del formulario
    $datos = [
        'P_ACCION' => $tipo,
        'P_NOM_COMUNIDAD' => $request->input('NOM_COMUNIDAD'),
        'P_DIRECC_COMUNIDAD' => $request->input('DIRECC_COMUNIDAD'),
        'P_CANT_FAMILIAS' => '0',
        'P_COD_COMUNIDAD' => '0',
        'P_COD_PERSONAS' => '0',
        'P_NUM_FAMILIARES' => '0',
        'P_TIP_VIVIENDA' =>'PROPIA',
        'P_PROFESION_OFICIO' =>  '0',
        'P_RELIGION' => 'CATOLICA',
        'P_CANT_MATRIMONIO' =>  'SI',
        'P_CANT_BAUTISMO' =>  '0',
        'P_CANT_COMUNION' => '0',
        'P_CANT_CONFRIMACION' =>  '0',
        'P_MISA' => 'SEMANAL',
        'P_GRUP_PARROQUIAL' =>'PASTORAL SOCIAL',
        'P_ESTRATO_FAMILIAR' => 'BAJA'
    ];

    // URL de tu API externa donde insertas la comunidad
    $urlAPI = "http://localhost:3000/Comunidad";

    try {
        // Realizar la inserción en la base de datos externa
        $response = Http::post($urlAPI, $datos);

        if ($response->ok()) {
            return redirect()->back()->with('success', 'Comunidades registrada con éxito.');
        } else {
            return redirect()->back()->with('error', 'Error al registrar la comunidades Verifique los datos.');
        }
    } catch (\Exception $e) {
        // Manejar cualquier excepción que pueda surgir durante la llamada a la API
        return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
    }
}









public function crearRegComunidad(Request $request)
{
    $tipo = 'INSERTAR_REGISTRO'; // Asumo que 'INSERTAR_REGISTRO' es el valor de P_ACCION que deseas

    // Datos de la comunidad obtenidos del formulario
    $datos = [
        'P_ACCION' => $tipo,
        'P_NOM_COMUNIDAD' => '0',
        'P_DIRECC_COMUNIDAD' => '0',
        'P_CANT_FAMILIAS' => '0',
        'P_COD_COMUNIDAD' => $request->input('COD_COMUNIDAD'),
        'P_COD_PERSONAS' => $request->input('COD_PERSONA'),
        'P_NUM_FAMILIARES' => $request->input('NUM_FAMILIARES'),
        'P_TIP_VIVIENDA' =>$request->input('TIP_VIVIENDA'),
        'P_PROFESION_OFICIO' => $request->input('PROFESION_OFICIO'),
        'P_RELIGION' => $request->input('RELIGION'),
        'P_CANT_MATRIMONIO' => $request->input('CANT_MATRIMONIO'),
        'P_CANT_BAUTISMO' => $request->input('CANT_BAUTISMO'),
        'P_CANT_COMUNION' => $request->input('CANT_COMUNION'),
        'P_CANT_CONFRIMACION' => $request->input('CANT_CONFRIMACION'),
        'P_MISA' => $request->input('MISA'),
        'P_GRUP_PARROQUIAL' => $request->input('GRUP_PARROQUIAL'),
        'P_ESTRATO_FAMILIAR' => $request->input('ESTRATO_FAMILIAR')

    ];

    // URL de tu API externa donde insertas la comunidad
    $urlAPI = "http://localhost:3000/Comunidad";

    try {
        // Realizar la inserción en la base de datos externa
        $response = Http::post($urlAPI, $datos);

        if ($response->ok()) {
            return redirect()->back()->with('success', 'Comunidad registrada con éxito.');
        } else {
            return redirect()->back()->with('error', 'Error la persona ya esta registrda en comunidad.');
        }
    } catch (\Exception $e) {
        // Manejar cualquier excepción que pueda surgir durante la llamada a la API
        return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
    }
}



public function updateComunidad(Request $request, $id)
{
    // Datos del formulario para actualizar la comunidad
    $datos = [
        'P_ACCION' => 'ACTUALIZAR_COMUNIDAD',
        'P_NOM_COMUNIDAD' => $request->input('NOM_COMUNIDAD'),
        'P_DIRECC_COMUNIDAD' => $request->input('DIRECC_COMUNIDAD'),
        'P_CANT_FAMILIAS' => $request->input('CANT_FAMILIAS'),
        'P_COD_COMUNIDAD' => $request->input('COD_COMUNIDAD'),
        'P_COD_HOGAR' => '0',
        'P_NUM_FAMILIARES' => '0',
        'P_TIP_VIVIENDA' => 'TIP_VIVIENDA',
        'P_PROFESION_OFICIO' =>  '0',
        'P_RELIGION' => 'CATOLICA',
        'P_CANT_MATRIMONIO' => 'SI',
        'P_CANT_BAUTISMO' =>  '0',
        'P_CANT_COMUNION' =>  '0',
        'P_CANT_CONFRIMACION' =>  '0',
        'P_MISA' => 'SEMANAL',
        'P_GRUP_PARROQUIAL' =>'PASTORAL SOCIAL',
        'P_ESTRATO_FAMILIAR' => 'BAJA'
    ];

    // URL de tu API externa para actualizar la comunidad específica
    $urlAPI = "http://localhost:3000/Comunidad";

    try {
        // Realizar la solicitud HTTP PUT a la API externa
        $response = Http::put($urlAPI, $datos);

        // Mostrar el cuerpo de la respuesta para depuración
        $responseBody = $response->body();
        if ($response->successful()) {
            return redirect()->back()->with('success', 'Registro de comunidad actualizado correctamente.');
        } else {
            return redirect()->back()->with('error', 'Error al actualizar el registro de comunidad. Detalles: ' . $responseBody);
        }
    } catch (\Exception $e) {
        // Manejar cualquier excepción que pueda surgir durante la llamada a la API
        return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
    }
}


public function updateComunidadReg(Request $request, $id)
{
    // Datos del formulario para actualizar la comunidad
    $datos = [
        'P_ACCION' => 'ACTUALIZAR_REGISTRO',
        'P_NOM_COMUNIDAD' =>'0',
        'P_DIRECC_COMUNIDAD' => '0',
        'P_CANT_FAMILIAS' =>'0',
        'P_COD_COMUNIDAD' =>$request->input('COD_HOGAR'),
        'P_COD_HOGAR' => $request->input('COD_HOGAR'),
        'P_NUM_FAMILIARES' => $request->input('NUM_FAMILIARES'),
        'P_TIP_VIVIENDA' => $request->input('TIP_VIVIENDA'),
        'P_PROFESION_OFICIO' => $request->input('PROFESION_OFICIO'),
        'P_RELIGION' => $request->input('RELIGION'),
        'P_CANT_MATRIMONIO' => $request->input('CANT_MATRIMONIO'),
        'P_CANT_BAUTISMO' => $request->input('CANT_BAUTISMO'),
        'P_CANT_COMUNION' => $request->input('CANT_COMUNION'),
        'P_CANT_CONFRIMACION' => $request->input('CANT_CONFRIMACION'),
        'P_MISA' => $request->input('MISA', 'SEMANAL'),
        'P_GRUP_PARROQUIAL' => $request->input('GRUP_PARROQUIAL'),
        'P_ESTRATO_FAMILIAR' => $request->input('ESTRATO_FAMILIAR')
    ];

    // URL de tu API externa para actualizar la comunidad específica
    $urlAPI = "http://localhost:3000/Comunidad";

    try {
        // Realizar la solicitud HTTP PUT a la API externa
        $response = Http::put($urlAPI, $datos);

        // Mostrar el cuerpo de la respuesta para depuración
        $responseBody = $response->body();
        if ($response->successful()) {
            return redirect()->back()->with('success', 'Registro de comunidad actualizado correctamente.');
        } else {
            return redirect()->back()->with('error', 'Error al actualizar el registro de comunidad. Detalles: ' . $responseBody);
        }
    } catch (\Exception $e) {
        // Manejar cualquier excepción que pueda surgir durante la llamada a la API
        return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
    }
}


}// FIN DEL cONTROLADOR 



