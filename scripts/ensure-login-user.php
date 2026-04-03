<?php

/**
 * Aktif .env veritabaninda kullanici olusturur / sifreyi gunceller.
 *
 * Kullanim (sifreyi terminalde verin, repoya yazmayin):
 *   php scripts/ensure-login-user.php ynsemrsngr@gmail.com "Sifreniz"
 *
 * Docker:
 *   docker compose exec app php scripts/ensure-login-user.php ynsemrsngr@gmail.com "Sifreniz"
 */

use App\Models\User;
use Illuminate\Contracts\Console\Kernel;

if ($argc < 3) {
    fwrite(STDERR, "Kullanim: php scripts/ensure-login-user.php <email> <sifre> [gorunen-ad]\n");
    exit(1);
}

$email = $argv[1];
$password = $argv[2];
$name = $argv[3] ?? strstr($email, '@', true) ?: 'Kullanici';

$base = dirname(__DIR__);
require $base.'/vendor/autoload.php';
$app = require $base.'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$user = User::query()->updateOrCreate(
    ['email' => $email],
    [
        'name' => $name,
        'password' => $password,
        'is_admin' => false,
        'email_verified_at' => now(),
    ]
);

echo "OK id={$user->id} email={$user->email}\n";
