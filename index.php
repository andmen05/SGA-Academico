<?php





require_once __DIR__ . '/config/app.php';

$uri = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');


if ($uri === '' || $uri === '/index.php') {
    (new AuthController())->login();
    exit;
}

if ($uri === '/register.php') {
    (new AuthController())->register();
    exit;
}

if ($uri === '/logout.php') {
    (new AuthController())->logout();
    exit;
}


if ($uri === '/admin/dashboard.php') {
    (new AdminController())->dashboard();
    exit;
}
if ($uri === '/admin/solicitudes.php') {
    (new AdminController())->solicitudes();
    exit;
}
if ($uri === '/admin/nueva-solicitud.php') {
    (new AdminController())->nuevaSolicitud();
    exit;
}
if ($uri === '/admin/editar-solicitud.php') {
    (new AdminController())->editarSolicitud();
    exit;
}
if ($uri === '/admin/responder.php') {
    (new AdminController())->responder();
    exit;
}
if ($uri === '/admin/estudiantes.php') {
    (new AdminController())->estudiantes();
    exit;
}
if ($uri === '/admin/administradores.php') {
    (new AdminController())->administradores();
    exit;
}
if ($uri === '/admin/reportes.php') {
    (new AdminController())->reportes();
    exit;
}


if ($uri === '/student/dashboard.php') {
    (new StudentController())->dashboard();
    exit;
}
if ($uri === '/student/mis-solicitudes.php') {
    (new StudentController())->misSolicitudes();
    exit;
}
if ($uri === '/student/nueva-solicitud.php') {
    (new StudentController())->nuevaSolicitud();
    exit;
}


http_response_code(404);
echo '<h1 style="font-family:sans-serif">404 — Página no encontrada</h1>';
echo '<p><a href="/">Volver al inicio</a></p>';
