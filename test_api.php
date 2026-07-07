<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::create('/api/v1/asesorias', 'POST', [
    'alumno_id' => 1,
    'titulo' => 'test',
    'fecha_hora' => '2026-07-05 12:02:00',
    'duracion' => 120,
    'catalogo_modalidad_id' => 3,
    'descripcion' => 'test'
]);
$request->headers->set('Accept', 'application/json');
$request->headers->set('X-CSRF-TOKEN', csrf_token() ?? 'test'); // Fake CSRF is fine if we disable middleware for testing, or we just look at the response. Wait, CSRF might fail with 419.
$user = \App\Models\User::where('email', 'clopez@utgz.mx')->first();
auth()->login($user);
$response = $kernel->handle($request);
echo "STATUS: " . $response->getStatusCode() . "\n";
echo $response->getContent();
