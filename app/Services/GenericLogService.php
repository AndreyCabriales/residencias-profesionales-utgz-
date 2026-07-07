<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class GenericLogService
{
    /**
     * Log an action for any polymorphic model.
     */
    public static function log(Model $model, string $accion, ?string $descripcion = null, ?array $metadata = null)
    {
        return $model->activityLogs()->create([
            "user_id" => auth()->id(),
            "accion" => $accion,
            "descripcion" => $descripcion,
            "ip_address" => Request::ip(),
            "user_agent" => Request::userAgent(),
            "metadata" => $metadata,
        ]);
    }
}

