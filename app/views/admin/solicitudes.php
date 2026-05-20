<?php
$pageTitle = 'Solicitudes | SGA Admin';
$solicitudes   = $data['solicitudes'];
$tipos         = $data['tipos'];
$filtros       = $data['filtros'];
$flash_ok      = $data['flash_ok'];
$filtro_tipo   = (int) ($filtros['id_tipo_solicitud'] ?? 0);
$filtro_estado = $filtros['estado'] ?? '';
require_once __DIR__ . '/../layouts/sidebar_admin.php';
?>

<div class="page-header">
    <div class="breadcrumb">
        <a href="/admin/dashboard.php">Inicio</a><span>/</span><span style="color:#94a3b8">Solicitudes</span>
    </div>
    <h1 class="page-title">Gestión de Solicitudes</h1>
    <p class="page-sub">Revise y responda las solicitudes de los estudiantes</p>
</div>

<div class="content-body">

    <?php if ($flash_ok): ?>
        <div style="margin-bottom:20px;padding:12px 16px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;color:#15803d;font-size:.8125rem;display:flex;align-items:center;gap:8px">
            <span style="width:6px;height:6px;border-radius:50%;background:#16a34a;display:inline-block"></span>
            <?= htmlspecialchars($flash_ok) ?>
        </div>
    <?php endif; ?>

    
    <div class="card" style="margin-bottom:20px;overflow:visible">
        <div class="card-hdr"><h3>Filtros</h3></div>
        <div style="padding:18px 20px">
            <form method="GET" action="/admin/solicitudes.php" style="display:flex;flex-wrap:wrap;gap:14px;align-items:flex-end">
                <div style="display:flex;flex-direction:column;gap:5px;min-width:180px">
                    <label style="font-size:.65rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.09em">Tipo</label>
                    <select name="tipo" class="inp" style="min-width:180px">
                        <option value="">Todos los tipos</option>
                        <?php foreach ($tipos as $id => $nom): ?>
                            <option value="<?= $id ?>" <?= $filtro_tipo===$id?'selected':'' ?>><?= htmlspecialchars($nom) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div style="display:flex;flex-direction:column;gap:5px;min-width:150px">
                    <label style="font-size:.65rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.09em">Estado</label>
                    <select name="estado" class="inp" style="min-width:150px">
                        <option value="">Todos</option>
                        <?php foreach(['Pendiente','En revisión','Aprobada','Rechazada'] as $e): ?>
                            <option value="<?= $e ?>" <?= $filtro_estado===$e?'selected':'' ?>><?= $e ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div style="display:flex;gap:8px;align-items:flex-end">
                    <button type="submit" class="btn-p">Filtrar</button>
                    <a href="/admin/solicitudes.php" class="btn-g">Limpiar</a>
                </div>
            </form>
        </div>
    </div>

    
    <div class="card">
        <div class="card-hdr">
            <h3><?= count($solicitudes) ?> solicitud(es)</h3>
        </div>
        <?php if (empty($solicitudes)): ?>
            <div style="padding:60px;text-align:center;color:#94a3b8">No hay solicitudes con los filtros seleccionados.</div>
        <?php else: ?>
        <div style="overflow-x:auto">
            <table class="tbl w-full">
                <thead>
                    <tr>
                        <th style="text-align:left">Radicado</th>
                        <th style="text-align:left" class="hidden sm:table-cell">Fecha</th>
                        <th style="text-align:left">Estudiante</th>
                        <th style="text-align:left" class="hidden md:table-cell">Tipo</th>
                        <th style="text-align:left">Estado</th>
                        <th style="text-align:left">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($solicitudes as $s): ?>
                    <tr>
                        <td><span style="font-family:monospace;font-size:.72rem;color:#94a3b8;background:#f8fafc;padding:2px 6px;border-radius:5px">SOL-<?= str_pad($s['id_solicitud'],4,'0',STR_PAD_LEFT) ?></span></td>
                        <td class="hidden sm:table-cell" style="color:#94a3b8"><?= $s['fecha'] ?></td>
                        <td style="color:#1e293b;font-weight:500"><?= htmlspecialchars($s['est_nombre'].' '.$s['est_apellido']) ?></td>
                        <td class="hidden md:table-cell"><?= htmlspecialchars($s['tipo_nombre']) ?></td>
                        <td><?= badge($s['estado']) ?></td>
                        <td><a href="/admin/responder.php?id=<?= $s['id_solicitud'] ?>" style="font-size:.78rem;color:#b91c1c;font-weight:600">Ver / Responder →</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/sidebar_end.php'; ?>
