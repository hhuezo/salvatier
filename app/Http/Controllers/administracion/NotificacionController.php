<?php

namespace App\Http\Controllers\administracion;

use App\Http\Controllers\Controller;
use App\Models\administracion\Notificacion;
use Illuminate\Http\Request;

class NotificacionController extends Controller
{
    public function index()
    {
        // Obtener todas las notificaciones con la información del usuario
        $notificaciones = Notificacion::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('administracion.notificacion.index', compact('notificaciones'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }


    public function show(string $id)
    {
        try {
            $notificacion = Notificacion::with('user')->findOrFail($id);

            return view('administracion.notificacion.detalle', compact('notificacion'));


        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo obtener la notificación: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
