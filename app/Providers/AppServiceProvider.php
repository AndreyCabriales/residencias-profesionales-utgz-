<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\DocumentoRepositoryInterface;
use App\Repositories\DocumentoRepository;
use App\Repositories\Contracts\AlumnoRepositoryInterface;
use App\Repositories\AlumnoRepository;
use App\Repositories\Contracts\NotificacionRepositoryInterface;
use App\Repositories\NotificacionRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DocumentoRepositoryInterface::class, DocumentoRepository::class);
        $this->app->bind(AlumnoRepositoryInterface::class, AlumnoRepository::class);
        $this->app->bind(NotificacionRepositoryInterface::class, NotificacionRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\Gate::policy(\App\Models\Documento::class, \App\Policies\DocumentoPolicy::class);

        if (app()->environment('production')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        \Illuminate\Auth\Notifications\ResetPassword::toMailUsing(function ($notifiable, $token) {
            return (new \Illuminate\Notifications\Messages\MailMessage)
                ->subject('Solicitud para restablecer tu contraseña')
                ->greeting('¡Hola!')
                ->line('Estás recibiendo este correo porque recibimos una solicitud de restablecimiento de contraseña para tu cuenta.')
                ->action('Restablecer Contraseña', url(config('app.url').route('password.reset', ['token' => $token, 'email' => $notifiable->getEmailForPasswordReset()], false)))
                ->line('Este enlace para restablecer la contraseña caducará en 60 minutos.')
                ->line('Si no has solicitado un restablecimiento de contraseña, no es necesario realizar ninguna acción.')
                ->salutation('Saludos, '.config('app.name'));
        });
    }
}
