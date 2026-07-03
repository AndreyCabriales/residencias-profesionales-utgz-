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

    public function edit(Alumno $alumno)
    {
        $alumno->load(['user', 'asignacion.asesor']);
        $asesores = Asesor::with('user')->get();
        return view('coordinador.alumnos.edit', compact('alumno', 'asesores'));
    }

    public function update(Request $request, Alumno $alumno)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                \Illuminate\Validation\Rule::unique('users')->ignore($alumno->user_id),
            ],
            'matricula' => [
                'required',
                'string',
                'max:20',
                \Illuminate\Validation\Rule::unique('alumnos')->ignore($alumno->id),
            ],
            'carrera' => 'nullable|string|max:255',
            'cuatrimestre' => 'nullable|string|max:50',
            'asesor_id' => [
                'nullable',
                'exists:asesores,id',
                function ($attribute, $value, $fail) {
                    $asesor = \App\Models\User::role('asesor')->whereHas('asesor', function($q) use ($value) {
                        $q->where('id', $value);
                    })->first();
                    
                    if ($value && !$asesor) {
                        $fail('El usuario seleccionado no tiene el rol de Asesor.');
                    }
                }
            ],
        ]);

        try {
            $this->usuarioService->actualizarAlumno($alumno, $request->all());
            return redirect()->route('coordinador.alumnos.index')
                ->with('success', 'Datos del alumno y asignación actualizados exitosamente.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }
}
