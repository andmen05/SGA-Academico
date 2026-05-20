<?php
$pageTitle = 'Estudiantes | SGA Admin';
$estudiantes  = $data['estudiantes'];
$filtros      = $data['filtros']    ?? [];
$hayFiltros   = $data['hayFiltros'] ?? false;
$flash_ok     = flash('success');
require_once __DIR__ . '/../layouts/sidebar_admin.php';
?>

<div class="page-header">
    <div class="breadcrumb">
        <a href="/admin/dashboard.php">Inicio</a><span>/</span><span style="color:#94a3b8">Estudiantes</span>
    </div>
    <h1 class="page-title">Gestión de Estudiantes</h1>
    <p class="page-sub">Consulta y búsqueda de estudiantes registrados en el sistema</p>
</div>

<div class="content-body">

    <?php if ($flash_ok): ?>
        <div style="margin-bottom:20px;padding:12px 16px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;color:#15803d;font-size:.8125rem;display:flex;align-items:center;gap:8px">
            <span style="width:6px;height:6px;border-radius:50%;background:#16a34a;display:inline-block"></span>
            <?= htmlspecialchars($flash_ok) ?>
        </div>
    <?php endif; ?>

    
    <div class="card" style="margin-bottom:20px;overflow:visible">
        <div class="card-hdr"><h3>Filtros de búsqueda</h3></div>
        <div style="padding:18px 20px">
            <form method="GET" action="" style="display:flex;flex-wrap:wrap;gap:14px;align-items:flex-end">
                <div style="flex:1;min-width:200px;display:flex;flex-direction:column;gap:5px">
                    <label style="font-size:.65rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.09em">Buscar</label>
                    <div style="position:relative">
                        <svg style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:15px;height:15px;color:#94a3b8;pointer-events:none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                        </svg>
                        <input id="q" name="q" type="text" value="<?= htmlspecialchars($filtros['q']??'') ?>"
                               placeholder="Nombre, apellido, documento o correo…" class="inp" style="padding-left:34px">
                    </div>
                </div>
                <div style="min-width:160px;display:flex;flex-direction:column;gap:5px">
                    <label style="font-size:.65rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.09em">Programa</label>
                    <input id="programa" name="programa" type="text" value="<?= htmlspecialchars($filtros['programa']??'') ?>" placeholder="Ej: Ingeniería…" class="inp">
                </div>
                <div style="min-width:130px;display:flex;flex-direction:column;gap:5px">
                    <label style="font-size:.65rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.09em">Semestre</label>
                    <select id="semestre" name="semestre" class="inp">
                        <option value="">Todos</option>
                        <?php for($s=1;$s<=10;$s++): ?>
                            <option value="<?= $s ?>" <?= ($filtros['semestre']??'')==$s?'selected':'' ?>><?= $s ?>° sem.</option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div style="display:flex;gap:8px;align-items:flex-end">
                    <button type="submit" class="btn-p">Filtrar</button>
                    <?php if($hayFiltros): ?><a href="?" class="btn-g">Limpiar</a><?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    
    <div class="card">
        <div class="card-hdr">
            <h3><?php $t=count($estudiantes); echo $t.' estudiante'.($t!==1?'s':''); if($hayFiltros) echo ' — búsqueda activa'; ?></h3>
            <?php if($hayFiltros): ?>
                <span style="padding:3px 10px;background:#fef2f2;border:1px solid #fecaca;border-radius:99px;font-size:.65rem;color:#b91c1c;font-weight:700">Filtros activos</span>
            <?php endif; ?>
        </div>
        <div style="overflow-x:auto">
            <table class="tbl w-full">
                <thead>
                    <tr>
                        <th style="text-align:left">ID</th>
                        <th style="text-align:left">Nombre Completo</th>
                        <th style="text-align:left" class="hidden sm:table-cell">Documento</th>
                        <th style="text-align:left" class="hidden md:table-cell">Correo</th>
                        <th style="text-align:left" class="hidden lg:table-cell">Teléfono</th>
                        <th style="text-align:left" class="hidden sm:table-cell">Sem.</th>
                        <th style="text-align:left" class="hidden xl:table-cell">Programa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($estudiantes)): ?>
                        <tr><td colspan="7" style="padding:60px;text-align:center;color:#94a3b8">
                            No se encontraron estudiantes. <a href="?" style="color:#b91c1c;font-weight:600">Limpiar filtros</a>
                        </td></tr>
                    <?php else: foreach($estudiantes as $est): ?>
                        <tr>
                            <td style="font-family:monospace;font-size:.72rem;color:#94a3b8"><?= $est['id_estudiante'] ?></td>
                            <td style="color:#1e293b;font-weight:500"><?= htmlspecialchars($est['nombre'].' '.$est['apellido']) ?></td>
                            <td class="hidden sm:table-cell"><?= htmlspecialchars($est['documento']) ?></td>
                            <td class="hidden md:table-cell" style="font-size:.75rem"><?= htmlspecialchars($est['correo']) ?></td>
                            <td class="hidden lg:table-cell"><?= htmlspecialchars($est['telefono']) ?></td>
                            <td class="hidden sm:table-cell" style="font-weight:600;color:#1e293b;text-align:center"><?= $est['semestre'] ?></td>
                            <td class="hidden xl:table-cell" style="font-size:.72rem;color:#94a3b8"><?= htmlspecialchars($est['programa']) ?></td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/sidebar_end.php'; ?>
