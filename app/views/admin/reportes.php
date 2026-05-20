<?php
$pageTitle = 'Reportes del Sistema | SGA Académico';
require_once __DIR__ . '/../layouts/sidebar_admin.php';

$solicitudes      = $data['solicitudes'];
$filtros          = $data['filtros'];
$totalSolicitudes = $data['totalSolicitudes'];
$tiempoPromedio   = $data['tiempoPromedio'];
$tasaResolucion   = $data['tasaResolucion'];
$porEstado        = $data['porEstado'];
$porPrioridad     = $data['porPrioridad'];
$porTipo          = $data['porTipo'];
$porPrograma      = $data['porPrograma'];
$tipos            = $data['tipos'];
$programas        = $data['programas'];


$queryParams = $_GET;
$queryParams['export'] = 'csv';
$exportUrl = '/admin/reportes.php?' . http_build_query($queryParams);
?>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="page-header">
    <div class="breadcrumb">
        <a href="/admin/dashboard.php">Inicio</a>
        <span>&middot;</span>
        <span>Reportes</span>
    </div>
    <h1 class="page-title">Reportes Analíticos del Sistema</h1>
    <p class="page-sub">Monitorea estadísticas, tiempos de atención y exporta datos consolidados en tiempo real.</p>
</div>

<div class="content-body space-y-6">

    
    <div class="card p-6 shadow-sm border-slate-200">
        <div class="flex items-center gap-2 mb-4">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
            </svg>
            <h3 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Filtros de Búsqueda y Consolidación</h3>
        </div>
        <form method="GET" action="/admin/reportes.php" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1">Fecha Inicio</label>
                <input type="date" name="fecha_inicio" value="<?= e($filtros['fecha_inicio']) ?>" class="inp py-2">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1">Fecha Fin</label>
                <input type="date" name="fecha_fin" value="<?= e($filtros['fecha_fin']) ?>" class="inp py-2">
            </div>
            
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1">Tipo de Solicitud</label>
                <select name="tipo" class="inp py-2">
                    <option value="">Todos los tipos</option>
                    <?php foreach ($tipos as $id => $nombre): ?>
                        <option value="<?= $id ?>" <?= $filtros['id_tipo_solicitud'] == $id ? 'selected' : '' ?>>
                            <?= e($nombre) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1">Estado</label>
                <select name="estado" class="inp py-2">
                    <option value="">Todos los estados</option>
                    <option value="Pendiente" <?= $filtros['estado'] === 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
                    <option value="En revisión" <?= $filtros['estado'] === 'En revisión' ? 'selected' : '' ?>>En revisión</option>
                    <option value="Aprobada" <?= $filtros['estado'] === 'Aprobada' ? 'selected' : '' ?>>Aprobada</option>
                    <option value="Rechazada" <?= $filtros['estado'] === 'Rechazada' ? 'selected' : '' ?>>Rechazada</option>
                </select>
            </div>
            
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1">Prioridad</label>
                <select name="prioridad" class="inp py-2">
                    <option value="">Todas</option>
                    <option value="Alta" <?= $filtros['prioridad'] === 'Alta' ? 'selected' : '' ?>>Alta</option>
                    <option value="Media" <?= $filtros['prioridad'] === 'Media' ? 'selected' : '' ?>>Media</option>
                    <option value="Baja" <?= $filtros['prioridad'] === 'Baja' ? 'selected' : '' ?>>Baja</option>
                </select>
            </div>
            
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1">Programa Académico</label>
                <select name="programa" class="inp py-2">
                    <option value="">Todos</option>
                    <?php foreach ($programas as $p): ?>
                        <option value="<?= e($p) ?>" <?= $filtros['programa'] === $p ? 'selected' : '' ?>>
                            <?= e($p) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            
            <div class="lg:col-span-6 flex flex-wrap gap-2 justify-end mt-2 pt-4 border-t border-slate-100">
                <a href="/admin/reportes.php" class="btn-g text-xs font-semibold flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Limpiar Filtros
                </a>
                <button type="submit" class="btn-p text-xs font-semibold flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Filtrar Datos
                </button>
            </div>
        </form>
    </div>

    
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        
        <div class="kpi kpi-total bg-white p-6 rounded-2xl border border-slate-200 flex flex-col justify-between">
            <div>
                <div class="kpi-label text-slate-400 font-bold text-xs uppercase tracking-wider mb-2">Total Solicitudes Filtradas</div>
                <div class="kpi-val text-3xl font-extrabold text-slate-800"><?= $totalSolicitudes ?></div>
            </div>
            <div class="text-xs text-slate-500 mt-4 flex items-center gap-1">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Según el rango de filtros seleccionado
            </div>
        </div>

        
        <div class="kpi kpi-apro bg-white p-6 rounded-2xl border border-slate-200 flex flex-col justify-between">
            <div>
                <div class="kpi-label text-slate-400 font-bold text-xs uppercase tracking-wider mb-2">Tasa de Resolución</div>
                <div class="kpi-val text-3xl font-extrabold text-emerald-700"><?= $tasaResolucion ?>%</div>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-1.5 mt-4">
                <div class="bg-emerald-500 h-1.5 rounded-full" style="width: <?= $tasaResolucion ?>%"></div>
            </div>
            <div class="text-xs text-slate-500 mt-2">
                Solicitudes resueltas (Aprobadas / Rechazadas)
            </div>
        </div>

        
        <div class="kpi kpi-rev bg-white p-6 rounded-2xl border border-slate-200 flex flex-col justify-between">
            <div>
                <div class="kpi-label text-slate-400 font-bold text-xs uppercase tracking-wider mb-2">Tiempo Promedio de Respuesta</div>
                <div class="kpi-val text-3xl font-extrabold text-blue-800">
                    <?= $tiempoPromedio !== null ? $tiempoPromedio . ' <span class="text-lg font-medium text-slate-500">días</span>' : '<span class="text-lg font-semibold text-slate-400">Sin datos</span>' ?>
                </div>
            </div>
            <div class="text-xs text-slate-500 mt-4 flex items-center gap-1">
                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Medido desde radicación a respuesta final
            </div>
        </div>
    </div>

    
    <?php if ($totalSolicitudes > 0): ?>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <div class="card p-6 shadow-sm border-slate-200 bg-white">
                <div class="border-b border-slate-100 pb-3 mb-4 flex items-center justify-between">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Estado y Prioridades</h3>
                    <span class="px-2 py-0.5 bg-slate-100 rounded text-slate-500 text-[10px] font-semibold">Distribución porcentual</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="flex flex-col items-center">
                        <span class="text-xs font-bold text-slate-600 mb-2">Por Estado</span>
                        <div class="w-full max-w-[200px] h-[200px]">
                            <canvas id="chartEstado"></canvas>
                        </div>
                    </div>
                    <div class="flex flex-col items-center">
                        <span class="text-xs font-bold text-slate-600 mb-2">Por Prioridad</span>
                        <div class="w-full max-w-[200px] h-[200px]">
                            <canvas id="chartPrioridad"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="card p-6 shadow-sm border-slate-200 bg-white">
                <div class="border-b border-slate-100 pb-3 mb-4">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Solicitudes por Programa Académico</h3>
                </div>
                <div class="w-full h-[230px]">
                    <canvas id="chartProgramas"></canvas>
                </div>
            </div>

            
            <div class="card p-6 shadow-sm border-slate-200 bg-white lg:col-span-2">
                <div class="border-b border-slate-100 pb-3 mb-4">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Top Tipos de Solicitud Más Frecuentes</h3>
                </div>
                <div class="w-full h-[280px]">
                    <canvas id="chartTipos"></canvas>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="card p-12 text-center border-slate-200 bg-white flex flex-col items-center justify-center">
            <svg class="w-16 h-16 text-slate-300 mb-4 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h3 class="text-lg font-bold text-slate-700">No se encontraron registros</h3>
            <p class="text-sm text-slate-500 max-w-md mt-1">Intente cambiar las fechas de inicio/fin o quitar filtros para ver gráficos analíticos del sistema.</p>
        </div>
    <?php endif; ?>

    
    <div class="card shadow-sm border-slate-200 bg-white">
        <div class="card-hdr flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-5">
            <div>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Listado de Datos Filtrados</h3>
                <p class="text-[11px] text-slate-500 mt-1">Se muestran los registros en base a los criterios de arriba.</p>
            </div>
            <div>
                <a href="<?= $exportUrl ?>" class="btn-p text-xs font-semibold bg-gradient-to-r from-red-700 to-red-900 flex items-center gap-1.5 shadow hover:shadow-lg transition">
                    
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Exportar Valores a CSV (Excel)
                </a>
            </div>
        </div>

        <div style="overflow-x:auto">
            <table class="tbl w-full">
                <thead>
                    <tr>
                        <th style="text-align:left">Radicado</th>
                        <th style="text-align:left">Estudiante</th>
                        <th style="text-align:left" class="hidden md:table-cell">Programa Académico</th>
                        <th style="text-align:left">Tipo de Solicitud</th>
                        <th style="text-align:left" class="hidden sm:table-cell">Fecha</th>
                        <th style="text-align:left">Prioridad</th>
                        <th style="text-align:left">Estado</th>
                        <th style="text-align:center" class="hidden md:table-cell">Días</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($solicitudes)): ?>
                        <tr>
                            <td colspan="8" style="text-align:center;padding:32px;color:#94a3b8;font-size:0.85rem">
                                No hay registros que coincidan con los filtros aplicados.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($solicitudes as $s): ?>
                        <tr>
                            <td>
                                <span style="font-family:monospace;font-size:.72rem;color:#94a3b8;background:#f8fafc;padding:2px 6px;border-radius:5px">
                                    SOL-<?= str_pad($s['id_solicitud'],4,'0',STR_PAD_LEFT) ?>
                                </span>
                            </td>
                            <td>
                                <div class="font-medium text-slate-800"><?= htmlspecialchars($s['est_nombre'].' '.$s['est_apellido']) ?></div>
                                <div class="text-[10px] text-slate-400 hidden sm:block"><?= htmlspecialchars($s['est_correo']) ?></div>
                            </td>
                            <td class="hidden md:table-cell" style="font-size:0.78rem;color:#64748b">
                                <?= htmlspecialchars($s['est_programa']) ?>
                                <span class="block text-[10px] text-slate-400">Semestre <?= $s['est_semestre'] ?></span>
                            </td>
                            <td style="font-size:0.78rem;color:#475569">
                                <?= htmlspecialchars($s['tipo_nombre']) ?>
                            </td>
                            <td class="hidden sm:table-cell" style="color:#64748b;font-size:0.78rem">
                                <?= $s['fecha'] ?>
                            </td>
                            <td>
                                <?php
                                $prioColor = match($s['prioridad']) {
                                    'Alta' => 'bg-red-100 text-red-700 border border-red-200',
                                    'Media' => 'bg-amber-100 text-amber-700 border border-amber-200',
                                    'Baja' => 'bg-slate-100 text-slate-700 border border-slate-200',
                                    default => 'bg-gray-100 text-gray-700'
                                };
                                ?>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold <?= $prioColor ?>">
                                    <?= $s['prioridad'] ?>
                                </span>
                            </td>
                            <td>
                                <?= badge($s['estado']) ?>
                            </td>
                            <td style="text-align:center" class="hidden md:table-cell font-semibold">
                                <?php if ($s['dias_respuesta'] !== null): ?>
                                    <span class="text-xs text-slate-600"><?= $s['dias_respuesta'] ?> d</span>
                                <?php else: ?>
                                    <span class="text-xs text-slate-300">—</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <?php if (!empty($solicitudes)): ?>
            <div class="p-4 border-t border-slate-100 text-right text-xs text-slate-500 bg-slate-50">
                Mostrando <b><?= count($solicitudes) ?></b> registros.
            </div>
        <?php endif; ?>
    </div>

