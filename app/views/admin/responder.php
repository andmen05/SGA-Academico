<?php
$pageTitle = 'Responder Solicitud | SGA Admin';
$solicitud  = $data['solicitud'];
$respuesta  = $data['respuesta'];
$errores    = $data['errores'];
$id         = $data['id'];
$documentos = $data['documentos'] ?? [];
require_once __DIR__ . '/../layouts/sidebar_admin.php';
?>

<div class="page-header">
    <div class="breadcrumb">
        <a href="/admin/dashboard.php">Inicio</a><span>/</span>
        <a href="/admin/solicitudes.php">Solicitudes</a><span>/</span>
        <span style="color:#94a3b8">SOL-<?= str_pad($id,4,'0',STR_PAD_LEFT) ?></span>
    </div>
    <div style="display:flex;align-items:center;gap:14px">
        <a href="/admin/solicitudes.php" style="padding:7px 14px;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.1);border-radius:9px;color:#94a3b8;font-size:.78rem;font-weight:500;text-decoration:none;transition:background .15s" onmouseover="this.style.background='rgba(255,255,255,.12)'" onmouseout="this.style.background='rgba(255,255,255,.07)'">← Volver</a>
        <div>
            <h1 class="page-title">Solicitud SOL-<?= str_pad($id,4,'0',STR_PAD_LEFT) ?></h1>
            <p class="page-sub"><?= htmlspecialchars($solicitud['tipo_nombre']) ?></p>
        </div>
        <div style="margin-left:4px"><?= badge($solicitud['estado']) ?></div>
    </div>
</div>

