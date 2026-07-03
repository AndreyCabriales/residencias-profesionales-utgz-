<?php

namespace App\Repositories;

use App\Models\Notificacion;
use App\Repositories\Contracts\NotificacionRepositoryInterface;

class NotificacionRepository implements NotificacionRepositoryInterface
{
    public function getByUserId(int $userId)
    {
        return Notificacion::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function markAsRead(int $id): bool
    {
        $notificacion = Notificacion::find($id);
        if ($notificacion) {
            $notificacion->leida = true;
            return $notificacion->save();
        }
        return false;
    }
    
    public function getRecentActivity(int $limit = 5)
    {
        return Notificacion::with('user')
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }
}
