<?php
$pageTitle = 'Inicio — Portal Estudiantil | SGA';
require_once __DIR__ . '/../layouts/sidebar_student.php';

$total      = $data['total'];
$pendientes = $data['pendientes'];
$aprobadas  = $data['aprobadas'];
$rechazadas = $data['rechazadas'];
$ultimas    = $data['ultimas'];
$flash_ok   = $data['flash_ok'];
?>

<div class="page-header">
    <div class="breadcrumb"><span>Inicio</span></div>
    <h1 class="page-title">Bienvenido, <?= htmlspecialchars($_SESSION['user']['nombre'].' '.$_SESSION['user']['apellido']) ?></h1>
    <p class="page-sub"><?= htmlspecialchars($_SESSION['user']['programa']) ?> — Semestre <?= $_SESSION['user']['semestre'] ?></p>
</div>

<div class="content-body">

    <?php if ($flash_ok): ?>
        <div style="margin-bottom:20px;padding:12px 16px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;color:#15803d;font-size:.8125rem;display:flex;align-items:center;gap:8px">
            <span style="width:6px;height:6px;border-radius:50%;background:#16a34a;display:inline-block"></span>
            <?= htmlspecialchars($flash_ok) ?>
        </div>
    <?php endif; ?>

    
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:16px;margin-bottom:24px">
        <div class="kpi kpi-total">
            <div class="kpi-label">Total Solicitudes</div>
            <div class="kpi-val" style="color:#0f172a"><?= $total ?></div>
        </div>
        <div class="kpi kpi-pend">
            <div class="kpi-label">Pendientes</div>
            <div class="kpi-val" style="color:#92400e"><?= $pendientes ?></div>
        </div>
        <div class="kpi kpi-apro">
            <div class="kpi-label">Aprobadas</div>
            <div class="kpi-val" style="color:#14532d"><?= $aprobadas ?></div>
        </div>
        <div class="kpi kpi-rech">
            <div class="kpi-label">Rechazadas</div>
            <div class="kpi-val" style="color:#7f1d1d"><?= $rechazadas ?></div>
        </div>
    </div>

    
    <div style="display:grid;grid-template-columns:280px 1fr;gap:18px">

        
        <div>
            <div class="card">
                <div class="card-hdr"><h3>Mis Datos</h3></div>
                <div style="padding:18px 20px;display:flex;flex-direction:column;gap:10px">
                    <div class="data-row"><span class="data-row-label">Nombre</span><span class="data-row-val"><?= htmlspecialchars($_SESSION['user']['nombre'].' '.$_SESSION['user']['apellido']) ?></span></div>
                    <div class="data-row"><span class="data-row-label">Correo</span><span class="data-row-val" style="font-size:.72rem"><?= htmlspecialchars($_SESSION['user']['correo']) ?></span></div>
                    <div class="data-row"><span class="data-row-label">Semestre</span><span class="data-row-val"><?= $_SESSION['user']['semestre'] ?></span></div>
                    <div style="border-top:1px solid #f1f5f9;padding-top:10px">
                        <p style="font-size:.65rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.09em;margin-bottom:4px">Programa</p>
                        <p style="font-size:.78rem;color:#1e293b;font-weight:500;line-height:1.5"><?= htmlspecialchars($_SESSION['user']['programa']) ?></p>
                    </div>
                </div>
                <div style="padding:14px 20px;border-top:1px solid #f1f5f9">
                    <a href="/student/nueva-solicitud.php" class="btn-p" style="display:block;text-align:center">+ Nueva Solicitud</a>
                </div>
            </div>
        </div>

        
        <div class="card">
            <div class="card-hdr">
                <h3>Últimas Solicitudes</h3>
                <a href="/student/mis-solicitudes.php" style="font-size:.75rem;color:#b91c1c;font-weight:600;text-decoration:none">Ver todas →</a>
            </div>
            <?php if(empty($ultimas)): ?>
                <div style="padding:60px;text-align:center;color:#94a3b8;font-size:.875rem">No tiene solicitudes registradas.</div>
            <?php else: ?>
            <div style="overflow-x:auto">
                <table class="tbl">
                    <thead><tr>
                        <th>Radicado</th>
                        <th class="hidden sm:table-cell">Tipo</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                    </tr></thead>
                    <tbody>
                        <?php foreach($ultimas as $s): ?>
                        <tr>
                            <td><span style="font-family:monospace;font-size:.72rem;color:#94a3b8;background:#f8fafc;padding:2px 6px;border-radius:5px">SOL-<?= str_pad($s['id_solicitud'],4,'0',STR_PAD_LEFT) ?></span></td>
                            <td class="hidden sm:table-cell"><?= htmlspecialchars($s['tipo_nombre']) ?></td>
                            <td style="color:#94a3b8"><?= $s['fecha'] ?></td>
                            <td><?= badge($s['estado']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/sidebar_end.php'; ?>
