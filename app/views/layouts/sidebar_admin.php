<?php $cur = basename($_SERVER['PHP_SELF']); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'SGA Admin' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *,body{font-family:'Inter',sans-serif}
        body{background:#f1f5f9;display:flex;min-height:100vh;margin:0}

        
        .sbar{
            width:260px;min-width:260px;
            background:linear-gradient(180deg,#0f172a 0%,#1a2035 60%,#0f172a 100%);
            min-height:100vh;height:100vh;
            position:sticky;top:0;
            display:flex;flex-direction:column;
            border-right:1px solid rgba(255,255,255,0.05);
            overflow:hidden;
        }
        .sbar-grid{
            position:absolute;inset:0;pointer-events:none;
            background-image:
                linear-gradient(rgba(255,255,255,0.02) 1px,transparent 1px),
                linear-gradient(90deg,rgba(255,255,255,0.02) 1px,transparent 1px);
            background-size:32px 32px;
        }
        .sbar-glow{
            position:absolute;top:-80px;left:-80px;
            width:240px;height:240px;border-radius:50%;
            background:rgba(185,28,28,0.15);filter:blur(60px);
            pointer-events:none;
        }
        .sbar-glow2{
            position:absolute;bottom:-60px;right:-40px;
            width:180px;height:180px;border-radius:50%;
            background:rgba(99,102,241,0.08);filter:blur(50px);
            pointer-events:none;
        }
        .sbar-logo-wrap{
            padding:28px 24px 24px;position:relative;z-index:2;
            border-bottom:1px solid rgba(255,255,255,0.06);
        }
        .sbar-logo-img{
            width:56px;height:56px;object-fit:contain;
            display:block;margin:0 auto 12px;
            filter:drop-shadow(0 2px 8px rgba(185,28,28,0.3));
        }
        .sbar-logo-name{
            text-align:center;color:#fff;font-size:.9rem;
            font-weight:800;letter-spacing:.03em;line-height:1.2;
        }
        .sbar-logo-sub{
            text-align:center;color:rgba(148,163,184,0.6);
            font-size:.62rem;margin-top:3px;letter-spacing:.05em;
            text-transform:uppercase;
        }

        
        .sbar-nav{flex:1;padding:20px 14px;position:relative;z-index:2;overflow-y:auto}
        .sbar-section-title{
            font-size:.6rem;font-weight:700;color:rgba(148,163,184,0.4);
            text-transform:uppercase;letter-spacing:.1em;
            padding:0 10px;margin-bottom:8px;margin-top:4px;
        }
        .sbar-link{
            display:flex;align-items:center;gap:10px;
            padding:9px 12px;border-radius:10px;margin-bottom:2px;
            color:rgba(148,163,184,0.8);font-size:.8125rem;font-weight:500;
            text-decoration:none;transition:all .15s;cursor:pointer;
        }
        .sbar-link:hover{background:rgba(255,255,255,0.07);color:#fff}
        .sbar-link.active{
            background:linear-gradient(135deg,rgba(185,28,28,0.3),rgba(185,28,28,0.15));
            color:#fff;font-weight:600;
            border:1px solid rgba(185,28,28,0.2);
        }
        .sbar-link svg{width:16px;height:16px;flex-shrink:0;opacity:.7}
        .sbar-link.active svg{opacity:1}
        .sbar-divider{height:1px;background:rgba(255,255,255,0.06);margin:12px 10px}

        
        .sbar-user{
            padding:16px 20px;border-top:1px solid rgba(255,255,255,0.06);
            position:relative;z-index:2;
        }
        .sbar-user-row{display:flex;align-items:center;gap:10px}
        .sbar-avatar{
            width:34px;height:34px;border-radius:50%;flex-shrink:0;
            background:linear-gradient(135deg,#b91c1c,#7f1d1d);
            display:flex;align-items:center;justify-content:center;
            font-size:.75rem;font-weight:700;color:#fff;
        }
        .sbar-user-name{color:#e2e8f0;font-size:.78rem;font-weight:600;line-height:1.2}
        .sbar-user-role{color:rgba(148,163,184,0.6);font-size:.65rem;margin-top:1px}
        .sbar-logout{
            display:block;margin-top:10px;padding:7px 12px;
            background:rgba(255,255,255,0.05);border-radius:8px;
            color:rgba(148,163,184,0.7);font-size:.75rem;font-weight:500;
            text-decoration:none;text-align:center;transition:all .15s;
            border:1px solid rgba(255,255,255,0.06);
        }
        .sbar-logout:hover{background:rgba(185,28,28,0.2);color:#fca5a5;border-color:rgba(185,28,28,0.2)}

        
        .mob-bar{
            display:none;position:fixed;top:0;left:0;right:0;z-index:50;
            background:linear-gradient(90deg,#0f172a,#1e293b);
            height:56px;align-items:center;padding:0 16px;
            border-bottom:1px solid rgba(255,255,255,0.06);
            justify-content:space-between;
        }
        .mob-menu{
            display:none;position:fixed;inset:0;z-index:40;background:rgba(0,0,0,0.6);
            backdrop-filter:blur(4px);
        }
        .mob-panel{
            position:absolute;left:0;top:0;bottom:0;width:260px;
            background:#0f172a;overflow-y:auto;
        }

        
        .content-wrap{flex:1;min-width:0;display:flex;flex-direction:column}

        
        .page-header{
            background:linear-gradient(135deg,#1e293b 0%,#0f172a 100%);
            padding:28px 32px 24px;
            border-bottom:1px solid rgba(255,255,255,0.06);
            position:relative;overflow:hidden;
        }
        .page-header::after{
            content:'';position:absolute;right:-40px;top:-40px;
            width:180px;height:180px;border-radius:50%;
            background:rgba(185,28,28,0.08);filter:blur(40px);
            pointer-events:none;
        }
        .page-title{color:#f1f5f9;font-size:1.35rem;font-weight:800;letter-spacing:-.01em;position:relative;z-index:1}
        .page-sub{color:rgba(148,163,184,0.7);font-size:.8125rem;margin-top:4px;position:relative;z-index:1}
        .breadcrumb{display:flex;align-items:center;gap:6px;font-size:.7rem;color:rgba(100,116,139,.7);margin-bottom:8px;position:relative;z-index:1}
        .breadcrumb a{color:rgba(100,116,139,.7);text-decoration:none}
        .breadcrumb a:hover{color:#94a3b8}
        .breadcrumb span{color:rgba(100,116,139,.4)}

        
        .card{background:#fff;border:1px solid #e2e8f0;border-radius:16px;overflow:hidden}
        .card-hdr{
            padding:14px 20px;border-bottom:1px solid #f1f5f9;
            background:linear-gradient(135deg,#fafafa,#f8fafc);
            display:flex;align-items:center;justify-content:space-between;
        }
        .card-hdr h3{font-size:.68rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.09em}

        
        .inp{border:1px solid #e2e8f0;border-radius:10px;padding:9px 14px;font-size:.8125rem;color:#1e293b;outline:none;transition:border-color .15s,box-shadow .15s;background:#fff;font-family:'Inter',sans-serif;width:100%}
        .inp:focus{border-color:#b91c1c;box-shadow:0 0 0 3px rgba(185,28,28,.1)}

        
        .btn-p{background:linear-gradient(135deg,#b91c1c,#7f1d1d);color:#fff;font-size:.8125rem;font-weight:600;padding:9px 20px;border-radius:10px;transition:opacity .15s,transform .1s;cursor:pointer;border:none;font-family:'Inter',sans-serif;text-decoration:none;display:inline-block}
        .btn-p:hover{opacity:.88;transform:translateY(-1px)}
        .btn-g{border:1px solid #e2e8f0;background:#fff;color:#64748b;font-size:.8125rem;font-weight:500;padding:9px 20px;border-radius:10px;transition:background .15s;text-decoration:none;display:inline-block;cursor:pointer;font-family:'Inter',sans-serif}
        .btn-g:hover{background:#f8fafc}

        
        .tbl th{font-size:.65rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.09em;background:linear-gradient(135deg,#fafafa,#f8fafc);padding:11px 18px;border-bottom:1px solid #f1f5f9}
        .tbl td{padding:13px 18px;font-size:.8125rem;color:#475569;border-bottom:1px solid #f8fafc}
        .tbl tr:last-child td{border-bottom:none}
        .tbl tr:hover td{background:linear-gradient(135deg,#fafbfc,#f8fafc)}

        
        .kpi{background:#fff;border:1px solid #e2e8f0;border-radius:16px;padding:20px 22px;transition:all .2s;position:relative;overflow:hidden}
        .kpi::before{content:'';position:absolute;top:0;left:0;right:0;height:3px}
        .kpi:hover{box-shadow:0 8px 30px rgba(0,0,0,0.08);transform:translateY(-2px)}
        .kpi-total::before{background:linear-gradient(90deg,#64748b,#94a3b8)}
        .kpi-pend::before{background:linear-gradient(90deg,#f59e0b,#d97706)}
        .kpi-rev::before{background:linear-gradient(90deg,#3b82f6,#2563eb)}
        .kpi-apro::before{background:linear-gradient(90deg,#10b981,#059669)}
        .kpi-rech::before{background:linear-gradient(90deg,#ef4444,#b91c1c)}
        .kpi-label{font-size:.65rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.09em;margin-bottom:8px}
        .kpi-val{font-size:2.2rem;font-weight:800;line-height:1;letter-spacing:-.02em}

        
        .content-body{padding:28px 32px;flex:1}

        @media(max-width:1024px){
            .sbar{display:none}
            .mob-bar{display:flex}
            .content-body{padding:16px;padding-top:72px}
            .page-header{padding:80px 20px 20px}
        }
    </style>
</head>
<body>


<aside class="sbar">
    <div class="sbar-grid"></div>
    <div class="sbar-glow"></div>
    <div class="sbar-glow2"></div>

    
    <div class="sbar-logo-wrap">
        <img src="/public/img/logo.png" alt="SGA" class="sbar-logo-img">
        <div class="sbar-logo-name">SGA Académico</div>
        <div class="sbar-logo-sub">Panel Administrativo</div>
    </div>

    
    <nav class="sbar-nav">
        <div class="sbar-section-title">Principal</div>

        <a href="/admin/dashboard.php" class="sbar-link <?= $cur==='dashboard.php'?'active':'' ?>">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Inicio
        </a>

        <a href="/admin/solicitudes.php" class="sbar-link <?= $cur==='solicitudes.php'?'active':'' ?>">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Solicitudes
        </a>

        <a href="/admin/reportes.php" class="sbar-link <?= $cur==='reportes.php'?'active':'' ?>">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            Reportes
        </a>

        <div class="sbar-divider"></div>
        <div class="sbar-section-title">Gestión</div>

        <a href="/admin/estudiantes.php" class="sbar-link <?= $cur==='estudiantes.php'?'active':'' ?>">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            Estudiantes
        </a>

        <a href="/admin/administradores.php" class="sbar-link <?= $cur==='administradores.php'?'active':'' ?>">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            Administradores
        </a>
    </nav>

    
    <div class="sbar-user">
        <div class="sbar-user-row">
            <div class="sbar-avatar"><?= strtoupper(substr($_SESSION['user']['nombre'],0,1)) ?></div>
            <div>
                <div class="sbar-user-name"><?= htmlspecialchars($_SESSION['user']['nombre']) ?></div>
                <div class="sbar-user-role"><?= htmlspecialchars($_SESSION['user']['rol']) ?></div>
            </div>
        </div>
        <a href="/logout.php" class="sbar-logout">← Cerrar sesión</a>
    </div>
</aside>


<div class="mob-bar">
    <div style="display:flex;align-items:center;gap:10px">
        <img src="/public/img/logo.png" style="height:28px;width:auto;filter:drop-shadow(0 1px 4px rgba(185,28,28,0.3))" alt="SGA">
        <span style="color:#fff;font-size:.85rem;font-weight:700">SGA Admin</span>
    </div>
    <button onclick="document.getElementById('mob-overlay').style.display='block'" style="color:rgba(255,255,255,.7);background:none;border:none;cursor:pointer">
        <svg style="width:22px;height:22px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>
</div>


<div id="mob-overlay" class="mob-menu" style="display:none" onclick="if(event.target===this)this.style.display='none'">
    <div class="mob-panel">
        <div style="padding:20px 18px 16px;border-bottom:1px solid rgba(255,255,255,0.06)">
            <img src="/public/img/logo.png" style="height:40px;width:auto;filter:drop-shadow(0 1px 4px rgba(185,28,28,0.3));display:block;margin:0 auto 10px" alt="SGA">
            <p style="text-align:center;color:#fff;font-size:.85rem;font-weight:700">SGA Académico</p>
        </div>
        <nav style="padding:12px 10px">
            <a href="/admin/dashboard.php" class="sbar-link <?= $cur==='dashboard.php'?'active':'' ?>">Inicio</a>
            <a href="/admin/solicitudes.php" class="sbar-link <?= $cur==='solicitudes.php'?'active':'' ?>">Solicitudes</a>
            <a href="/admin/reportes.php" class="sbar-link <?= $cur==='reportes.php'?'active':'' ?>">Reportes</a>
            <a href="/admin/estudiantes.php" class="sbar-link <?= $cur==='estudiantes.php'?'active':'' ?>">Estudiantes</a>
            <a href="/admin/administradores.php" class="sbar-link <?= $cur==='administradores.php'?'active':'' ?>">Administradores</a>
        </nav>
        <div style="padding:12px 18px;border-top:1px solid rgba(255,255,255,0.06)">
            <div style="color:#e2e8f0;font-size:.8rem;font-weight:600"><?= htmlspecialchars($_SESSION['user']['nombre']) ?></div>
            <a href="/logout.php" style="display:block;margin-top:8px;padding:7px 12px;background:rgba(185,28,28,0.2);border-radius:8px;color:#fca5a5;font-size:.75rem;text-align:center;text-decoration:none">Cerrar sesión</a>
        </div>
    </div>
</div>


<div class="content-wrap">
