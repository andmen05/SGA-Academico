<?php
$pageTitle = 'Mis Solicitudes | SGA Académico';
require_once __DIR__ . '/../layouts/sidebar_student.php';

$mis=$data['mis'];$flash_ok=$data['flash_ok'];$detalle=$data['detalle'];$respuesta=$data['respuesta'];
?>

<div class="page-header">
    <div class="breadcrumb"><a href="/student/dashboard.php">Inicio</a> <span>›</span> <span>Mis Solicitudes</span></div>
    <h1 class="page-title">Mis Solicitudes</h1>
    <p class="page-sub">Consulte el estado y respuestas de sus solicitudes académicas</p>
</div>

<div class="content-body">

<?php if($flash_ok): ?>
    <div style="margin-bottom:20px;padding:12px 16px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;color:#15803d;font-size:.8125rem;display:flex;align-items:center;gap:8px">
        <span style="width:6px;height:6px;border-radius:50%;background:#16a34a;display:inline-block"></span>
        <?= htmlspecialchars($flash_ok) ?>
    </div>
<?php endif; ?>

<div style="display:flex;justify-content:flex-end;margin-bottom:16px">
    <a href="/student/nueva-solicitud.php" class="btn-p" style="display:inline-flex;align-items:center;gap:6px">+ Nueva Solicitud</a>
</div>

<div class="card">
    <?php if(empty($mis)): ?>
        <div style="padding:60px;text-align:center">
            <p style="color:#94a3b8;margin-bottom:16px">No tiene solicitudes registradas.</p>
            <a href="/student/nueva-solicitud.php" class="btn-p">Realizar primera solicitud</a>
        </div>
    <?php else: ?>
    <div style="overflow-x:auto">
        <table class="tbl">
            <thead><tr>
                <th>Radicado</th>
                <th class="hidden md:table-cell">Tipo</th>
                <th class="hidden sm:table-cell">Fecha</th>
                <th>Estado</th>
                <th class="hidden lg:table-cell">Respuesta</th>
                <th>Detalle</th>
            </tr></thead>
            <tbody>
                <?php foreach($mis as $s): ?>
                <tr>
                    <td><span style="font-family:monospace;font-size:.72rem;color:#94a3b8;background:#f8fafc;padding:2px 6px;border-radius:5px">SOL-<?= str_pad($s['id_solicitud'],4,'0',STR_PAD_LEFT) ?></span></td>
                    <td class="hidden md:table-cell"><?= htmlspecialchars($s['tipo_nombre']) ?></td>
                    <td class="hidden sm:table-cell" style="color:#94a3b8"><?= $s['fecha'] ?></td>
                    <td><?= badge($s['estado']) ?></td>
                    <td class="hidden lg:table-cell"><?php if(in_array($s['estado'],['Aprobada','Rechazada'])): ?><span style="font-size:.75rem;color:#16a34a;font-weight:600">Disponible</span><?php else: ?><span style="font-size:.75rem;color:#94a3b8">Sin respuesta</span><?php endif; ?></td>
                    <td><a href="/student/mis-solicitudes.php?ver=<?= $s['id_solicitud'] ?>" class="link-d">Ver &rarr;</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>
</div>

