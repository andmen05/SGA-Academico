<?php
$pageTitle = 'Crear Solicitud | SGA Admin';
$estudiantes = $data['estudiantes'];
$tipos       = $data['tipos'];
$errores     = $data['errores'];
$post        = $data['post'];
require_once __DIR__ . '/../layouts/sidebar_admin.php';
?>

<div class="page-header">
    <div class="breadcrumb">
        <a href="/admin/dashboard.php">Inicio</a><span>/</span>
        <a href="/admin/solicitudes.php">Solicitudes</a><span>/</span>
        <span style="color:#94a3b8">Nueva Solicitud</span>
    </div>
    <h1 class="page-title">Nueva Solicitud (Llave Maestra)</h1>
    <p class="page-sub">Radique una nueva solicitud en nombre de cualquier estudiante registrado</p>
</div>

<div class="content-body" style="max-width:800px">

    <?php if(!empty($errores)): ?>
        <div style="margin-bottom:20px;padding:14px 18px;background:#fef2f2;border:1px solid #fecaca;border-radius:12px;color:#b91c1c;font-size:.8125rem">
            <?php foreach($errores as $e): ?><p>— <?= htmlspecialchars($e) ?></p><?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-hdr">
            <h3>Formulario de Radicación Directa</h3>
        </div>
        <div style="padding:24px 30px">
            <form method="POST" action="/admin/nueva-solicitud.php" enctype="multipart/form-data" style="display:flex;flex-direction:column;gap:20px">
                
                <!-- Estudiante Selector -->
                <div>
                    <label style="font-size:.65rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.09em;display:block;margin-bottom:6px">Estudiante Beneficiario <span style="color:#b91c1c">*</span></label>
                    <select name="id_estudiante" required class="inp" style="padding:10px 14px;font-size:.85rem">
                        <option value="">— Seleccione el estudiante —</option>
                        <?php foreach ($estudiantes as $est): ?>
                            <option value="<?= $est['id_estudiante'] ?>" <?= ($post['id_estudiante'] ?? '') == $est['id_estudiante'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($est['apellido'] . ', ' . $est['nombre']) ?> (Doc: <?= htmlspecialchars($est['documento']) ?> — Sem: <?= $est['semestre'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:18px">
                    <!-- Tipo de Solicitud -->
                    <div>
                        <label style="font-size:.65rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.09em;display:block;margin-bottom:6px">Tipo de Trámite <span style="color:#b91c1c">*</span></label>
                        <select name="id_tipo_solicitud" required class="inp" style="padding:10px 14px;font-size:.85rem">
                            <option value="">— Seleccione tipo —</option>
                            <?php foreach ($tipos as $t): ?>
                                <option value="<?= $t['id_tipo_solicitud'] ?>" <?= ($post['id_tipo_solicitud'] ?? '') == $t['id_tipo_solicitud'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($t['nombre_tipo']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Prioridad -->
                    <div>
                        <label style="font-size:.65rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.09em;display:block;margin-bottom:6px">Prioridad <span style="color:#b91c1c">*</span></label>
                        <select name="prioridad" required class="inp" style="padding:10px 14px;font-size:.85rem">
                            <option value="Baja" <?= ($post['prioridad'] ?? '') === 'Baja' ? 'selected' : '' ?>>Baja (SLA: 10 días)</option>
                            <option value="Media" <?= ($post['prioridad'] ?? 'Media') === 'Media' ? 'selected' : '' ?>>Media (SLA: 5 días)</option>
                            <option value="Alta" <?= ($post['prioridad'] ?? '') === 'Alta' ? 'selected' : '' ?>>Alta (SLA: 3 días)</option>
                        </select>
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:18px">
                    <!-- Estado Inicial -->
                    <div>
                        <label style="font-size:.65rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.09em;display:block;margin-bottom:6px">Estado Inicial <span style="color:#b91c1c">*</span></label>
                        <select name="estado" required class="inp" style="padding:10px 14px;font-size:.85rem">
                            <option value="Pendiente" <?= ($post['estado'] ?? 'Pendiente') === 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
                            <option value="En revisión" <?= ($post['estado'] ?? '') === 'En revisión' ? 'selected' : '' ?>>En revisión</option>
                            <option value="Aprobada" <?= ($post['estado'] ?? '') === 'Aprobada' ? 'selected' : '' ?>>Aprobada (Cerrada)</option>
                            <option value="Rechazada" <?= ($post['estado'] ?? '') === 'Rechazada' ? 'selected' : '' ?>>Rechazada (Cerrada)</option>
                        </select>
                    </div>

                    <!-- Fecha de Radicación -->
                    <div>
                        <label style="font-size:.65rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.09em;display:block;margin-bottom:6px">Fecha de Radicación <span style="color:#b91c1c">*</span></label>
                        <input type="date" name="fecha" required class="inp" style="padding:9px 14px;font-size:.85rem" value="<?= htmlspecialchars($post['fecha'] ?? date('Y-m-d')) ?>">
                    </div>
                </div>

                <!-- Descripción -->
                <div>
                    <label style="font-size:.65rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.09em;display:block;margin-bottom:6px">Descripción de la Solicitud / Justificación <span style="color:#b91c1c">*</span></label>
                    <textarea name="descripcion" rows="6" required placeholder="Escriba detalladamente el motivo o justificación de la solicitud académica..." class="inp" style="resize:vertical;padding:12px 14px;font-size:.85rem;line-height:1.5"><?= htmlspecialchars($post['descripcion'] ?? '') ?></textarea>
                </div>

                <!-- Documento Soporte -->
                <div>
                    <label style="font-size:.65rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.09em;display:block;margin-bottom:6px">Adjuntar Documento Soporte <span style="font-weight:400;text-transform:none;letter-spacing:0;color:#94a3b8">(opcional, PDF o imágenes)</span></label>
                    <input type="file" name="documento" accept=".pdf,.png,.jpg,.jpeg,.doc,.docx" class="inp" style="padding:7px 14px;font-size:.8rem;color:#64748b;cursor:pointer">
                </div>

                <!-- Botones -->
                <div style="display:flex;gap:12px;padding-top:16px;border-top:1px solid #f1f5f9;margin-top:10px">
                    <button type="submit" class="btn-p" style="padding:10px 24px;font-size:.85rem;border-radius:8px">Radicar Solicitud</button>
                    <a href="/admin/solicitudes.php" class="btn-g" style="padding:10px 24px;font-size:.85rem;border-radius:8px">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/../layouts/sidebar_end.php'; ?>