<div class="content-body">

    <?php if(!empty($errores)): ?>
        <div style="margin-bottom:20px;padding:14px 18px;background:#fef2f2;border:1px solid #fecaca;border-radius:12px;color:#b91c1c;font-size:.8125rem">
            <?php foreach($errores as $e): ?><p>— <?= htmlspecialchars($e) ?></p><?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div style="display:grid;grid-template-columns:1.2fr 1fr;gap:18px">

        
        <div style="display:flex;flex-direction:column;gap:16px">
            
            <div class="card">
                <div class="card-hdr"><h3>Historial de Conversación (Chat con Estudiante)</h3></div>
                <div style="padding:16px 20px">
                    <div class="chat-container" style="display:flex;flex-direction:column;gap:12px;max-height:480px;overflow-y:auto;padding:12px;background:#f8fafc;border-radius:12px;border:1px solid #e2e8f0;margin-bottom:12px;scroll-behavior:smooth">
                        
                        
                        <div class="chat-msg student-msg" style="align-self:flex-start;width:85%;display:flex;flex-direction:column;align-items:flex-start">
                            <span style="font-size:.65rem;color:#64748b;margin-bottom:2px">Estudiante (Inicio) • <?= $solicitud['fecha'] ?></span>
                            <div style="background:#f1f5f9;color:#1e293b;border-radius:14px 14px 14px 2px;padding:8px 12px;font-size:.78rem;line-height:1.45;border:1px solid #e2e8f0;box-shadow:0 1px 2px rgba(0,0,0,0.03)">
                                <?= nl2br(htmlspecialchars($solicitud['descripcion'])) ?>
                                
                                
                                <?php 
                                $initialDocs = array_filter($documentos, fn($d) => strpos($d['nombre_archivo'], 'sol_soporte_') === false);
                                if (!empty($initialDocs)): ?>
                                    <div style="margin-top:6px;border-top:1px solid #cbd5e1;padding-top:4px;display:flex;flex-direction:column;gap:4px">
                                        <?php foreach($initialDocs as $doc): ?>
                                            <a href="<?= htmlspecialchars($doc['ruta']) ?>" target="_blank" download style="color:#b91c1c;text-decoration:underline;font-weight:600;font-size:.7rem;display:flex;align-items:center;gap:4px">
                                                📎 <?= htmlspecialchars($doc['nombre_archivo']) ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        
                        <?php foreach($chat as $msg): ?>
                            <?php if($msg['remitente'] === 'estudiante'): ?>
                                <div class="chat-msg student-msg" style="align-self:flex-start;width:85%;display:flex;flex-direction:column;align-items:flex-start">
                                    <span style="font-size:.65rem;color:#64748b;margin-bottom:2px">Estudiante • <?= date('Y-m-d H:i', strtotime($msg['fecha_envio'])) ?></span>
                                    <div style="background:#f1f5f9;color:#1e293b;border-radius:14px 14px 14px 2px;padding:8px 12px;font-size:.78rem;line-height:1.45;border:1px solid #e2e8f0;box-shadow:0 1px 2px rgba(0,0,0,0.03)">
                                        <?= nl2br(htmlspecialchars($msg['mensaje'])) ?>
                                        <?php if($msg['archivo_adjunto']): ?>
                                            <div style="margin-top:6px;border-top:1px solid #cbd5e1;padding-top:4px">
                                                <a href="<?= htmlspecialchars($msg['ruta_adjunto']) ?>" target="_blank" download style="color:#b91c1c;text-decoration:underline;font-weight:600;font-size:.7rem;display:flex;align-items:center;gap:4px">
                                                    📎 <?= htmlspecialchars($msg['archivo_adjunto']) ?> (Soporte)
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="chat-msg admin-msg" style="align-self:flex-end;width:85%;display:flex;flex-direction:column;align-items:flex-end">
                                    <span style="font-size:.65rem;color:#64748b;margin-bottom:2px"><?= htmlspecialchars($msg['nombre_remitente']) ?> • <?= date('Y-m-d H:i', strtotime($msg['fecha_envio'])) ?></span>
                                    <div style="background:#0284c7;color:#fff;border-radius:14px 14px 2px 14px;padding:8px 12px;font-size:.78rem;line-height:1.45;box-shadow:0 1px 2px rgba(0,0,0,0.05)">
                                        <?= nl2br(htmlspecialchars($msg['mensaje'])) ?>
                                        <?php if($msg['archivo_adjunto']): ?>
                                            <div style="margin-top:6px;border-top:1px solid rgba(255,255,255,0.2);padding-top:4px">
                                                <a href="<?= htmlspecialchars($msg['ruta_adjunto']) ?>" target="_blank" download style="color:#fff;text-decoration:underline;font-size:.7rem;display:flex;align-items:center;gap:4px">
                                                    📎 <?= htmlspecialchars($msg['archivo_adjunto']) ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            
            <div class="card">
                <div class="card-hdr"><h3>Todos los Documentos Adjuntos</h3></div>
                <div style="padding:16px 20px">
                    <?php if(empty($documentos)): ?>
                        <p style="font-size:.78rem;color:#94a3b8;font-style:italic">No se han adjuntado documentos.</p>
                    <?php else: ?>
                        <div style="display:flex;flex-direction:column;gap:8px">
                            <?php foreach($documentos as $doc): ?>
                            <div style="display:flex;align-items:center;justify-content:space-between;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:8px 12px">
                                <div style="display:flex;align-items:center;gap:8px;min-width:0">
                                    <svg style="width:14px;height:14px;color:#b91c1c;flex-shrink:0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414A2 2 0 0018.414 9L15 5.586A2 2 0 0013.586 5H7a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span style="font-size:.75rem;color:#475569;overflow:hidden;text-overflow:ellipsis;white-space:nowrap"><?= htmlspecialchars($doc['nombre_archivo']) ?></span>
                                </div>
                                <a href="<?= htmlspecialchars($doc['ruta']) ?>" target="_blank" download class="btn-p" style="padding:3px 10px;font-size:.7rem;flex-shrink:0;margin-left:10px">Descargar</a>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>

        
        <div style="display:flex;flex-direction:column;gap:16px">

            
            <div class="card">
                <div class="card-hdr"><h3>Información de la Solicitud</h3></div>
                <div style="padding:16px;display:grid;grid-template-columns:1fr 1fr;gap:12px;border-bottom:1px solid #f1f5f9">
                    <div>
                        <p style="font-size:.62rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.09em;margin-bottom:2px">Estudiante</p>
                        <p style="font-size:.78rem;color:#1e293b;font-weight:600"><?= htmlspecialchars($solicitud['est_nombre'].' '.$solicitud['est_apellido']) ?></p>
                        <p style="font-size:.68rem;color:#64748b"><?= htmlspecialchars($solicitud['est_correo']) ?></p>
                    </div>
                    <div>
                        <p style="font-size:.62rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.09em;margin-bottom:2px">Programa / Semestre</p>
                        <p style="font-size:.78rem;color:#1e293b;font-weight:600"><?= htmlspecialchars($solicitud['est_programa']) ?></p>
                        <p style="font-size:.68rem;color:#64748b">Semestre: <?= htmlspecialchars($solicitud['est_semestre']) ?></p>
                    </div>
                </div>
                <div style="padding:12px 16px;display:grid;grid-template-columns:1fr 1fr;gap:12px">
                    <div>
                        <p style="font-size:.62rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.09em;margin-bottom:2px">Fecha Radicación</p>
                        <p style="font-size:.78rem;color:#1e293b;font-weight:500"><?= $solicitud['fecha'] ?></p>
                    </div>
                    <div>
                        <p style="font-size:.62rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.09em;margin-bottom:2px">Prioridad</p>
                        <p style="font-size:.78rem;color:#1e293b;font-weight:600"><?= htmlspecialchars($solicitud['prioridad']) ?></p>
                    </div>
                </div>
            </div>

            
            <?php if($respuesta): ?>
            <div class="card">
                <div class="card-hdr"><h3>Resolución Definitiva</h3></div>
                <div style="padding:16px;display:grid;grid-template-columns:1fr 1fr;gap:10px">
                    <div>
                        <p style="font-size:.62rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.09em;margin-bottom:2px">Fecha Cierre</p>
                        <p style="font-size:.78rem;color:#1e293b;font-weight:500"><?= $respuesta['fecha_respuesta'] ?></p>
                    </div>
                    <div>
                        <p style="font-size:.62rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.09em;margin-bottom:2px">Estado Final</p>
                        <div style="margin-top:1px"><?= badge($respuesta['estado_final']) ?></div>
                    </div>
                    <div style="grid-column:span 2;margin-top:6px">
                        <p style="font-size:.62rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.09em;margin-bottom:4px">Observación Oficial</p>
                        <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:10px;font-size:.78rem;color:#1e293b;line-height:1.5"><?= htmlspecialchars($respuesta['observacion']) ?></div>
                    </div>
                    <?php if($respuesta['archivo_respuesta']): ?>
                    <div style="grid-column:span 2;margin-top:4px">
                        <p style="font-size:.62rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.09em;margin-bottom:2px">Documento Resolución</p>
                        <p style="font-size:.78rem;color:#b91c1c;font-weight:600">
                            <a href="<?= htmlspecialchars($respuesta['ruta_archivo_respuesta']) ?>" target="_blank" download style="color:#b91c1c">
                                📎 <?= htmlspecialchars($respuesta['archivo_respuesta']) ?>
                            </a>
                        </p>
                    </div>
                    <?php endif; ?>
                    <div style="grid-column:span 2;margin-top:4px">
                        <p style="font-size:.68rem;color:#94a3b8">Cerrado por: <?= htmlspecialchars($respuesta['admin_nombre']) ?></p>
                    </div>
                </div>
            </div>
            <div style="padding:12px 16px;background:#fffbeb;border:1px solid #fde68a;border-radius:12px;color:#92400e;font-size:.78rem">
                Esta solicitud ya cuenta con una resolución final definitiva y el chat está cerrado.
            </div>

            <?php else: ?>

            <div class="card">
                <div class="card-hdr"><h3>Enviar Respuesta / Resolver</h3></div>
                <div style="padding:16px 20px">
                    <form method="POST" action="/admin/responder.php?id=<?= $id ?>" enctype="multipart/form-data" style="display:flex;flex-direction:column;gap:14px">
                        <div>
                            <label style="font-size:.62rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.09em;display:block;margin-bottom:4px">Acción / Estado <span style="color:#b91c1c">*</span></label>
                            <select name="estado_final" required class="inp" style="padding:6px 10px;font-size:.78rem">
                                <option value="">— Seleccione —</option>
                                <option value="En revisión" <?= ($_POST['estado_final']??'')==='En revisión'?'selected':'' ?>>Solicitar información / Adjuntar Pago (En revisión)</option>
                                <option value="Aprobada" <?= ($_POST['estado_final']??'')==='Aprobada'?'selected':'' ?>>Aprobar Solicitud (Cierre Definitivo)</option>
                                <option value="Rechazada" <?= ($_POST['estado_final']??'')==='Rechazada'?'selected':'' ?>>Rechazar Solicitud (Cierre Definitivo)</option>
                            </select>
                            <p style="font-size:.65rem;color:#94a3b8;margin-top:4px">Tip: Elegir "En revisión" mantendrá el chat abierto para que el estudiante responda.</p>
                        </div>
                        <div>
                            <label style="font-size:.62rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.09em;display:block;margin-bottom:4px">Mensaje / Observación <span style="color:#b91c1c">*</span></label>
                            <textarea name="observacion" rows="4" required placeholder="Escriba la respuesta, solicitud de soporte o justificación definitiva..." class="inp" style="resize:vertical;padding:8px 12px;font-size:.78rem"><?= htmlspecialchars($_POST['observacion']??'') ?></textarea>
                        </div>
                        <div>
                            <label style="font-size:.62rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.09em;display:block;margin-bottom:4px">Adjuntar Documento <span style="font-weight:400;text-transform:none;letter-spacing:0;color:#94a3b8">(opcional)</span></label>
                            <input name="archivo_respuesta" type="file" accept=".pdf,.jpg,.png,.doc,.docx" class="inp" style="padding:5px 10px;font-size:.75rem;color:#64748b;cursor:pointer">
                        </div>
                        <div style="display:flex;gap:8px;padding-top:10px;border-top:1px solid #f1f5f9">
                            <button type="submit" class="btn-p" style="padding:6px 14px;font-size:.75rem;border-radius:6px">Enviar Respuesta</button>
                            <a href="/admin/solicitudes.php" class="btn-g" style="padding:6px 14px;font-size:.75rem;border-radius:6px">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
            <?php endif; ?>
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
</div>

<?php require_once __DIR__ . '/../layouts/sidebar_end.php'; ?>
