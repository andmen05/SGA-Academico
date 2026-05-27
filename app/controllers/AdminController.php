<?php

class AdminController
{
    private Solicitud    $solicitudModel;
    private Estudiante   $estudianteModel;
    private Administrador $adminModel;
    private TipoSolicitud $tipoModel;
    private Respuesta    $respuestaModel;
    private Documento    $documentoModel;

    public function __construct()
    {
        $this->solicitudModel  = new Solicitud();
        $this->estudianteModel = new Estudiante();
        $this->adminModel      = new Administrador();
        $this->tipoModel       = new TipoSolicitud();
        $this->respuestaModel  = new Respuesta();
        $this->documentoModel  = new Documento();
    }

    
    public function dashboard(): void
    {
        requireLogin('admin');

        $counts   = $this->solicitudModel->countByEstado();
        $top5     = $this->solicitudModel->topTipos(5);
        $recientes = $this->solicitudModel->pendientesRecientes(6);

        $data = compact('counts', 'top5', 'recientes');
        require __DIR__ . '/../views/admin/dashboard.php';
    }

    
    public function solicitudes(): void
    {
        requireLogin('admin');

        $filtros = [
            'id_tipo_solicitud' => intval($_GET['tipo']   ?? 0) ?: null,
            'estado'            => $_GET['estado'] ?? null,
        ];
        
        $filtros = array_filter($filtros);

        $solicitudes = $this->solicitudModel->getAll($filtros);
        $tipos       = $this->tipoModel->getAllIndexed();
        $flash_ok    = flash('success');

        $data = compact('solicitudes', 'tipos', 'filtros', 'flash_ok');
        require __DIR__ . '/../views/admin/solicitudes.php';
    }

    
    public function responder(): void
    {
        requireLogin('admin');

        $id        = intval($_GET['id'] ?? 0);
        $solicitud = $this->solicitudModel->findById($id);

        if (!$solicitud) {
            flash('error', 'Solicitud no encontrada.');
            header('Location: /admin/solicitudes.php');
            exit;
        }

        $respuesta = $this->respuestaModel->getBySolicitud($id);
        $errores   = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$respuesta) {
            $observacion  = trim($_POST['observacion']  ?? '');
            $estado_final = $_POST['estado_final'] ?? '';

            if (empty($observacion)) {
                $errores[] = 'La observación es obligatoria.';
            }
            if (!in_array($estado_final, ['Aprobada', 'Rechazada', 'En revisión'])) {
                $errores[] = 'Seleccione un estado final válido.';
            }

            
            $nombre_archivo = null;
            $ruta_archivo   = null;
            if (!empty($_FILES['archivo_respuesta']['name'])) {
                $uploadDir = __DIR__ . '/../../uploads/respuestas/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                $ext            = pathinfo($_FILES['archivo_respuesta']['name'], PATHINFO_EXTENSION);
                $nombre_archivo = 'resp_' . $id . '_' . time() . '.' . $ext;
                $ruta_archivo   = '/uploads/respuestas/' . $nombre_archivo;
                move_uploaded_file($_FILES['archivo_respuesta']['tmp_name'], $uploadDir . $nombre_archivo);
            }

            if (empty($errores)) {
                $mensajeModel = new Mensaje();

                if ($estado_final === 'En revisión') {
                    
                    
                    $mensajeModel->create([
                        'id_solicitud'     => $id,
                        'remitente'        => 'admin',
                        'nombre_remitente' => $_SESSION['user']['nombre'] . ' (Administración)',
                        'mensaje'          => $observacion,
                        'archivo_adjunto'  => $nombre_archivo,
                        'ruta_adjunto'     => $ruta_archivo,
                    ]);

                    
                    $this->solicitudModel->updateEstado($id, $estado_final);

                    flash('success', 'Se ha solicitado información al estudiante para SOL-' . str_pad($id, 4, '0', STR_PAD_LEFT));
                } else {
                    
                    
                    $mensajeModel->create([
                        'id_solicitud'     => $id,
                        'remitente'        => 'admin',
                        'nombre_remitente' => $_SESSION['user']['nombre'] . ' (Administración)',
                        'mensaje'          => $observacion,
                        'archivo_adjunto'  => $nombre_archivo,
                        'ruta_adjunto'     => $ruta_archivo,
                    ]);

                    
                    $this->respuestaModel->create([
                        'observacion'           => $observacion,
                        'estado_final'          => $estado_final,
                        'archivo_respuesta'     => $nombre_archivo,
                        'ruta_archivo_respuesta'=> $ruta_archivo,
                        'id_solicitud'          => $id,
                        'id_admin'              => $_SESSION['user']['id'],
                    ]);

                    
                    $this->solicitudModel->updateEstado($id, $estado_final);

                    flash('success', 'Respuesta definitiva registrada para SOL-' . str_pad($id, 4, '0', STR_PAD_LEFT));
                }

                header('Location: /admin/solicitudes.php');
                exit;
            }
        }

        
        $mensajeModel = new Mensaje();
        $chat = $mensajeModel->getBySolicitud($id);

