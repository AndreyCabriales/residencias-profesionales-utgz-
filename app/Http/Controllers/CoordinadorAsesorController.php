<?php

namespace App\Http\Controllers;

use App\Models\Asesor;
use App\Services\UsuarioService;
use Illuminate\Http\Request;

class CoordinadorAsesorController extends Controller
{
    public function __construct(
        protected UsuarioService $usuarioService
    ) {}

    public function index()
    {
        // Traemos asesores con sus usuarios y contamos cuántos alumnos tienen asignados
        $asesores = Asesor::with('user')->withCount('asignaciones')->paginate(10);
        return view('coordinador.asesores.index', compact('asesores'));
    }

    public function create()
    {
        return view('coordinador.asesores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'departamento' => 'nullable|string|max:255',
        ]);

        try {
            $this->usuarioService->crearAsesor($request->all());
            return redirect()->route('coordinador.asesores.index')
                ->with('success', 'Asesor registrado exitosamente.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error al registrar: ' . $e->getMessage());
        }
    }
}
