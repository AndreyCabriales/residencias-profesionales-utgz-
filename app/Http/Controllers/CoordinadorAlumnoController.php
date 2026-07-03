<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Asesor;
use App\Services\UsuarioService;
use Illuminate\Http\Request;

class CoordinadorAlumnoController extends Controller
{
    public function __construct(
        protected UsuarioService $usuarioService
    ) {}

    public function index()
    {
        // Eager loading para evitar N+1 queries
        $alumnos = Alumno::with(['user', 'etapa', 'asignacion.asesor.user'])->paginate(10);
        return view('coordinador.alumnos.index', compact('alumnos'));
    }

    public function create()
    {
        $asesores = Asesor::with('user')->get();
        return view('coordinador.alumnos.create', compact('asesores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'matricula' => 'required|string|max:20|unique:alumnos',
            'carrera' => 'nullable|string|max:255',
            'cuatrimestre' => 'nullable|string|max:50',
            'asesor_id' => 'nullable|exists:asesores,id',
        ]);

        try {
            $this->usuarioService->crearAlumno($request->all());
            return redirect()->route('coordinador.alumnos.index')
                ->with('success', 'Alumno registrado y asignado exitosamente.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error al registrar: ' . $e->getMessage());
        }
    }
}