</div>


<?php if ($totalSolicitudes > 0): ?>
<script>
    // Paleta de colores Premium
    const colors = {
        primary: ['#f59e0b', '#3b82f6', '#10b981', '#ef4444'], // Pendiente, En revisión, Aprobada, Rechazada
        priorities: ['#ef4444', '#f59e0b', '#64748b'], // Alta, Media, Baja
        gradients: [
            'rgba(185, 28, 28, 0.85)',   // Crimson Red
            'rgba(99, 102, 241, 0.85)',   // Indigo
            'rgba(16, 185, 129, 0.85)',   // Emerald Green
            'rgba(245, 158, 11, 0.85)',   // Amber
            'rgba(14, 116, 144, 0.85)',   // Cyan
            'rgba(124, 58, 237, 0.85)',   // Violet
            'rgba(71, 85, 105, 0.85)'     // Slate
        ],
        borders: [
            '#b91c1c', '#6366f1', '#10b981', '#f59e0b', '#0e7490', '#7c3aed', '#475569'
        ]
    };

    // 1. Gráfico Estado (Dona)
    const ctxEstado = document.getElementById('chartEstado').getContext('2d');
    new Chart(ctxEstado, {
        type: 'doughnut',
        data: {
            labels: ['Pendiente', 'En revisión', 'Aprobada', 'Rechazada'],
            datasets: [{
                data: [
                    <?= $porEstado['Pendiente'] ?>,
                    <?= $porEstado['En revisión'] ?>,
                    <?= $porEstado['Aprobada'] ?>,
                    <?= $porEstado['Rechazada'] ?>
                ],
                backgroundColor: colors.primary,
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 10,
                        font: { size: 10, family: "'Inter', sans-serif" }
                    }
                }
            },
            cutout: '60%'
        }
    });

    // 2. Gráfico Prioridad (Dona)
    const ctxPrioridad = document.getElementById('chartPrioridad').getContext('2d');
    new Chart(ctxPrioridad, {
        type: 'doughnut',
        data: {
            labels: ['Alta', 'Media', 'Baja'],
            datasets: [{
                data: [
                    <?= $porPrioridad['Alta'] ?>,
                    <?= $porPrioridad['Media'] ?>,
                    <?= $porPrioridad['Baja'] ?>
                ],
                backgroundColor: colors.priorities,
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 10,
                        font: { size: 10, family: "'Inter', sans-serif" }
                    }
                }
            },
            cutout: '60%'
        }
    });

    // 3. Gráfico Programas Académicos (Barras Verticales)
    const ctxProgramas = document.getElementById('chartProgramas').getContext('2d');
    <?php
    $progLabels = array_keys($porPrograma);
    $progValues = array_values($porPrograma);
    ?>
    new Chart(ctxProgramas, {
        type: 'bar',
        data: {
            labels: <?= json_encode($progLabels) ?>,
            datasets: [{
                label: 'Solicitudes',
                data: <?= json_encode($progValues) ?>,
                backgroundColor: 'rgba(99, 102, 241, 0.8)',
                borderColor: '#6366f1',
                borderWidth: 1,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                        font: { size: 10, family: "'Inter', sans-serif" }
                    },
                    grid: { color: '#f1f5f9' }
                },
                x: {
                    ticks: {
                        font: { size: 9, family: "'Inter', sans-serif" }
                    },
                    grid: { display: false }
                }
            }
        }
    });

    // 4. Gráfico Tipos de Solicitud (Barras Horizontales)
    const ctxTipos = document.getElementById('chartTipos').getContext('2d');
    <?php
    
    $topTiposLimit = array_slice($porTipo, 0, 7, true);
    $tipoLabels = array_keys($topTiposLimit);
    $tipoValues = array_values($topTiposLimit);
    ?>
    new Chart(ctxTipos, {
        type: 'bar',
        data: {
            labels: <?= json_encode($tipoLabels) ?>,
            datasets: [{
                label: 'Cantidad',
                data: <?= json_encode($tipoValues) ?>,
                backgroundColor: colors.gradients,
                borderColor: colors.borders,
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                        font: { size: 10, family: "'Inter', sans-serif" }
                    },
                    grid: { color: '#f1f5f9' }
                },
                y: {
                    ticks: {
                        font: { size: 9, family: "'Inter', sans-serif" }
                    },
                    grid: { display: false }
                }
            }
        }
    });
</script>
<?php endif; ?>

<?php require_once __DIR__ . '/../layouts/sidebar_end.php'; ?>
