<?php

$migrationsDir = __DIR__ . '/database/migrations/';
$modelsDir = __DIR__ . '/app/Models/';

$migrations = scandir($migrationsDir);

$alumnoMig = '';
$asesorMig = '';
$asignacionMig = '';
$etapaMig = '';
$documentoMig = '';
$notificacionMig = '';
$usersMig = '';

foreach($migrations as $file) {
    if(strpos($file, 'create_alumnos_table') !== false) $alumnoMig = $migrationsDir . $file;
    if(strpos($file, 'create_asesores_table') !== false) $asesorMig = $migrationsDir . $file;
    if(strpos($file, 'create_asignaciones_table') !== false) $asignacionMig = $migrationsDir . $file;
    if(strpos($file, 'create_etapas_table') !== false) $etapaMig = $migrationsDir . $file;
    if(strpos($file, 'create_documentos_table') !== false) $documentoMig = $migrationsDir . $file;
    if(strpos($file, 'create_notificaciones_table') !== false) $notificacionMig = $migrationsDir . $file;
    if(strpos($file, 'create_users_table') !== false) $usersMig = $migrationsDir . $file;
}

// 1. User Migration
file_put_contents($usersMig, <<<EOT
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('users', function (Blueprint \$table) {
            \$table->id();
            \$table->string('name');
            \$table->string('email')->unique();
            \$table->timestamp('email_verified_at')->nullable();
            \$table->string('password');
            \$table->rememberToken();
            \$table->timestamps();
        });
        Schema::create('password_reset_tokens', function (Blueprint \$table) {
            \$table->string('email')->primary();
            \$table->string('token');
            \$table->timestamp('created_at')->nullable();
        });
        Schema::create('sessions', function (Blueprint \$table) {
            \$table->string('id')->primary();
            \$table->foreignId('user_id')->nullable()->index();
            \$table->string('ip_address', 45)->nullable();
            \$table->text('user_agent')->nullable();
            \$table->longText('payload');
            \$table->integer('last_activity')->index();
        });
    }
    public function down(): void {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
EOT
);

// 2. Etapas Migration
file_put_contents($etapaMig, <<<EOT
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('etapas', function (Blueprint \$table) {
            \$table->id();
            \$table->string('nombre');
            \$table->integer('orden');
            \$table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('etapas');
    }
};
EOT
);

// 3. Alumnos Migration
file_put_contents($alumnoMig, <<<EOT
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('alumnos', function (Blueprint \$table) {
            \$table->id();
            \$table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            \$table->string('matricula')->unique();
            \$table->foreignId('etapa_id')->nullable()->constrained('etapas')->nullOnDelete();
            \$table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('alumnos');
    }
};
EOT
);

// 4. Asesores Migration
file_put_contents($asesorMig, <<<EOT
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('asesores', function (Blueprint \$table) {
            \$table->id();
            \$table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            \$table->string('departamento')->nullable();
            \$table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('asesores');
    }
};
EOT
);

// 5. Asignaciones Migration
file_put_contents($asignacionMig, <<<EOT
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('asignaciones', function (Blueprint \$table) {
            \$table->id();
            \$table->foreignId('alumno_id')->constrained('alumnos')->onDelete('cascade');
            \$table->foreignId('asesor_id')->constrained('asesores')->onDelete('cascade');
            \$table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('asignaciones');
    }
};
EOT
);

// 6. Documentos Migration
file_put_contents($documentoMig, <<<EOT
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('documentos', function (Blueprint \$table) {
            \$table->id();
            \$table->foreignId('alumno_id')->constrained('alumnos')->onDelete('cascade');
            \$table->foreignId('etapa_id')->constrained('etapas')->onDelete('cascade');
            \$table->string('archivo');
            \$table->enum('estado', ['pendiente', 'en_revision', 'aprobado', 'rechazado'])->default('pendiente');
            \$table->text('retroalimentacion')->nullable();
            \$table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('documentos');
    }
};
EOT
);

// 7. Notificaciones Migration
file_put_contents($notificacionMig, <<<EOT
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('notificaciones', function (Blueprint \$table) {
            \$table->id();
            \$table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            \$table->string('titulo');
            \$table->text('mensaje');
            \$table->boolean('leida')->default(false);
            \$table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('notificaciones');
    }
};
EOT
);

// Models
file_put_contents($modelsDir . 'User.php', <<<EOT
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable {
    use HasFactory, Notifiable, HasRoles;
    protected \$fillable = ['name', 'email', 'password'];
    protected \$hidden = ['password', 'remember_token'];
    protected function casts(): array { return ['email_verified_at' => 'datetime', 'password' => 'hashed']; }
    
    public function alumno() { return \$this->hasOne(Alumno::class); }
    public function asesor() { return \$this->hasOne(Asesor::class); }
}
EOT
);

file_put_contents($modelsDir . 'Etapa.php', <<<EOT
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etapa extends Model {
    protected \$table = 'etapas';
    protected \$fillable = ['nombre', 'orden'];
}
EOT
);

file_put_contents($modelsDir . 'Alumno.php', <<<EOT
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model {
    protected \$table = 'alumnos';
    protected \$fillable = ['user_id', 'matricula', 'etapa_id'];
    public function user() { return \$this->belongsTo(User::class); }
    public function etapa() { return \$this->belongsTo(Etapa::class); }
    public function documentos() { return \$this->hasMany(Documento::class); }
    public function asignacion() { return \$this->hasOne(Asignacion::class); }
}
EOT
);

file_put_contents($modelsDir . 'Asesor.php', <<<EOT
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asesor extends Model {
    protected \$table = 'asesores';
    protected \$fillable = ['user_id', 'departamento'];
    public function user() { return \$this->belongsTo(User::class); }
    public function asignaciones() { return \$this->hasMany(Asignacion::class); }
}
EOT
);

file_put_contents($modelsDir . 'Asignacion.php', <<<EOT
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asignacion extends Model {
    protected \$table = 'asignaciones';
    protected \$fillable = ['alumno_id', 'asesor_id'];
    public function alumno() { return \$this->belongsTo(Alumno::class); }
    public function asesor() { return \$this->belongsTo(Asesor::class); }
}
EOT
);

file_put_contents($modelsDir . 'Documento.php', <<<EOT
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model {
    protected \$table = 'documentos';
    protected \$fillable = ['alumno_id', 'etapa_id', 'archivo', 'estado', 'retroalimentacion'];
    public function alumno() { return \$this->belongsTo(Alumno::class); }
    public function etapa() { return \$this->belongsTo(Etapa::class); }
}
EOT
);

file_put_contents($modelsDir . 'Notificacion.php', <<<EOT
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model {
    protected \$table = 'notificaciones';
    protected \$fillable = ['user_id', 'titulo', 'mensaje', 'leida'];
    public function user() { return \$this->belongsTo(User::class); }
}
EOT
);

echo "Migrations and Models configured successfully!\n";
