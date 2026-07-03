<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Contracts\DocumentoRepositoryInterface;
use App\Enums\DocumentoEstado;
use App\Models\Documento;
use Exception;

class DocumentoService
{
    public function __construct(
        protected DocumentoRepositoryInterface $documentoRepository
    ) {}

    /**
     * Sube un documento PDF al almacenamiento local y guarda el registro en la base de datos.
     * 
     * @param UploadedFile $archivo
     * @param int $alumnoId
     * @param int $etapaId
     * @return Documento
     * @throws Exception
     */
    public function subirDocumento(UploadedFile $archivo, int $alumnoId, int $etapaId): Documento
    {
        // 1. Generar nombre de archivo único para evitar sobreescrituras (Matricula_Etapa_Timestamp)
        $extension = $archivo->getClientOriginalExtension();
        $nombreArchivo = "alumno_{$alumnoId}_etapa_{$etapaId}_" . time() . ".{$extension}";

        // 2. Guardar en el disco 'local' de Laravel (storage/app/documentos)
        // Usamos storeAs para tener control del nombre exacto
        $rutaRelativa = $archivo->storeAs('documentos', $nombreArchivo, 'local');

        if (!$rutaRelativa) {
            throw new Exception("Error al guardar el archivo en el servidor.");
        }

        // 3. Registrar en base de datos usando el Repositorio
        return $this->documentoRepository->create([
            'alumno_id' => $alumnoId,
            'etapa_id' => $etapaId,
            'archivo' => $rutaRelativa, // En la BD de MySQL la columna se llama 'archivo' o 'ruta_archivo', verificaremos
            'estado' => DocumentoEstado::Pendiente,
        ]);
    }
}
