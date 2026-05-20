<?php
$pageTitle = 'Panel Admin | SGA Académico';
require_once __DIR__ . '/../layouts/sidebar_admin.php';

$total      = $data['counts']['_total'];
$pendientes = $data['counts']['Pendiente']   ?? 0;
$en_revision= $data['counts']['En revisión'] ?? 0;
$aprobadas  = $data['counts']['Aprobada']    ?? 0;
$rechazadas = $data['counts']['Rechazada']   ?? 0;
$top5       = $data['top5'];
$recientes  = $data['recientes'];
$max_val    = max(array_column($top5, 'total') ?: [1]);
?>

<div class="page-header">
    <div class="breadcrumb"><span>Inicio</span></div>
    <h1 class="page-title">Panel de Administración</h1>
    <p class="page-sub">Resumen general del sistema de solicitudes académicas</p>
</div>

<div class="content-body">

    
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:16px;margin-bottom:24px">
        <div class="kpi kpi-total">
            <div class="kpi-label">Total</div>
            <div class="kpi-val" style="color:#0f172a"><?= $total ?></div>
        </div>
        <div class="kpi kpi-pend">
            <div class="kpi-label">Pendientes</div>
            <div class="kpi-val" style="color:#92400e"><?= $pendientes ?></div>
        </div>
        <div class="kpi kpi-rev">
            <div class="kpi-label">En Revisión</div>
            <div class="kpi-val" style="color:#1e3a5f"><?= $en_revision ?></div>
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

    
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px">

        <div class="card">
            <div class="card-hdr"><h3>Top 5 — Tipos de Solicitud</h3></div>
            <div style="padding:20px;display:flex;flex-direction:column;gap:14px">
                <?php foreach ($top5 as $row): ?>
                <div>
                    <div style="display:flex;justify-content:space-between;font-size:.78rem;color:#64748b;margin-bottom:6px">
                        <span><?= htmlspecialchars($row['nombre_tipo']) ?></span>
                        <span style="font-weight:700;color:#0f172a"><?= $row['total'] ?></span>
                    </div>
                    <div style="background:#f1f5f9;border-radius:99px;height:5px">
                        <div style="width:<?= round(($row['total']/$max_val)*100) ?>%;height:5px;border-radius:99px;background:linear-gradient(90deg,#b91c1c,#dc2626)"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="card">
            <div class="card-hdr"><h3>Distribución por Estado</h3></div>
            <div style="padding:20px;display:flex;flex-direction:column;gap:14px">
                <?php
                $estados=[['Pendientes',$pendientes,'#f59e0b'],['En Revisión',$en_revision,'#3b82f6'],['Aprobadas',$aprobadas,'#10b981'],['Rechazadas',$rechazadas,'#ef4444']];
                foreach($estados as $e):$pct=$total>0?round(($e[1]/$total)*100):0; ?>
                <div>
                    <div style="display:flex;justify-content:space-between;font-size:.78rem;color:#64748b;margin-bottom:6px">
                        <span><?= $e[0] ?></span>
                        <span style="font-weight:700;color:#0f172a"><?= $e[1] ?> — <?= $pct ?>%</span>
                    </div>
                    <div style="background:#f1f5f9;border-radius:99px;height:5px">
                        <div style="width:<?= $pct ?>%;height:5px;border-radius:99px;background:<?= $e[2] ?>"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    
    <div class="card">
        <div class="card-hdr">
            <h3>Solicitudes Pendientes Recientes</h3>
            <a href="/admin/solicitudes.php" style="font-size:.75rem;color:#b91c1c;font-weight:600">Ver todas →</a>
        </div>
        <div style="overflow-x:auto">
            <table class="tbl w-full">
                <thead>
                    <tr>
                        <th style="text-align:left">Radicado</th>
                        <th style="text-align:left">Estudiante</th>
                        <th style="text-align:left" class="hidden md:table-cell">Tipo</th>
                        <th style="text-align:left" class="hidden sm:table-cell">Fecha</th>
                        <th style="text-align:left">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recientes as $s): ?>
                    <tr>
                        <td><span style="font-family:monospace;font-size:.72rem;color:#94a3b8;background:#f8fafc;padding:2px 6px;border-radius:5px">SOL-<?= str_pad($s['id_solicitud'],4,'0',STR_PAD_LEFT) ?></span></td>
                        <td style="color:#1e293b;font-weight:500"><?= htmlspecialchars($s['est_nombre'].' '.$s['est_apellido']) ?></td>
                        <td class="hidden md:table-cell"><?= htmlspecialchars($s['tipo_nombre']) ?></td>
                        <td class="hidden sm:table-cell" style="color:#94a3b8"><?= $s['fecha'] ?></td>
                        <td>
                            <a href="/admin/responder.php?id=<?= $s['id_solicitud'] ?>" class="btn-p" style="padding:5px 14px;font-size:.72rem">Responder</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/sidebar_end.php'; ?>
