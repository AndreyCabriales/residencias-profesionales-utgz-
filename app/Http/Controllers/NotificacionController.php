<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
    public function index()
    {
        $notificaciones = Notificacion::where('user_id', Auth::id())
            ->latest()
            ->paginate(15);
            
        return view('notificaciones.index', compact('notificaciones'));
    }

    public function leer(int $id)
    {
        $notificacion = Notificacion::where('user_id', Auth::id())->findOrFail($id);
        
        if (!$notificacion->leida) {
            $notificacion->update(['leida' => true]);
        }

        return redirect()->route('notificaciones.index');
    }

    public function leerTodas()
    {
        Notificacion::where('user_id', Auth::id())
            ->where('leida', false)
            ->update(['leida' => true]);

        return back()->with('success', 'Todas las notificaciones marcadas como leídas.');
    }
}
