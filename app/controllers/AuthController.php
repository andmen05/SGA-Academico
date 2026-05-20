<?php

class AuthController
{
    public function login(): void
    {
        
        if (isset($_SESSION['user'])) {
            $dest = $_SESSION['user']['role'] === 'student'
                ? '/student/dashboard.php'
                : '/admin/dashboard.php';
            header("Location: $dest");
            exit;
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo   = trim($_POST['correo']   ?? '');
            $password = $_POST['password'] ?? '';

            
            $modelEst  = new Estudiante();
            $estudiante = $modelEst->findByCorreo($correo);

            if ($estudiante && password_verify($password, $estudiante['password'])) {
                $_SESSION['user'] = [
                    'role'     => 'student',
                    'id'       => (int) $estudiante['id_estudiante'],
                    'nombre'   => $estudiante['nombre'],
                    'apellido' => $estudiante['apellido'],
                    'correo'   => $estudiante['correo'],
                    'programa' => $estudiante['programa'],
                    'semestre' => $estudiante['semestre'],
                ];
                header('Location: /student/dashboard.php');
                exit;
            }

            
            $modelAdmin = new Administrador();
            $admin      = $modelAdmin->findByCorreo($correo);

            if ($admin && password_verify($password, $admin['password'])) {
                $_SESSION['user'] = [
                    'role'   => 'admin',
                    'id'     => (int) $admin['id_admin'],
                    'nombre' => $admin['nombre'],
                    'correo' => $admin['correo'],
                    'rol'    => $admin['rol'],
                ];
                header('Location: /admin/dashboard.php');
                exit;
            }

            $error = 'Correo o contraseña incorrectos.';
        }

        
        require __DIR__ . '/../views/auth/login.php';
    }

    public function logout(): void
    {
        session_destroy();
        header('Location: /');
        exit;
    }

    public function register(): void
    {
        
        if (isset($_SESSION['user'])) {
            header('Location: /student/dashboard.php');
            exit;
        }

        $errores = [];
        $post    = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = $_POST;

            $nombre   = trim($_POST['nombre']   ?? '');
            $apellido = trim($_POST['apellido']  ?? '');
            $doc      = trim($_POST['documento'] ?? '');
            $correo   = trim($_POST['correo']    ?? '');
            $tel      = trim($_POST['telefono']  ?? '');
            $programa = trim($_POST['programa']  ?? '');
            $semestre = intval($_POST['semestre'] ?? 0);
            $pass     = $_POST['password']         ?? '';
            $pass2    = $_POST['password_confirm'] ?? '';

            if (empty($nombre))                              $errores[] = 'El nombre es obligatorio.';
            if (empty($apellido))                            $errores[] = 'El apellido es obligatorio.';
            if (empty($doc))                                 $errores[] = 'El documento es obligatorio.';
            if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) $errores[] = 'Ingrese un correo válido.';
            if (empty($programa))                            $errores[] = 'El programa es obligatorio.';
            if ($semestre < 1 || $semestre > 12)             $errores[] = 'El semestre debe estar entre 1 y 12.';
            if (strlen($pass) < 6)                           $errores[] = 'La contraseña debe tener al menos 6 caracteres.';
            if ($pass !== $pass2)                            $errores[] = 'Las contraseñas no coinciden.';

            $model = new Estudiante();
            if (empty($errores) && $model->correoExiste($correo))      $errores[] = 'El correo ya está registrado.';
            if (empty($errores) && $model->documentoExiste($doc))       $errores[] = 'El documento ya está registrado.';

            if (empty($errores)) {
                $id = $model->create([
                    'nombre'   => $nombre,
                    'apellido' => $apellido,
                    'documento'=> $doc,
                    'correo'   => $correo,
                    'password' => $pass,
                    'telefono' => $tel,
                    'programa' => $programa,
                    'semestre' => $semestre,
                ]);

                
                $est = $model->findById($id);
                $_SESSION['user'] = [
                    'role'     => 'student',
                    'id'       => $id,
                    'nombre'   => $est['nombre'],
                    'apellido' => $est['apellido'],
                    'correo'   => $est['correo'],
                    'programa' => $est['programa'],
                    'semestre' => $est['semestre'],
                ];
                flash('success', '¡Bienvenido, ' . $nombre . '! Tu cuenta ha sido creada exitosamente.');
                header('Location: /student/dashboard.php');
                exit;
            }
        }

        require __DIR__ . '/../views/auth/register.php';
    }
}
