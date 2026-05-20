<?php
$pageTitle = 'Administradores | SGA Admin';
$admins     = $data['admins'];
$filtros    = $data['filtros']    ?? [];
$hayFiltros = $data['hayFiltros'] ?? false;
$roles      = $data['roles']      ?? [];
$flash_ok   = flash('success');
require_once __DIR__ . '/../layouts/sidebar_admin.php';
?>

<div class="page-header">
    <div class="breadcrumb">
        <a href="/admin/dashboard.php">Inicio</a><span>/</span><span style="color:#94a3b8">Administradores</span>
    </div>
    <h1 class="page-title">Administradores del Sistema</h1>
    <p class="page-sub">Listado de usuarios administrativos con acceso al panel</p>
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
                        <input id="q" name="q" type="text" value="<?= htmlspecialchars($filtros['q']??'') ?>" placeholder="Nombre o correo…" class="inp" style="padding-left:34px">
                    </div>
                </div>
                <div style="min-width:160px;display:flex;flex-direction:column;gap:5px">
                    <label style="font-size:.65rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.09em">Rol</label>
                    <select id="rol" name="rol" class="inp">
                        <option value="">Todos los roles</option>
                        <?php foreach($roles as $r): ?>
                            <option value="<?= htmlspecialchars($r) ?>" <?= ($filtros['rol']??'')===$r?'selected':'' ?>><?= htmlspecialchars($r) ?></option>
                        <?php endforeach; ?>
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
            <h3><?php $t=count($admins); echo $t.' administrador'.($t!==1?'es':''); if($hayFiltros) echo ' — búsqueda activa'; ?></h3>
            <?php if($hayFiltros): ?>
                <span style="padding:3px 10px;background:#fef2f2;border:1px solid #fecaca;border-radius:99px;font-size:.65rem;color:#b91c1c;font-weight:700">Filtros activos</span>
            <?php endif; ?>
        </div>
        <div style="overflow-x:auto">
            <table class="tbl w-full">
                <thead>
                    <tr>
                        <th style="text-align:left">ID</th>
                        <th style="text-align:left">Nombre</th>
                        <th style="text-align:left" class="hidden sm:table-cell">Correo</th>
                        <th style="text-align:left">Rol</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($admins)): ?>
                        <tr><td colspan="4" style="padding:60px;text-align:center;color:#94a3b8">
                            No se encontraron administradores. <a href="?" style="color:#b91c1c;font-weight:600">Limpiar filtros</a>
                        </td></tr>
                    <?php else: foreach($admins as $a): ?>
                        <tr>
                            <td style="font-family:monospace;font-size:.72rem;color:#94a3b8"><?= $a['id_admin'] ?></td>
                            <td style="color:#1e293b;font-weight:500"><?= htmlspecialchars($a['nombre']) ?></td>
                            <td class="hidden sm:table-cell" style="font-size:.75rem"><?= htmlspecialchars($a['correo']) ?></td>
                            <td><span style="padding:3px 10px;background:#f1f5f9;color:#475569;font-size:.7rem;font-weight:600;border-radius:99px"><?= htmlspecialchars($a['rol']) ?></span></td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/sidebar_end.php'; ?>