<?php if($detalle): ?>
<div class="modal-ov">
    <div class="modal-box" style="max-width:600px; width:90%">
        <div class="modal-hdr">
            <div>
                <p style="font-size:.875rem;font-weight:700">SOL-<?= str_pad($detalle['id_solicitud'],4,'0',STR_PAD_LEFT) ?></p>
                <p style="font-size:.75rem;color:rgba(255,255,255,.6);margin-top:2px"><?= htmlspecialchars($detalle['tipo_nombre']) ?></p>
            </div>
            <a href="/student/mis-solicitudes.php" style="color:rgba(255,255,255,.6);font-size:24px;line-height:1;text-decoration:none">&times;</a>
        </div>
        <div class="modal-body" style="padding:16px 20px">
            
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:12px;padding-bottom:10px;border-bottom:1px solid #f1f5f9">
                <div><span class="fl">Fecha Radicación</span><span class="fv"><?= $detalle['fecha'] ?></span></div>
                <div><span class="fl">Estado Actual</span><div style="margin-top:2px"><?= badge($detalle['estado']) ?></div></div>
            </div>

            
            <?php if($respuesta): ?>
                <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:12px;margin-bottom:14px">
                    <p style="font-size:.65rem;font-weight:700;color:#16a34a;text-transform:uppercase;letter-spacing:.09em;margin-bottom:4px">Resolución Definitiva</p>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:8px">
                        <div><span class="fl" style="color:#16a34a">Estado Final</span><div style="margin-top:2px"><?= badge($respuesta['estado_final']) ?></div></div>
                        <div><span class="fl" style="color:#16a34a">Fecha Cierre</span><span class="fv" style="color:#1e293b"><?= $respuesta['fecha_respuesta'] ?></span></div>
                    </div>
                    <span class="fl" style="color:#16a34a">Observación Oficial</span>
                    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:8px 10px;font-size:.78rem;color:#1e293b;line-height:1.5;margin-top:4px">
                        <?= nl2br(htmlspecialchars($respuesta['observacion'])) ?>
                    </div>
                    <?php if($respuesta['archivo_respuesta']): ?>
                        <p style="font-size:.72rem;color:#475569;margin-top:8px">
                            <strong>Documento Adjunto:</strong> 
                            <a href="<?= htmlspecialchars($respuesta['ruta_archivo_respuesta']) ?>" target="_blank" download style="color:#b91c1c;font-weight:600;text-decoration:underline">
                                <?= htmlspecialchars($respuesta['archivo_respuesta']) ?>
                            </a>
                        </p>
                    <?php endif; ?>
                    <p style="font-size:.65rem;color:#64748b;margin-top:6px;text-align:right">Resuelto por: <?= htmlspecialchars($respuesta['admin_nombre']) ?></p>
                </div>
            <?php else: ?>
                <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:10px;padding:8px 12px;color:#1e40af;font-size:.75rem;margin-bottom:12px;display:flex;align-items:center;gap:6px">
                    <span style="width:6px;height:6px;border-radius:50%;background:#2563eb;display:inline-block"></span>
                    Esta solicitud está en revisión. Puedes enviar mensajes y adjuntar soportes abajo.
                </div>
            <?php endif; ?>

            
            <p style="font-size:.65rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.09em;margin-bottom:8px">Historial de Conversación</p>
            <div class="chat-container" style="display:flex;flex-direction:column;gap:12px;max-height:280px;overflow-y:auto;padding:12px;background:#f8fafc;border-radius:12px;border:1px solid #e2e8f0;margin-bottom:12px;scroll-behavior:smooth">
                
                
                <div class="chat-msg student-msg" style="align-self:flex-end;width:85%;display:flex;flex-direction:column;align-items:flex-end">
                    <span style="font-size:.65rem;color:#64748b;margin-bottom:2px">Tú (Inicio) • <?= $detalle['fecha'] ?></span>
                    <div style="background:#0284c7;color:#fff;border-radius:14px 14px 2px 14px;padding:8px 12px;font-size:.78rem;line-height:1.45;box-shadow:0 1px 2px rgba(0,0,0,0.05)">
                        <?= nl2br(htmlspecialchars($detalle['descripcion'])) ?>
                        
                        
                        <?php 
                        $initialDocs = array_filter($documentos, fn($d) => strpos($d['nombre_archivo'], 'sol_soporte_') === false);
                        if (!empty($initialDocs)): ?>
                            <div style="margin-top:6px;border-top:1px solid rgba(255,255,255,0.2);padding-top:4px;display:flex;flex-direction:column;gap:4px">
                                <?php foreach($initialDocs as $doc): ?>
                                    <a href="<?= htmlspecialchars($doc['ruta']) ?>" target="_blank" download style="color:#fff;text-decoration:underline;font-size:.7rem;display:flex;align-items:center;gap:4px">
                                        📎 <?= htmlspecialchars($doc['nombre_archivo']) ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                
                <?php foreach($chat as $msg): ?>
                    <?php if($msg['remitente'] === 'estudiante'): ?>
                        <div class="chat-msg student-msg" style="align-self:flex-end;width:85%;display:flex;flex-direction:column;align-items:flex-end">
                            <span style="font-size:.65rem;color:#64748b;margin-bottom:2px">Tú • <?= date('Y-m-d H:i', strtotime($msg['fecha_envio'])) ?></span>
                            <div style="background:#0284c7;color:#fff;border-radius:14px 14px 2px 14px;padding:8px 12px;font-size:.78rem;line-height:1.45;box-shadow:0 1px 2px rgba(0,0,0,0.05)">
                                <?= nl2br(htmlspecialchars($msg['mensaje'])) ?>
                                <?php if($msg['archivo_adjunto']): ?>
                                    <div style="margin-top:6px;border-top:1px solid rgba(255,255,255,0.2);padding-top:4px">
                                        <a href="<?= htmlspecialchars($msg['ruta_adjunto']) ?>" target="_blank" download style="color:#fff;text-decoration:underline;font-size:.7rem;display:flex;align-items:center;gap:4px">
                                            📎 <?= htmlspecialchars($msg['archivo_adjunto']) ?> (Soporte)
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="chat-msg admin-msg" style="align-self:flex-start;width:85%;display:flex;flex-direction:column;align-items:flex-start">
                            <span style="font-size:.65rem;color:#64748b;margin-bottom:2px"><?= htmlspecialchars($msg['nombre_remitente']) ?> • <?= date('Y-m-d H:i', strtotime($msg['fecha_envio'])) ?></span>
                            <div style="background:#f1f5f9;color:#1e293b;border-radius:14px 14px 14px 2px;padding:8px 12px;font-size:.78rem;line-height:1.45;border:1px solid #e2e8f0;box-shadow:0 1px 2px rgba(0,0,0,0.03)">
                                <?= nl2br(htmlspecialchars($msg['mensaje'])) ?>
                                <?php if($msg['archivo_adjunto']): ?>
                                    <div style="margin-top:6px;border-top:1px solid #cbd5e1;padding-top:4px">
                                        <a href="<?= htmlspecialchars($msg['ruta_adjunto']) ?>" target="_blank" download style="color:#b91c1c;text-decoration:underline;font-weight:600;font-size:.7rem;display:flex;align-items:center;gap:4px">
                                            📎 <?= htmlspecialchars($msg['archivo_adjunto']) ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            
            <?php if(!in_array($detalle['estado'], ['Aprobada', 'Rechazada'])): ?>
                <form method="POST" action="/student/mis-solicitudes.php?responder=<?= $detalle['id_solicitud'] ?>" enctype="multipart/form-data" style="display:flex;flex-direction:column;gap:8px;border-top:1px solid #f1f5f9;padding-top:10px;margin-top:8px">
                    <label style="font-size:.62rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.09em;display:block">Enviar Mensaje / Adjuntar Soporte de Pago</label>
                    <textarea name="mensaje_estudiante" rows="2" required placeholder="Escriba aquí su mensaje, justificación o respuesta..." style="width:100%;padding:8px 12px;border:1px solid #cbd5e1;border-radius:8px;font-size:.78rem;line-height:1.4;resize:none;outline:none;transition:border-color .15s" onfocus="this.style.borderColor='#0284c7'" onblur="this.style.borderColor='#cbd5e1'"></textarea>
                    
                    <div style="display:flex;align-items:center;justify-content:space-between">
                        <div style="display:flex;align-items:center;gap:6px">
                            <label for="archivo_estudiante" style="padding:4px 8px;background:#f8fafc;border:1px solid #cbd5e1;border-radius:6px;color:#475569;font-size:.68rem;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:3px;transition:background .15s" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#f8fafc'">
                                📎 Adjuntar Archivo
                            </label>
                            <input id="archivo_estudiante" name="archivo_estudiante" type="file" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" style="display:none" onchange="document.getElementById('file-chosen').textContent = this.files[0] ? this.files[0].name : 'Ningún archivo'">
                            <span id="file-chosen" style="font-size:.65rem;color:#94a3b8;max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">Ningún archivo</span>
                        </div>
                        <button type="submit" class="btn-p" style="padding:5px 12px;font-size:.72rem;border-radius:6px">Enviar Respuesta</button>
                    </div>
                </form>
            <?php endif; ?>

            <div style="border-top:1px solid #f1f5f9;margin-top:10px;padding-top:8px;display:flex;justify-content:flex-end">
                <a href="/student/mis-solicitudes.php" class="btn-g" style="padding:5px 12px;font-size:.72rem;border-radius:6px">Cerrar</a>
            </div>
        </div>
    </div>
</div>

<script>
    setTimeout(function() {
        var container = document.querySelector('.chat-container');
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    }, 120);
</script>
<?php endif; ?>

<?php require_once __DIR__ . '/../layouts/sidebar_end.php'; ?>