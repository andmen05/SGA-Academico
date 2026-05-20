<?php
$pageTitle = 'Nueva Solicitud | SGA Académico';
require_once __DIR__ . '/../layouts/sidebar_student.php';

$tipos=$data['tipos'];$errores=$data['errores'];$post=$data['post'];
?>

<div class="page-header">
    <div class="breadcrumb"><a href="/student/dashboard.php">Inicio</a> <span>›</span> <span>Nueva Solicitud</span></div>
    <h1 class="page-title">Realizar Solicitud Académica</h1>
    <p class="page-sub">Complete el formulario para radicar su solicitud ante secretaría académica</p>
</div>

<div class="content-body">

<?php if(!empty($errores)): ?>
    <div style="margin-bottom:20px;padding:14px 18px;background:#fef2f2;border:1px solid #fecaca;border-radius:12px;color:#b91c1c;font-size:.8125rem">
        <p style="font-weight:700;margin-bottom:6px">Corrija los siguientes errores:</p>
        <?php foreach($errores as $e): ?><p style="margin-top:2px">- <?= htmlspecialchars($e) ?></p><?php endforeach; ?>
    </div>
<?php endif; ?>

<div style="display:grid;grid-template-columns:1fr 300px;gap:18px">
    <div class="card">
        <div class="card-hdr"><h3>Datos de la Solicitud</h3></div>
        <div style="padding:22px">
            <form method="POST" action="/student/nueva-solicitud.php" enctype="multipart/form-data" style="display:flex;flex-direction:column;gap:18px">
                <div>
                    <label class="fl">Tipo de Solicitud <span style="color:#b91c1c">*</span></label>
                    <select id="id_tipo_solicitud" name="id_tipo_solicitud" required class="inp">
                        <option value="">- Seleccione el tipo -</option>
                        <?php foreach($tipos as $t): ?>
                            <option value="<?= $t['id_tipo_solicitud'] ?>" <?= (intval($post['id_tipo_solicitud']??0)===(int)$t['id_tipo_solicitud'])?'selected':'' ?>><?= htmlspecialchars($t['nombre_tipo']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="fl">Descripción / Motivo <span style="color:#b91c1c">*</span></label>
                    <textarea id="descripcion" name="descripcion" rows="6" required placeholder="Explique detalladamente el motivo de su solicitud..." class="inp" style="resize:vertical"><?= htmlspecialchars($post['descripcion']??'') ?></textarea>
                </div>
                <div>
                    <label class="fl">Adjuntar Documento <span style="color:#94a3b8;font-weight:400;text-transform:none;letter-spacing:0">(opcional)</span></label>
                    <input id="documento" name="documento" type="file" accept=".pdf,.jpg,.png,.doc,.docx" class="inp" style="padding:7px 14px;color:#64748b;cursor:pointer">
                    <p style="font-size:.72rem;color:#94a3b8;margin-top:5px">Formatos: PDF, JPG, PNG, DOC. Max 5 MB.</p>
                </div>
                <div style="display:flex;gap:10px;padding-top:10px;border-top:1px solid #f1f5f9">
                    <button type="submit" class="btn-p">Radicar Solicitud</button>
                    <a href="/student/dashboard.php" class="btn-g">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
    <div style="display:flex;flex-direction:column;gap:16px">
        <div class="card">
            <div class="card-hdr"><h3>Datos del Solicitante</h3></div>
            <div style="padding:16px 20px;display:flex;flex-direction:column;gap:7px">
                <div class="data-row"><span class="data-row-label">Nombre</span><span class="data-row-val"><?= htmlspecialchars($_SESSION['user']['nombre'].' '.$_SESSION['user']['apellido']) ?></span></div>
                <div class="data-row"><span class="data-row-label">Correo</span><span class="data-row-val" style="font-size:.72rem"><?= htmlspecialchars($_SESSION['user']['correo']) ?></span></div>
                <div class="data-row"><span class="data-row-label">Semestre</span><span class="data-row-val"><?= $_SESSION['user']['semestre'] ?></span></div>
                <div class="data-row"><span class="data-row-label">Programa</span><span class="data-row-val" style="font-size:.72rem"><?= htmlspecialchars($_SESSION['user']['programa']) ?></span></div>
            </div>
        </div>
        <div class="card">
            <div class="card-hdr"><h3>Instrucciones</h3></div>
            <div style="padding:16px 20px;display:flex;flex-direction:column;gap:6px">
                <p class="tip">Seleccione el tipo de solicitud que corresponde a su trámite.</p>
                <p class="tip">Describa detalladamente el motivo.</p>
                <p class="tip">Adjunte documentos de soporte si es necesario.</p>
                <p class="tip">Haga clic en Radicar Solicitud para enviar.</p>
                <div style="margin-top:10px;padding:10px 12px;background:#fef2f2;border:1px solid #fecaca;border-radius:8px">
                    <p style="font-size:.75rem;color:#b91c1c;font-weight:600">La respuesta será notificada en los próximos 5 días hábiles.</p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php require_once __DIR__ . '/../layouts/sidebar_end.php'; ?>