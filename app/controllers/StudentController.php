<?php

class StudentController
{
    private Solicitud     $solicitudModel;
    private TipoSolicitud $tipoModel;
    private Respuesta     $respuestaModel;
    private Documento     $documentoModel;

    public function __construct()
    {
        $this->solicitudModel  = new Solicitud();
        $this->tipoModel       = new TipoSolicitud();
        $this->respuestaModel  = new Respuesta();
        $this->documentoModel  = new Documento();
    }

    
    public function dashboard(): void
    {
        requireLogin('student');

        $uid     = $_SESSION['user']['id'];
        $mis     = $this->solicitudModel->getByEstudiante($uid);
        $tipos   = $this->tipoModel->getAllIndexed();

        $total      = count($mis);
        $pendientes = count(array_filter($mis, fn($s) => $s['estado'] === 'Pendiente'));
        $aprobadas  = count(array_filter($mis, fn($s) => $s['estado'] === 'Aprobada'));
        $rechazadas = count(array_filter($mis, fn($s) => $s['estado'] === 'Rechazada'));
        $ultimas    = array_slice($mis, 0, 5);
        $flash_ok   = flash('success');

        $data = compact('mis', 'tipos', 'total', 'pendientes', 'aprobadas', 'rechazadas', 'ultimas', 'flash_ok');
        require __DIR__ . '/../views/student/dashboard.php';
    }

    
    public function misSolicitudes(): void
    {
        requireLogin('student');

        $uid      = $_SESSION['user']['id'];
        $mis      = $this->solicitudModel->getByEstudiante($uid);
        $tipos    = $this->tipoModel->getAllIndexed();
        $flash_ok = flash('success');

        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['responder'])) {
            $idSolicitud = intval($_GET['responder']);
            $mensaje = trim($_POST['mensaje_estudiante'] ?? '');

            
            $solicitud = $this->solicitudModel->findById($idSolicitud);
            if ($solicitud && (int)$solicitud['id_estudiante'] === (int)$uid) {
                
                if (!in_array($solicitud['estado'], ['Aprobada', 'Rechazada'])) {
                    if (!empty($mensaje)) {
                        $nombre_archivo = null;
                        $ruta = null;

                        
                        if (!empty($_FILES['archivo_estudiante']['name'])) {
                            $uploadDir = __DIR__ . '/../../uploads/solicitudes/';
                            if (!is_dir($uploadDir)) {
                                mkdir($uploadDir, 0755, true);
                            }
                            $ext            = pathinfo($_FILES['archivo_estudiante']['name'], PATHINFO_EXTENSION);
                            $nombre_archivo = 'sol_soporte_' . $idSolicitud . '_' . time() . '.' . $ext;
                            $ruta           = '/uploads/solicitudes/' . $nombre_archivo;
                            move_uploaded_file($_FILES['archivo_estudiante']['tmp_name'], $uploadDir . $nombre_archivo);

                            
                            $this->documentoModel->create([
                                'nombre_archivo' => $nombre_archivo,
                                'ruta'           => $ruta,
                                'tipo'           => $ext,
                                'id_solicitud'   => $idSolicitud,
                            ]);
                        }

                        
                        $mensajeModel = new Mensaje();
                        $mensajeModel->create([
                            'id_solicitud'     => $idSolicitud,
                            'remitente'        => 'estudiante',
                            'nombre_remitente' => $_SESSION['user']['nombre'] . ' ' . $_SESSION['user']['apellido'],
                            'mensaje'          => $mensaje,
                            'archivo_adjunto'  => $nombre_archivo,
                            'ruta_adjunto'     => $ruta,
                        ]);

                        
                        $this->solicitudModel->updateEstado($idSolicitud, 'Pendiente');

                        
                        $this->respuestaModel->deleteBySolicitud($idSolicitud);

                        flash('success', 'Respuesta enviada correctamente. El administrador ha sido notificado.');
                    } else {
                        flash('error', 'El mensaje de respuesta no puede estar vacío.');
                    }
                } else {
                    flash('error', 'No se puede responder a una solicitud finalizada.');
                }
            } else {
                flash('error', 'Solicitud no autorizada o no encontrada.');
            }
            header("Location: /student/mis-solicitudes.php?ver=" . $idSolicitud);
            exit;
        }

        
        $ver_id   = intval($_GET['ver'] ?? 0);
        $detalle  = null;
        $respuesta = null;
        $chat      = [];
        $documentos = [];

        if ($ver_id) {
            foreach ($mis as $s) {
                if ((int)$s['id_solicitud'] === $ver_id) {
                    $detalle = $s;
                    break;
                }
            }
            if ($detalle) {
                $respuesta = $this->respuestaModel->getBySolicitud($ver_id);
                
                
                $mensajeModel = new Mensaje();
                $chat = $mensajeModel->getBySolicitud($ver_id);

                
                $documentos = $this->documentoModel->getBySolicitud($ver_id);
            }
        }

        $data = compact('mis', 'tipos', 'flash_ok', 'detalle', 'respuesta', 'ver_id', 'chat', 'documentos');
        require __DIR__ . '/../views/student/mis-solicitudes.php';
    }

    
    public function nuevaSolicitud(): void
    {
        requireLogin('student');

        $uid   = $_SESSION['user']['id'];
        $tipos = $this->tipoModel->getAll();
        $errores = [];
        $post    = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = $_POST;
            $id_tipo     = intval($_POST['id_tipo_solicitud'] ?? 0);
            $descripcion = trim($_POST['descripcion'] ?? '');
            $prioridad   = trim($_POST['prioridad'] ?? 'Media');

            if (!$id_tipo)          $errores[] = 'Seleccione un tipo de solicitud.';
            if (empty($descripcion)) $errores[] = 'La descripción es obligatoria.';

            if (empty($errores)) {
                
                $idSolicitud = $this->solicitudModel->create([
                    'descripcion'       => $descripcion,
                    'prioridad'         => $prioridad,
                    'id_estudiante'     => $uid,
                    'id_tipo_solicitud' => $id_tipo,
                ]);

                
                if (!empty($_FILES['documento']['name'])) {
                    $uploadDir = __DIR__ . '/../../uploads/solicitudes/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    $ext            = pathinfo($_FILES['documento']['name'], PATHINFO_EXTENSION);
                    $nombre_archivo = 'sol_' . $idSolicitud . '_' . time() . '.' . $ext;
                    $ruta           = '/uploads/solicitudes/' . $nombre_archivo;
                    move_uploaded_file($_FILES['documento']['tmp_name'], $uploadDir . $nombre_archivo);

                    $this->documentoModel->create([
                        'nombre_archivo' => $nombre_archivo,
                        'ruta'           => $ruta,
                        'tipo'           => $ext,
                        'id_solicitud'   => $idSolicitud,
                    ]);
                }

                flash('success', 'Solicitud radicada correctamente. Radicado: SOL-' . str_pad($idSolicitud, 4, '0', STR_PAD_LEFT));
                header('Location: /student/mis-solicitudes.php');
                exit;
            }
        }

        $data = compact('tipos', 'errores', 'post');
        require __DIR__ . '/../views/student/nueva-solicitud.php';
    }
}
