<?php

namespace App\Repositories\Contracts;

interface NotificacionRepositoryInterface
{
    /**
     * Obtiene las notificaciones de un usuario
     */
    public function getByUserId(int $userId);

    /**
     * Marca una notificación como leída
     */
    public function markAsRead(int $id): bool;
    
    /**
     * Obtiene la actividad reciente del sistema
     */
    public function getRecentActivity(int $limit = 5);
}
