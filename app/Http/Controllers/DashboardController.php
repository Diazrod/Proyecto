<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Inicializar los contadores
        $data = [
            'feligreses_count' => 0,
            'empleados_count' => 0,
            'bautizos' => 0,
            'matrimonios' => 0,
            'comuniones' => 0,
            'confirmaciones' => 0,
            'ordenes' => 0,
            'unciones' => 0,
            'reconciliaciones' => 0,
            'comunidades_count' => 0,
            'becarios_count' => 0,
        ];

        try {
            // Llamar a la API del servidor para contar feligreses y empleados
            $responseFeligreses = Http::get('http://localhost:3000/Bpersonas/PERSONAS');
            if ($responseFeligreses->ok()) {
                $data['feligreses_count'] = count($responseFeligreses->json());
            }

            $responseEmpleados = Http::get('http://localhost:3000/Bpersonas/EMPLEADOS');
            if ($responseEmpleados->ok()) {
                $data['empleados_count'] = count($responseEmpleados->json());
            }

            // Contar sacramentos
            $data['bautizos'] = count(Http::get('http://localhost:3000/sacramentos1/BAUTIZO')->json());
            $data['matrimonios'] = count(Http::get('http://localhost:3000/sacramentos1/MATRIMONIO')->json());
            $data['comuniones'] = count(Http::get('http://localhost:3000/sacramentos1/PRIMERA%20COMUNION')->json());
            $data['confirmaciones'] = count(Http::get('http://localhost:3000/sacramentos1/CONFIRMACION')->json());
            $data['ordenes'] = count(Http::get('http://localhost:3000/sacramentos2/ORDEN%20SACERDOTAL')->json());
            $data['unciones'] = count(Http::get('http://localhost:3000/sacramentos2/UNCION%20ENFERMOS')->json());
            $data['reconciliaciones'] = count(Http::get('http://localhost:3000/sacramentos2/RECONCILIACION')->json());

            // Contar comunidades registradas
            $responseComunidades = Http::get('http://localhost:3000/Comunidad/REGISTRO_COMUNIDAD');
            if ($responseComunidades->ok()) {
                $data['comunidades_count'] = count($responseComunidades->json());
            }

            // Contar becarios registrados
            $responseBecas = Http::get('http://localhost:3000/becas');
            if ($responseBecas->ok()) {
                $data['becarios_count'] = count($responseBecas->json());
            }

        } catch (\Exception $e) {
            // Manejar la excepción si es necesario
            return redirect()->back()->with('error', 'Excepción capturada: ' . $e->getMessage());
        }

        // Pasar los contadores a la vista
        return view('home', compact('data'));
    }
}