        $documentos = $this->documentoModel->getBySolicitud($id);

        $data = compact('solicitud', 'respuesta', 'errores', 'id', 'documentos', 'chat');
        require __DIR__ . '/../views/admin/responder.php';
    }

    
    public function estudiantes(): void
    {
        requireLogin('admin');

        $filtros = [
            'q'        => trim($_GET['q']        ?? ''),
            'programa' => trim($_GET['programa']  ?? ''),
            'semestre' => intval($_GET['semestre'] ?? 0) ?: null,
        ];
        $filtros = array_filter($filtros);

        $hayFiltros  = !empty($filtros);
        $estudiantes = $hayFiltros
            ? $this->estudianteModel->search($filtros)
            : $this->estudianteModel->getAll();

        $data = compact('estudiantes', 'filtros', 'hayFiltros');
        require __DIR__ . '/../views/admin/estudiantes.php';
    }

    
    public function administradores(): void
    {
        requireLogin('admin');

        $filtros = [
            'q'   => trim($_GET['q']   ?? ''),
            'rol' => trim($_GET['rol'] ?? ''),
        ];
        $filtros = array_filter($filtros);

        $hayFiltros = !empty($filtros);
        $admins     = $hayFiltros
            ? $this->adminModel->search($filtros)
            : $this->adminModel->getAll();

        $roles = $this->adminModel->getRoles();
        $data  = compact('admins', 'filtros', 'hayFiltros', 'roles');
        require __DIR__ . '/../views/admin/administradores.php';
    }

    
    public function reportes(): void
    {
        requireLogin('admin');

        $filtros = [
            'fecha_inicio'      => $_GET['fecha_inicio'] ?? '',
            'fecha_fin'         => $_GET['fecha_fin'] ?? '',
            'id_tipo_solicitud' => intval($_GET['tipo'] ?? 0) ?: null,
            'estado'            => $_GET['estado'] ?? '',
            'prioridad'         => $_GET['prioridad'] ?? '',
            'programa'          => $_GET['programa'] ?? '',
        ];
        
        
        $filtrosActivos = array_filter($filtros, function($val) {
            return $val !== '' && $val !== null;
        });

        
        $solicitudes = $this->solicitudModel->getReportData($filtrosActivos);

        
        if (($_GET['export'] ?? '') === 'csv') {
            $filename = 'Reporte_SGA_' . date('Ymd_His') . '.csv';
            
            
            header('Content-Type: text/csv; charset=UTF-8');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Pragma: no-cache');
            header('Expires: 0');

            
            $output = fopen('php://output', 'w');

            
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

            
            fputcsv($output, [
                'Radicado',
                'Fecha',
                'Estudiante',
                'Documento',
                'Correo',
                'Programa Académico',
                'Semestre',
                'Tipo de Solicitud',
                'Prioridad',
                'Estado',
                'Descripción',
                'Fecha de Respuesta',
                'Días Transcurridos',
                'Administrador que Respondió',
                'Observación de Respuesta'
            ], ';');

            
            foreach ($solicitudes as $s) {
                fputcsv($output, [
                    'SOL-' . str_pad($s['id_solicitud'], 4, '0', STR_PAD_LEFT),
                    $s['fecha'],
                    $s['est_nombre'] . ' ' . $s['est_apellido'],
                    $s['est_documento'],
                    $s['est_correo'],
                    $s['est_programa'],
                    $s['est_semestre'],
                    $s['tipo_nombre'],
                    $s['prioridad'],
                    $s['estado'],
                    strip_tags($s['descripcion']),
                    $s['fecha_respuesta'] ?? 'N/A',
                    $s['dias_respuesta'] !== null ? $s['dias_respuesta'] : 'N/A',
                    $s['admin_nombre'] ?? 'N/A',
                    $s['resp_observacion'] ? strip_tags($s['resp_observacion']) : 'N/A'
                ], ';');
            }

            fclose($output);
            exit;
        }

        
        $totalSolicitudes = count($solicitudes);
        $tiempoPromedio = $this->solicitudModel->getAverageResolutionTime($filtrosActivos);

        
        $porEstado = [
            'Pendiente' => 0,
            'En revisión' => 0,
            'Aprobada' => 0,
            'Rechazada' => 0
        ];
        
        $porPrioridad = [
            'Alta' => 0,
            'Media' => 0,
            'Baja' => 0
        ];
        
        $porTipo = [];
        
        $porPrograma = [];

        foreach ($solicitudes as $s) {
            if (isset($porEstado[$s['estado']])) {
                $porEstado[$s['estado']]++;
            }
            if (isset($porPrioridad[$s['prioridad']])) {
                $porPrioridad[$s['prioridad']]++;
            }
            
            $tipoName = $s['tipo_nombre'];
            $porTipo[$tipoName] = ($porTipo[$tipoName] ?? 0) + 1;

            $progName = $s['est_programa'] ?: 'No especificado';
            $porPrograma[$progName] = ($porPrograma[$progName] ?? 0) + 1;
        }

        
        arsort($porTipo);
        arsort($porPrograma);

        
        $resueltas = $porEstado['Aprobada'] + $porEstado['Rechazada'];
        $tasaResolucion = $totalSolicitudes > 0 ? round(($resueltas / $totalSolicitudes) * 100, 1) : 0;

        
        $tipos = $this->tipoModel->getAllIndexed();
        $programas = $this->solicitudModel->getDistinctPrograms();

        $data = compact(
            'solicitudes',
            'filtros',
            'totalSolicitudes',
            'tiempoPromedio',
            'tasaResolucion',
            'porEstado',
            'porPrioridad',
            'porTipo',
            'porPrograma',
            'tipos',
            'programas'
        );

        require __DIR__ . '/../views/admin/reportes.php';
    }

    /**
     * Permite al administrador crear una solicitud en nombre de cualquier estudiante
     */
    public function nuevaSolicitud(): void
    {
        requireLogin('admin');

        $estudiantes = $this->estudianteModel->getAll();
        $tipos       = $this->tipoModel->getAll();
        $errores     = [];
        $post        = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = $_POST;
            $id_estudiante     = intval($_POST['id_estudiante'] ?? 0);
            $id_tipo_solicitud = intval($_POST['id_tipo_solicitud'] ?? 0);
            $prioridad         = $_POST['prioridad'] ?? 'Media';
            $estado            = $_POST['estado'] ?? 'Pendiente';
            $fecha             = $_POST['fecha'] ?? date('Y-m-d');
            $descripcion       = trim($_POST['descripcion'] ?? '');

            if (!$id_estudiante)     $errores[] = 'Seleccione un estudiante.';
            if (!$id_tipo_solicitud) $errores[] = 'Seleccione un tipo de solicitud.';
            if (empty($descripcion))  $errores[] = 'La descripción es obligatoria.';

            if (empty($errores)) {
                $id = $this->solicitudModel->createByAdmin([
                    'id_estudiante'     => $id_estudiante,
                    'id_tipo_solicitud' => $id_tipo_solicitud,
                    'prioridad'         => $prioridad,
                    'estado'            => $estado,
                    'fecha'             => $fecha,
                    'descripcion'       => $descripcion,
                ]);

                // Subir documento de soporte opcional
                if (!empty($_FILES['documento']['name'])) {
                    $uploadDir = __DIR__ . '/../../uploads/solicitudes/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    $ext            = pathinfo($_FILES['documento']['name'], PATHINFO_EXTENSION);
                    $nombre_archivo = 'sol_' . $id . '_' . time() . '.' . $ext;
                    $ruta           = '/uploads/solicitudes/' . $nombre_archivo;
                    move_uploaded_file($_FILES['documento']['tmp_name'], $uploadDir . $nombre_archivo);

                    $this->documentoModel->create([
                        'nombre_archivo' => $nombre_archivo,
                        'ruta'           => $ruta,
                        'tipo'           => $ext,
                        'id_solicitud'   => $id,
                    ]);
                }

                flash('success', 'Nueva solicitud SOL-' . str_pad($id, 4, '0', STR_PAD_LEFT) . ' creada correctamente.');
                header('Location: /admin/solicitudes.php');
                exit;
            }
        }

        $data = compact('estudiantes', 'tipos', 'errores', 'post');
        require __DIR__ . '/../views/admin/nueva-solicitud.php';
    }

    /**
     * Permite al administrador editar cualquier campo de una solicitud (Llave Maestra)
     */
    public function editarSolicitud(): void
    {
        requireLogin('admin');

        $id = intval($_GET['id'] ?? 0);
        $solicitud = $this->solicitudModel->findById($id);

        if (!$solicitud) {
            flash('error', 'Solicitud no encontrada.');
            header('Location: /admin/solicitudes.php');
            exit;
        }

        $estudiantes = $this->estudianteModel->getAll();
        $tipos       = $this->tipoModel->getAll();
        $errores     = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_estudiante     = intval($_POST['id_estudiante'] ?? 0);
            $id_tipo_solicitud = intval($_POST['id_tipo_solicitud'] ?? 0);
            $prioridad         = $_POST['prioridad'] ?? 'Media';
            $estado            = $_POST['estado'] ?? 'Pendiente';
            $fecha             = $_POST['fecha'] ?? date('Y-m-d');
            $descripcion       = trim($_POST['descripcion'] ?? '');

            if (!$id_estudiante)     $errores[] = 'Seleccione un estudiante.';
            if (!$id_tipo_solicitud) $errores[] = 'Seleccione un tipo de solicitud.';
            if (empty($descripcion))  $errores[] = 'La descripción es obligatoria.';

            if (empty($errores)) {
                $this->solicitudModel->update($id, [
                    'id_estudiante'     => $id_estudiante,
                    'id_tipo_solicitud' => $id_tipo_solicitud,
                    'prioridad'         => $prioridad,
                    'estado'            => $estado,
                    'fecha'             => $fecha,
                    'descripcion'       => $descripcion,
                ]);

                // Subir soporte opcional si se seleccionó uno nuevo
                if (!empty($_FILES['documento']['name'])) {
                    $uploadDir = __DIR__ . '/../../uploads/solicitudes/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    $ext            = pathinfo($_FILES['documento']['name'], PATHINFO_EXTENSION);
                    $nombre_archivo = 'sol_' . $id . '_' . time() . '.' . $ext;
                    $ruta           = '/uploads/solicitudes/' . $nombre_archivo;
                    move_uploaded_file($_FILES['documento']['tmp_name'], $uploadDir . $nombre_archivo);

                    $this->documentoModel->create([
                        'nombre_archivo' => $nombre_archivo,
                        'ruta'           => $ruta,
                        'tipo'           => $ext,
                        'id_solicitud'   => $id,
                    ]);
                }

                flash('success', 'Solicitud SOL-' . str_pad($id, 4, '0', STR_PAD_LEFT) . ' actualizada correctamente.');
                header('Location: /admin/solicitudes.php');
                exit;
            }
        }

        $data = compact('solicitud', 'estudiantes', 'tipos', 'errores');
        require __DIR__ . '/../views/admin/editar-solicitud.php';
    }
}
