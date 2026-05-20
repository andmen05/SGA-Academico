<?php





session_start();

require_once __DIR__ . '/database.php';


spl_autoload_register(function (string $class): void {
    $base = dirname(__DIR__);
    $paths = [
        $base . '/app/models/'      . $class . '.php',
        $base . '/app/controllers/' . $class . '.php',
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});



function requireLogin(string $role = null): void
{
    if (!isset($_SESSION['user'])) {
        header('Location: /');
        exit;
    }
    if ($role && $_SESSION['user']['role'] !== $role) {
        $dest = $_SESSION['user']['role'] === 'student'
            ? '/student/dashboard.php'
            : '/admin/dashboard.php';
        header("Location: $dest");
        exit;
    }
}

function flash(string $key, string $msg = null): ?string
{
    if ($msg !== null) {
        $_SESSION['flash'][$key] = $msg;
        return null;
    }
    $val = $_SESSION['flash'][$key] ?? null;
    unset($_SESSION['flash'][$key]);
    return $val;
}

function badge(string $estado): string
{
    return match ($estado) {
        'Pendiente'   => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pendiente</span>',
        'Aprobada'    => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aprobada</span>',
        'Rechazada'   => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Rechazada</span>',
        'En revisión' => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">En revisión</span>',
        default       => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">' . htmlspecialchars($estado) . '</span>',
    };
}

function e(string $val): string
{
    return htmlspecialchars($val, ENT_QUOTES, 'UTF-8');
}
