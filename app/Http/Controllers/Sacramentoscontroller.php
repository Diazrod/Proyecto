<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SacramentosController extends Controller
{
    /**
     * Muestra una lista de los sacramentos de tipo "BAUTISMO".
     *
     * @return \Illuminate\Http\Response
     */

     /** Funcion para Buscar Persona */

   
     public function obtenerPersonas(Request $request)
     {
         try {
             // Obtener parámetros de DataTables
             $search = $request->input('search.value');
             $start = $request->input('start');
             $length = $request->input('length');
             $draw = $request->input('draw');
     
             // Llama a la API externa
             $response = Http::get('http://localhost:3000/Bpersonas');
     
             if ($response->successful()) {
                 $results = $response->json();
                 
                 // Filtra los resultados según la búsqueda
                 if ($search) {
                     $results = array_filter($results, function ($item) use ($search) {
                         return strpos(strtolower($item['PR_NOMBRE']), strtolower($search)) !== false ||
                                strpos(strtolower($item['SG_NOMBRE']), strtolower($search)) !== false ||
                                strpos(strtolower($item['PR_APELLIDO']), strtolower($search)) !== false ||
                                strpos(strtolower($item['SG_APELLIDO']), strtolower($search)) !== false ||
                                strpos(strtolower($item['DNI_PERSONA']), strtolower($search)) !== false;
                     });
                 }
     
                 // Total de resultados después del filtrado
                 $totalFiltered = count($results);
     
                 // Pagina los resultados
                 $filteredResults = array_slice($results, $start, $length);
     
                 // Formatea la respuesta
                 return response()->json([
                     'draw' => intval($draw),
                     'recordsTotal' => count($results),
                     'recordsFiltered' => $totalFiltered,
                     'data' => $filteredResults,
                 ]);
             } else {
                 \Log::error('Error al obtener los datos de personas: Respuesta no exitosa de la API externa');
                 return response()->json(['error' => 'Error al obtener los datos de personas.', 'message' => 'Respuesta no exitosa de la API externa'], $response->status());
             }
         } catch (\Exception $e) {
             \Log::error('Error al obtener los datos de personas: ' . $e->getMessage());
             return response()->json(['error' => 'Error al obtener los datos de personas.', 'message' => $e->getMessage()], 500);
         }
     }
     
     

     //********************************* Funciones de Select ***************************** */

     public function bautizo()
     {
         $tipo = 'BAUTIZO';
         
         try {
             // Llamar a la API del servidor
             $response = Http::get('http://localhost:3000/sacramentos1/' . $tipo);
         
             // Verificar si la respuesta es exitosa
             if ($response->ok()) {
                 return view('bautizo')->with('ResulSacramentos', $response->json());
             } else {
                 // Redirigir a la página principal en caso de error
                 return redirect('/');
             }
         } catch (\Exception $e) {
             // Redirigir a la página principal en caso de excepción
             return response()->json(['error' => 'Excepción capturada', 'message' => $e->getMessage()], 500);
         }
     }

     public function confirmacion()
     {
         $tipo = 'CONFIRMACION';
         
         try {
             // Llamar a la API del servidor
             $response = Http::get('http://localhost:3000/sacramentos1/' . $tipo);
             
             // Verificar si la respuesta es exitosa
             if ($response->ok()) {
                 return view('confirmacion')->with('ResulConfirmaciones', $response->json());
             } else {
                 // Redirigir a la página principal en caso de error
                 return redirect('/');
             }
         } catch (\Exception $e) {
             // Redirigir a la página principal en caso de excepción
             return response()->json(['error' => 'Excepción capturada', 'message' => $e->getMessage()], 500);
         }
     }


     
 
     public function comunion()
     {
         $tipo = 'PRIMERA COMUNION';
 
         try {
             // Llamar a la API del servidor
             $response = Http::get('http://localhost:3000/sacramentos1/' . $tipo);
 
             // Verificar si la respuesta es exitosa
             if ($response->ok()) {
                 return view('comunion')->with('ResulSacramentos', $response->json());
             } else {
                 // Redirigir a la página principal en caso de error
                 return redirect('/');
             }
         } catch (\Exception $e) {
             // Redirigir a la página principal en caso de excepción
             return redirect('/');
         }
     }
 
     public function matrimonio()
     {
         $tipo = 'MATRIMONIO';
 
         try {
             // Llamar a la API del servidor
             $response = Http::get('http://localhost:3000/sacramentos1/' . $tipo);
 
             // Verificar si la respuesta es exitosa
             if ($response->ok()) {
                 return view('matrimonio')->with('ResulSacramentos', $response->json());
             } else {
                 // Redirigir a la página principal en caso de error
                 return redirect('/');
             }
         } catch (\Exception $e) {
             // Redirigir a la página principal en caso de excepción
             return redirect('/');
         }
     }
 
     public function general()
     {
         $tipo = 'GENERAL';
 
         try {
             // Llamar a la API del servidor
             $response = Http::get('http://localhost:3000/sacramentos2/' . $tipo);
 
             // Verificar si la respuesta es exitosa
             if ($response->ok()) {
                 return view('general')->with('ResulSacramentos', $response->json());
             } else {
                 // Redirigir a la página principal en caso de error
                 return redirect('/');
             }
         } catch (\Exception $e) {
             // Redirigir a la página principal en caso de excepción
             return redirect('/');
         }
     }
 
     public function uncion()
     {
         $tipo = 'UNCION ENFERMOS';
 
         try {
             // Llamar a la API del servidor
             $response = Http::get('http://localhost:3000/sacramentos2/' . $tipo);
 
             // Verificar si la respuesta es exitosa
             if ($response->ok()) {
                 return view('uncion')->with('ResulSacramentos', $response->json());
             } else {
                 // Redirigir a la página principal en caso de error
                 return redirect('/');
             }
         } catch (\Exception $e) {
             // Redirigir a la página principal en caso de excepción
             return redirect('/');
         }
    } 




    public function orden()
{
    $tipo = 'ORDEN SACERDOTAL';
    
    try {
        // Llamar a la API del servidor
        $response = Http::get('http://localhost:3000/sacramentos2/' . $tipo);
    
        // Verificar si la respuesta es exitosa
        if ($response->ok()) {
            return view('orden')->with('ResulSacramentos', $response->json());
        } else {
            // Redirigir a la página principal en caso de error
            return redirect('/');
        }
    } catch (\Exception $e) {
        // Redirigir a la página principal en caso de excepción
        return response()->json(['error' => 'Excepción capturada', 'message' => $e->getMessage()], 500);
    }
}


public function reconciliacion()
{
    $tipo = 'RECONCILIACION';
    
    try {
        // Llamar a la API del servidor
        $response = Http::get('http://localhost:3000/sacramentos2/' . $tipo);
    
        // Verificar si la respuesta es exitosa
        if ($response->ok()) {
            return view('RECONCILIACION')->with('ResulSacramentos', $response->json());
        } else {
            // Redirigir a la página principal en caso de error
            return redirect('/');
        }
    } catch (\Exception $e) {
        // Redirigir a la página principal en caso de excepción
        return response()->json(['error' => 'Excepción capturada', 'message' => $e->getMessage()], 500);
    }
}


// ******************************* funcion para el ins_bautizo *******************************

public function crearBautizo(Request $request)
{
    $tipo = 'BAUTIZO';

   
    $datos = [
        'P_NOM_SACRAMENTO' => $tipo,
        'P_COD_PERSONAS' => $request->input('cod_personas'),
        'P_FECHA' => $request->input('fecha'),
        'P_TIP_HIJO' => $request->input('tipo_hijo'),
        'P_COD_MADRE' => $request->input('cod_madre'),
        'P_COD_PADRE' => $request->input('cod_padre'),
        'P_PADRINOS' => $request->input('padrinosIngresados'),
        'P_LIBRO_REG' => $request->input('libro_reg'),
        'P_COD_MONS' => '0',
        'P_COD_PARROCO' => $request->input('cod_parroco'),
        'P_OBSERVACIONES' => '0',
        'P_COD_CONTRAYENTE_MUJER' => '0',
        'P_COD_CONTRAYENTE_HOMBRE' => '0',
        'P_FEC_BAUTIZO' => '2024-07-11',
        'P_NOM_TESTIGOS'  => '0',
        'P_PAR_BAUTIZO' => 'a',
        'P_NOM_LUGAR' => '0',
        'P_FOLIO_REG' => $request->input('folio_reg'),
        'P_NUMERO_REG' => $request->input('numero_reg'),
        'P_NOM_CIUDAD'  => 'a'
    ];

    // URL de tu API externa donde insertas el sacramento
    $urlAPI = "http://localhost:3000/sacramentos";

    try {
        // Realizar la inserción en la base de datos externa
        $response = Http::post($urlAPI, $datos);

        if ($response->ok()) {
            return redirect()->back()->with('success', 'Bautizo registrado con éxito.');
        } else {
            return redirect()->back()->with('error', 'Error Verifique que la Persona Ya esta registrada en Bautismo.');
        }
    } catch (\Exception $e) {
        // Manejar cualquier excepción que pueda surgir durante la llamada a la API
        return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
    }
}





// ******************************* funcion para el ins_bautizo *******************************

public function crearREeconciliacion(Request $request)
{
    $tipo = 'RECONCILIACION';

    
    $datos = [
        'P_NOM_SACRAMENTO' => $tipo,
        'P_COD_PERSONAS' => $request->input('cod_personas'),
        'P_FECHA' => $request->input('fecha'),
        'P_TIP_HIJO' => 'NATURAL',
        'P_COD_MADRE' => '0',
        'P_COD_PADRE' => '0',
        'P_PADRINOS' => 'a',
        'P_LIBRO_REG' => $request->input('libro_reg'),
        'P_COD_MONS' => '0',
        'P_COD_PARROCO' => $request->input('cod_parroco'),
        'P_OBSERVACIONES' => $request->input('observaciones'), 
        'P_COD_CONTRAYENTE_MUJER' => '0',
        'P_COD_CONTRAYENTE_HOMBRE' => '0',
        'P_FEC_BAUTIZO' => '2024-07-11',
       'P_NOM_TESTIGOS'  => '0',
        'P_PAR_BAUTIZO' => 'a',
        'P_NOM_LUGAR' => '0',
        'P_FOLIO_REG' => $request->input('folio_reg'),
        'P_NUMERO_REG' => $request->input('numero_reg'),
         'P_NOM_CIUDAD' => 'a'
    ];

    // URL de tu API externa donde insertas el sacramento
    $urlAPI = "http://localhost:3000/sacramentos";

    try {
        // Realizar la inserción en la base de datos externa
        $response = Http::post($urlAPI, $datos);

        if ($response->ok()) {
            return redirect()->back()->with('success', 'Reconciliación registrado con éxito.');
        } else {
            return redirect()->back()->with('error', 'Error Verifique que la Persona Ya esta registrada EN RECONCILIACIÓN');
        }
    } catch (\Exception $e) {
        // Manejar cualquier excepción que pueda surgir durante la llamada a la API
        return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
    }
}





// ******************************* funcion para el ins_orden *******************************

public function crearOrden(Request $request)
{
    $tipo = 'ORDEN SACERDOTAL';

   
    $datos = [
        'P_NOM_SACRAMENTO' => $tipo,
        'P_COD_PERSONAS' => $request->input('cod_personas'),
        'P_FECHA' => $request->input('fecha'),
        'P_TIP_HIJO' => 'NATURAL',
        'P_COD_MADRE' => '0',
        'P_COD_PADRE' => '0',
        'P_PADRINOS' => 'a',
        'P_LIBRO_REG' => $request->input('libro_reg'),
        'P_COD_MONS' => '0',
       
        'P_COD_PARROCO' => $request->input('cod_parroco'),
        'P_OBSERVACIONES' => $request->input('observaciones'), 
        'P_COD_CONTRAYENTE_MUJER' => '0',
        'P_COD_CONTRAYENTE_HOMBRE' => '0',
        'P_FEC_BAUTIZO' => '2024-07-11',
        'P_NOM_TESTIGOS'  => '0',
        'P_PAR_BAUTIZO' => 'a',
        'P_NOM_LUGAR' => $request->input('observaciones'),
        'P_FOLIO_REG' => $request->input('folio_reg'),
        'P_NUMERO_REG' => $request->input('numero_reg'),
        'P_NOM_CIUDAD' => 'a'
    ];

    // URL de tu API externa donde insertas el sacramento
    $urlAPI = "http://localhost:3000/sacramentos";

    try {
        // Realizar la inserción en la base de datos externa
        $response = Http::post($urlAPI, $datos);

        if ($response->ok()) {
            return redirect()->back()->with('success', 'Orden Sacerdotal registrado con éxito.');
        } else {
            return redirect()->back()->with('error', 'Error Verifique que la Persona Ya esta registrada en ORDEN SACERDOTAL');
        }
    } catch (\Exception $e) {
        // Manejar cualquier excepción que pueda surgir durante la llamada a la API
        return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
    }
}





// ******************************* funcion para el ins_Uncion *******************************

public function crearUncion(Request $request)
{
    $tipo = 'UNCION ENFERMOS';

    // Datos del bautizo obtenidos del formulario
    $datos = [
        'P_NOM_SACRAMENTO' => $tipo,
        'P_COD_PERSONAS' => $request->input('cod_personas'),
        'P_FECHA' => $request->input('fecha'),
        'P_TIP_HIJO' => 'NATURAL',
        'P_COD_MADRE' => '0',
        'P_COD_PADRE' => '0',
        'P_PADRINOS' => 'a',
        'P_LIBRO_REG' => $request->input('libro_reg'),
        'P_COD_MONS' => '0',
       
        'P_COD_PARROCO' => $request->input('cod_parroco'),
        'P_OBSERVACIONES' => $request->input('observaciones'), 
        'P_COD_CONTRAYENTE_MUJER' => '0',
        'P_COD_CONTRAYENTE_HOMBRE' => '0',
        'P_FEC_BAUTIZO' => '2024-07-11',
       'P_NOM_TESTIGOS'  => '0',
        'P_PAR_BAUTIZO' => 'a',
        'P_NOM_LUGAR' => $request->input('observaciones'),
        'P_FOLIO_REG' => $request->input('folio_reg'),
        'P_NUMERO_REG' => $request->input('numero_reg'),
        'P_NOM_CIUDAD'  => 'a'
    ];

    // URL de tu API externa donde insertas el sacramento
    $urlAPI = "http://localhost:3000/sacramentos";

    try {
        // Realizar la inserción en la base de datos externa
        $response = Http::post($urlAPI, $datos);

        if ($response->ok()) {
            return redirect()->back()->with('success', 'Uncion de Enfermos registrado con éxito.');
        } else {
            return redirect()->back()->with('error', 'Error Verifique que la Persona Ya esta registrada en UNCIÓN ENFERMOS.');
        }
    } catch (\Exception $e) {
        // Manejar cualquier excepción que pueda surgir durante la llamada a la API
        return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
    }
}




// ******************************* funcion para el ins_Primera Comunion *******************************

public function crearComunion(Request $request)
{
    $tipo = 'PRIMERA COMUNION';

    // Datos del bautizo obtenidos del formulario
    $datos = [
        'P_NOM_SACRAMENTO' => $tipo,
        'P_COD_PERSONAS' => $request->input('cod_personas'),
        'P_FECHA' => $request->input('fecha'),
        'P_TIP_HIJO' => 'NATURAL',
        'P_COD_MADRE' => $request->input('cod_madre'),
        'P_COD_PADRE' => $request->input('cod_padre'),
        'P_PADRINOS' => 'a',
        'P_LIBRO_REG' => $request->input('libro_reg'),
        'P_COD_MONS' => '0',
        'P_COD_PARROCO' => $request->input('cod_parroco'),
        'P_OBSERVACIONES' => $request->input('observaciones'), 
        'P_COD_CONTRAYENTE_MUJER' => '0',
        'P_COD_CONTRAYENTE_HOMBRE' => '0',
        'P_FEC_BAUTIZO'=> $request->input('FechaB'), 
        'P_NOM_TESTIGOS'  => '0',
        'P_PAR_BAUTIZO'=> $request->input('Parroquia_B'), 
        'P_NOM_LUGAR' => 'a',
        'P_FOLIO_REG' => $request->input('folio_reg'),
        'P_NUMERO_REG' => $request->input('numero_reg'),
        'P_NOM_CIUDAD'  => 'a'
    ];

    // URL de tu API externa donde insertas el sacramento
    $urlAPI = "http://localhost:3000/sacramentos";

    try {
        // Realizar la inserción en la base de datos externa
        $response = Http::post($urlAPI, $datos);

        if ($response->ok()) {
            return redirect()->back()->with('success', 'Primera Comunión registrado con éxito.');
        } else {
            return redirect()->back()->with('error', 'Error Verifique que la Persona Ya esta registrada en Primera Comunión.');
        }
    } catch (\Exception $e) {
        // Manejar cualquier excepción que pueda surgir durante la llamada a la API
        return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
    }
}


public function crearConfirmacion(Request $request)
{
    $tipo = 'CONFIRMACION';

    // Datos del bautizo obtenidos del formulario
    $datos = [
        'P_NOM_SACRAMENTO' => $tipo,
        'P_COD_PERSONAS' => $request->input('cod_personas'),
        'P_FECHA' => $request->input('fecha'),
        'P_TIP_HIJO' => 'NATURAL',
        'P_COD_MADRE' => $request->input('cod_madre'),
        'P_COD_PADRE' => $request->input('cod_padre'),
        'P_PADRINOS' => $request->input('padrinosIngresados'),
        'P_LIBRO_REG' => $request->input('libro_reg'),
        'P_COD_MONS' => $request->input('cod_monseñor'),
        'P_COD_PARROCO' => $request->input('cod_parroco'),
        'P_OBSERVACIONES' => $request->input('observaciones'), 
        'P_COD_CONTRAYENTE_MUJER' => '0',
        'P_COD_CONTRAYENTE_HOMBRE' => '0',
        'P_FEC_BAUTIZO'=> $request->input('FechaB'), 
        'P_NOM_TESTIGOS'  => '0',
        'P_PAR_BAUTIZO'=> $request->input('Parroquia_B'), 
        'P_NOM_LUGAR' => 'a',
        'P_FOLIO_REG' => $request->input('folio_reg'),
        'P_NUMERO_REG' => $request->input('numero_reg'),
        'P_NOM_CIUDAD' => $request->input('ciudad_nacimiento')
    ];

    // URL de tu API externa donde insertas el sacramento
    $urlAPI = "http://localhost:3000/sacramentos";

    try {
        // Realizar la inserción en la base de datos externa
        $response = Http::post($urlAPI, $datos);

        if ($response->ok()) {
            return redirect()->back()->with('success', 'Confirmación registrado con éxito.');
        } else {
            return redirect()->back()->with('error', 'Error Verifique que la Persona Ya esta registrada en Confirmación.');
        }
    } catch (\Exception $e) {
        // Manejar cualquier excepción que pueda surgir durante la llamada a la API
        return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
    }
}











public function crearMatrimonio(Request $request)
{
    $tipo = 'MATRIMONIO';

    // Datos del bautizo obtenidos del formulario
    $datos = [
        'P_NOM_SACRAMENTO' => $tipo,
        'P_COD_PERSONAS' => '0',
        'P_FECHA' => $request->input('fecha'),
        'P_TIP_HIJO' => 'NATURAL',
        'P_COD_MADRE' => '0',
        'P_COD_PADRE' => '0',
        'P_PADRINOS' => '0',
        'P_LIBRO_REG' => $request->input('libro_reg'),
        'P_COD_MONS' => '0',
        'P_COD_PARROCO' => $request->input('cod_parroco'),
        'P_OBSERVACIONES' => $request->input('observaciones'), 
        'P_COD_CONTRAYENTE_MUJER' => $request->input('codigo_mujer'),
        'P_COD_CONTRAYENTE_HOMBRE' => $request->input('codigo_hombre'),
        'P_FEC_BAUTIZO'=>'2024-07-11',
        'P_NOM_TESTIGOS'  => $request->input('padrinosIngresados'),
        'P_PAR_BAUTIZO'=> '0',
        'P_NOM_LUGAR' => 'a',
        'P_FOLIO_REG' => $request->input('folio_reg'),
        'P_NUMERO_REG' => $request->input('numero_reg'),
        'P_NOM_CIUDAD' => '0',
    ];

    // URL de tu API externa donde insertas el sacramento
    $urlAPI = "http://localhost:3000/sacramentos";

    try {
        // Realizar la inserción en la base de datos externa
        $response = Http::post($urlAPI, $datos);

        if ($response->ok()) {
            return redirect()->back()->with('success', 'Matrimonio registrado con éxito.');
        } else {
            return redirect()->back()->with('error', 'Error Verifique que los Contrayentes  no esten registrada en Matrimonio.');
        }
    } catch (\Exception $e) {
        // Manejar cualquier excepción que pueda surgir durante la llamada a la API
        return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
    }
}









    

//******************** Funciones de Modificar**********************/

  

    
    

    // Método para actualizar una reconciliación específica
    
    public function updateReconciliacion(Request $request, $id)
    {
        // Obtener el ID directamente desde el request
        $id = $request->input('id');

        // Verificar y registrar el ID recibido
        Log::info('ID recibido en updateReconciliacion: ' . $id);

        // Datos del formulario para actualizar la reconciliación
        $datos = [
            'P_NOM_SACRAMENTO' => 'RECONCILIACION',
            'P_COD_PERSONAS' => $request->input('editarCodPersonas'),
            'P_FECHA' => $request->input('editarFechaReconciliacion'),
            'P_TIP_HIJO' => 'NATURAL',
            'P_COD_MADRE' => '0',
            'P_COD_PADRE' => '0',
            'P_PADRINOS' => 'a',
            'P_LIBRO_REG' => $request->input('editarLibroRegistro'),
            'P_COD_MONS' => '0',
            'P_COD_PARROCO' => $request->input('editarCodSacerdote'),
            'P_OBSERVACIONES' => $request->input('editarObservaciones'),
            'P_COD_CONTRAYENTE_MUJER' => '0',
            'P_COD_CONTRAYENTE_HOMBRE' => '0',
            'P_FEC_BAUTIZO' => '2024-07-11',
            'P_NOM_TESTIGOS' => '0',
            'P_PAR_BAUTIZO' => 'a',
            'P_NOM_LUGAR' => $request->input('editarLugarSacramento'),
            'P_FOLIO_REG' => $request->input('editarFolioRegistro'),
            'P_NUMERO_REG' => $request->input('editarNumeroRegistro'),
            'P_CIUDAD' => 'a', // Añadido campo ciudad
        ];

        // Agregar registros al log para depuración
        Log::info('Datos recibidos para actualización: ', $datos);

        // URL de tu API externa para actualizar la reconciliación específica
        $urlAPI = "http://localhost:3000/sacramentos/{$id}";

        try {
            // Realizar la solicitud HTTP PUT a la API externa
            $response = Http::put($urlAPI, $datos);

            // Mostrar el cuerpo de la respuesta para depuración
            $responseBody = $response->body();
            if ($response->successful()) {
                return redirect()->back()->with('success', 'Registro de reconciliación actualizado correctamente.');
            } else {
                return redirect()->back()->with('error', 'Error al actualizar el registro de reconciliación. Detalles: ' . $responseBody);
            }
        } catch (\Exception $e) {
            // Manejar cualquier excepción que pueda surgir durante la llamada a la API
            return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
        }
    }



   // update de la tabla de Orden 


   public function updateOrden(Request $request, $id)
    {
        // Obtener el ID directamente desde el request
        $id = $request->input('editarCodigoOrden');

        // Verificar y registrar el ID recibido
        Log::info('ID recibido en updateReconciliacion: ' . $id);

        // Datos del formulario para actualizar la reconciliación
        $datos = [
            'P_NOM_SACRAMENTO' => 'ORDEN SACERDOTAL',
            'P_COD_PERSONAS' => $request->input('editarCodPersonas'),
            'P_FECHA' => $request->input('editarFechaOrdenacion'),
            'P_TIP_HIJO' => 'NATURAL',
            'P_COD_MADRE' => '0',
            'P_COD_PADRE' => '0',
            'P_PADRINOS' => 'a',
            'P_LIBRO_REG' => $request->input('editarLibroRegistro'),
            'P_COD_MONS' => '0',
            'P_COD_PARROCO' => $request->input('editarCodSacerdote'),
            'P_OBSERVACIONES' => $request->input('editarObservacionesOrden'),
            'P_COD_CONTRAYENTE_MUJER' => '0',
            'P_COD_CONTRAYENTE_HOMBRE' => '0',
            'P_FEC_BAUTIZO' => '2024-07-11',
            'P_NOM_TESTIGOS' => '0',
            'P_PAR_BAUTIZO' => 'a',
            'P_NOM_LUGAR' => $request->input('editarLugarSacramento'),
            'P_FOLIO_REG' => $request->input('editarFolioRegistro'),
            'P_NUMERO_REG' => $request->input('editarNumeroRegistro'),
            'P_CIUDAD' => 'a', // Añadido campo ciudad
        ];

        // Agregar registros al log para depuración
        Log::info('Datos recibidos para actualización: ', $datos);

        // URL de tu API externa para actualizar la reconciliación específica
        $urlAPI = "http://localhost:3000/sacramentos/{$id}";

        try {
            // Realizar la solicitud HTTP PUT a la API externa
            $response = Http::put($urlAPI, $datos);

            // Mostrar el cuerpo de la respuesta para depuración
            $responseBody = $response->body();
            if ($response->successful()) {
                return redirect()->back()->with('success', 'Registro de Ordenacion Sacerdotal actualizado correctamente.');
            } else {
                return redirect()->back()->with('error', 'Error al actualizar el registro de Ordenacion Sacerdotal. Detalles: ' . $responseBody);
            }
        } catch (\Exception $e) {
            // Manejar cualquier excepción que pueda surgir durante la llamada a la API
            return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
        }
    }




// update de la tabla de Unción Enfermos

    public function updateUncion(Request $request, $id)
    {
        // Obtener el ID directamente desde el request
        $id = $request->input('editarCodigoUncion');

        // Verificar y registrar el ID recibido
        Log::info('ID recibido en updateReconciliacion: ' . $id);

        // Datos del formulario para actualizar la reconciliación
        $datos = [
            'P_NOM_SACRAMENTO' => 'UNCION ENFERMOS',
            'P_COD_PERSONAS' => $request->input('editarCodPersona'),
            'P_FECHA' => $request->input('editarFechaUncion'),
            'P_TIP_HIJO' => 'NATURAL',
            'P_COD_MADRE' => '0',
            'P_COD_PADRE' => '0',
            'P_PADRINOS' => 'a',
            'P_LIBRO_REG' => $request->input('editarLibroRegistro'),
            'P_COD_MONS' => '0',
            'P_COD_PARROCO' => $request->input('editarCodSacerdote'),
            'P_OBSERVACIONES' => $request->input('editarObservacionesUncion'),
            'P_COD_CONTRAYENTE_MUJER' => '0',
            'P_COD_CONTRAYENTE_HOMBRE' => '0',
            'P_FEC_BAUTIZO' => '2024-07-11',
            'P_NOM_TESTIGOS' => '0',
            'P_PAR_BAUTIZO' => 'a',
            'P_NOM_LUGAR' => $request->input('editarLugarSacramento'),
            'P_FOLIO_REG' => $request->input('editarFolioRegistro'),
            'P_NUMERO_REG' => $request->input('editarNumeroRegistro'),
            'P_CIUDAD' => 'a', // Añadido campo ciudad
        ];

        // Agregar registros al log para depuración
        Log::info('Datos recibidos para actualización: ', $datos);

        // URL de tu API externa para actualizar la reconciliación específica
        $urlAPI = "http://localhost:3000/sacramentos/{$id}";

        try {
            // Realizar la solicitud HTTP PUT a la API externa
            $response = Http::put($urlAPI, $datos);

            // Mostrar el cuerpo de la respuesta para depuración
            $responseBody = $response->body();
            if ($response->successful()) {
                return redirect()->back()->with('success', 'Registro de Uncio Enfermos actualizado correctamente.');
            } else {
                return redirect()->back()->with('error', 'Error al actualizar el registro de Uncion Enfermos. Detalles: ' . $responseBody);
            }
        } catch (\Exception $e) {
            // Manejar cualquier excepción que pueda surgir durante la llamada a la API
            return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
        }
    }

// update de la tabla de Unción Enfermos

    public function updateBautizo(Request $request, $id)
    {
        // Obtener el ID directamente desde el request
        $id = $request->input('editarCodigoBautismo');

        // Verificar y registrar el ID recibido
        Log::info('ID recibido : ' . $id);

        // Datos del formulario para actualizar la reconciliación
        $datos = [
            'P_NOM_SACRAMENTO' => 'BAUTIZO',
            'P_COD_PERSONAS' => $request->input('editarCodPersona'),
            'P_FECHA' => $request->input('editarFechaBautismo'),
            'P_TIP_HIJO' => $request->input('editarTipHijo'),
            'P_COD_MADRE' => $request->input('editarCodMadre'),
            'P_COD_PADRE' => $request->input('editarCodPadre'),
            'P_PADRINOS' => $request->input('editarPadrinos'),
            'P_LIBRO_REG' => $request->input('editarLibroRegistro'),
            'P_COD_MONS' => '0',
            'P_COD_PARROCO' => $request->input('editarCodCelebrante'),
            'P_OBSERVACIONES' =>'a',
            'P_COD_CONTRAYENTE_MUJER' => '0',
            'P_COD_CONTRAYENTE_HOMBRE' => '0',
            'P_FEC_BAUTIZO' => '2024-07-11',
            'P_NOM_TESTIGOS' => '0',
            'P_PAR_BAUTIZO' => 'a',
            'P_NOM_LUGAR' =>'a',
            'P_FOLIO_REG' => $request->input('editarFolioRegistro'),
            'P_NUMERO_REG' => $request->input('editarNumeroRegistro'),
            'P_CIUDAD' => 'a', // Añadido campo ciudad
        ];

        // Agregar registros al log para depuración
        Log::info('Datos recibidos para actualización: ', $datos);

        // URL de tu API externa para actualizar la reconciliación específica
        $urlAPI = "http://localhost:3000/sacramentos/{$id}";

        try {
            // Realizar la solicitud HTTP PUT a la API externa
            $response = Http::put($urlAPI, $datos);

            // Mostrar el cuerpo de la respuesta para depuración
            $responseBody = $response->body();
            if ($response->successful()) {
                return redirect()->back()->with('success', 'Registro de Bautizo actualizado correctamente.');
            } else {
                return redirect()->back()->with('error', 'Error al actualizar el registro de bautizo. Detalles: ' . $responseBody);
            }
        } catch (\Exception $e) {
            // Manejar cualquier excepción que pueda surgir durante la llamada a la API
            return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
        }
    }


// update de la tabla de Confirmación

    public function updateConfirmacion(Request $request, $id)
    {
        // Obtener el ID directamente desde el request
        $id = $request->input('editarCodigoConfirmacion');

        // Verificar y registrar el ID recibido
        Log::info('ID recibido : ' . $id);

        // Datos del formulario para actualizar la reconciliación
        $datos = [
            'P_NOM_SACRAMENTO' => 'CONFIRMACION',
            'P_COD_PERSONAS' => $request->input('editarCodPersona'),
            'P_FECHA' => $request->input('editarFechaConfirmacion'),
            'P_TIP_HIJO' => 'NATURAL',
            'P_COD_MADRE' => $request->input('editarCodMadre'),
            'P_COD_PADRE' => $request->input('editarCodPadre'),
            'P_PADRINOS' => $request->input('editarPadrinos'),
            'P_LIBRO_REG' => $request->input('editarLibroRegistro'),
            'P_COD_MONS' => $request->input('editarCodMons'),
            'P_COD_PARROCO' => $request->input('editarCodParroco'),
            'P_OBSERVACIONES' =>$request->input('editarObservaciones'),
            'P_COD_CONTRAYENTE_MUJER' => '0',
            'P_COD_CONTRAYENTE_HOMBRE' => '0',
            'P_FEC_BAUTIZO' => $request->input('editarFechaBautizo'),
            'P_NOM_TESTIGOS' => '0',
            'P_PAR_BAUTIZO' => $request->input('editarParroquiaBautizo'),
            'P_NOM_LUGAR' =>'a',
            'P_FOLIO_REG' => $request->input('editarFolioRegistro'),
            'P_NUMERO_REG' => $request->input('editarNumeroRegistro'),
            'P_CIUDAD' => $request->input('editarCiudad'),
        ];

        // Agregar registros al log para depuración
        Log::info('Datos recibidos para actualización: ', $datos);

        // URL de tu API externa para actualizar la reconciliación específica
        $urlAPI = "http://localhost:3000/sacramentos/{$id}";

        try {
            // Realizar la solicitud HTTP PUT a la API externa
            $response = Http::put($urlAPI, $datos);

            // Mostrar el cuerpo de la respuesta para depuración
            $responseBody = $response->body();
            if ($response->successful()) {
                return redirect()->back()->with('success', 'Registro de Confirmación actualizado correctamente.');
            } else {
                return redirect()->back()->with('error', 'Error al actualizar el registro de Confirmación. Detalles: ' . $responseBody);
            }
        } catch (\Exception $e) {
            // Manejar cualquier excepción que pueda surgir durante la llamada a la API
            return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
        }
    }





// update de la tabla de Primera Comunión

    public function updateComunion(Request $request, $id)
    {
        // Obtener el ID directamente desde el request
        $id = $request->input('editarCodigoComunion');

        // Verificar y registrar el ID recibido
        Log::info('ID recibido : ' . $id);

        // Datos del formulario para actualizar la reconciliación
        $datos = [
            'P_NOM_SACRAMENTO' => 'PRIMERA COMUNION',
            'P_COD_PERSONAS' => $request->input('editarCodPersona'),
            'P_FECHA' => $request->input('editarFechaComunion'),
            'P_TIP_HIJO' => 'NATURAL',
            'P_COD_MADRE' => $request->input('editarCodMadre'),
            'P_COD_PADRE' => $request->input('editarCodPadre'),
            'P_PADRINOS' => 'a',
            'P_LIBRO_REG' => $request->input('editarLibroRegistro'),
            'P_COD_MONS' => '0',
            'P_COD_PARROCO' => $request->input('editarCodParroco'),
            'P_OBSERVACIONES' =>$request->input('editarObservaciones'),
            'P_COD_CONTRAYENTE_MUJER' => '0',
            'P_COD_CONTRAYENTE_HOMBRE' => '0',
            'P_FEC_BAUTIZO' => $request->input('editarfechabautizo'),
            'P_NOM_TESTIGOS' => '0',
            'P_PAR_BAUTIZO' => $request->input('editarParroquia'),
            'P_NOM_LUGAR' =>'a',
            'P_FOLIO_REG' => $request->input('editarFolioRegistro'),
            'P_NUMERO_REG' => $request->input('editarNumeroRegistro'),
            'P_CIUDAD' => 'a',
        ];

        // Agregar registros al log para depuración
        Log::info('Datos recibidos para actualización: ', $datos);

        // URL de tu API externa para actualizar la reconciliación específica
        $urlAPI = "http://localhost:3000/sacramentos/{$id}";

        try {
            // Realizar la solicitud HTTP PUT a la API externa
            $response = Http::put($urlAPI, $datos);

            // Mostrar el cuerpo de la respuesta para depuración
            $responseBody = $response->body();
            if ($response->successful()) {
                return redirect()->back()->with('success', 'Registro de Comunion actualizado correctamente.');
            } else {
                return redirect()->back()->with('error', 'Error al actualizar el registro de Comunion. Detalles: ' . $responseBody);
            }
        } catch (\Exception $e) {
            // Manejar cualquier excepción que pueda surgir durante la llamada a la API
            return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
        }
    }



// update de la tabla de Matrimonio


    public function updateMatrimonio(Request $request, $id)
    {
        // Obtener el ID directamente desde el request
        $id = $request->input('editarCodigoMatrimonio');

        // Verificar y registrar el ID recibido
        Log::info('ID recibido : ' . $id);

        // Datos del formulario para actualizar la reconciliación
        $datos = [
            'P_NOM_SACRAMENTO' => 'MATRIMONIO',
            'P_COD_PERSONAS' =>'0',
            'P_FECHA' => $request->input('editarFechaMatrimonio'),
            'P_TIP_HIJO' => 'NATURAL',
            'P_COD_MADRE' => '0',
            'P_COD_PADRE' =>'0',
            'P_PADRINOS' => 'a',
            'P_LIBRO_REG' => $request->input('editarLibroRegistro'),
            'P_COD_MONS' => '0',
            'P_COD_PARROCO' => $request->input('editarCodParroco'),
            'P_OBSERVACIONES' =>$request->input('editarObservaciones'),
            'P_COD_CONTRAYENTE_MUJER'=>$request->input('editarCodContrayenteMujer'),
            'P_COD_CONTRAYENTE_HOMBRE' =>$request->input('editarCodContrayenteHombre'),
            'P_FEC_BAUTIZO' => '2024-07-11',
            'P_NOM_TESTIGOS' => $request->input('editarNomTestigos'),
            'P_PAR_BAUTIZO' =>'a',
            'P_NOM_LUGAR' =>'a',
            'P_FOLIO_REG' => $request->input('editarFolioRegistro'),
            'P_NUMERO_REG' => $request->input('editarNumeroRegistro'),
            'P_CIUDAD' => 'a',
        ];

        // Agregar registros al log para depuración
        Log::info('Datos recibidos para actualización: ', $datos);

        // URL de tu API externa para actualizar la reconciliación específica
        $urlAPI = "http://localhost:3000/sacramentos/{$id}";

        try {
            // Realizar la solicitud HTTP PUT a la API externa
            $response = Http::put($urlAPI, $datos);

            // Mostrar el cuerpo de la respuesta para depuración
            $responseBody = $response->body();
            if ($response->successful()) {
                return redirect()->back()->with('success', 'Registro de Matrimonio actualizado correctamente.');
            } else {
                return redirect()->back()->with('error', 'Error al actualizar el registro de Matrimonio Detalles: ' . $responseBody);
            }
        } catch (\Exception $e) {
            // Manejar cualquier excepción que pueda surgir durante la llamada a la API
            return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
        }
    }













}// FINAL DEL cONTROLADOR 

















