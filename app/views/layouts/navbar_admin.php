<?php $current = basename($_SERVER['PHP_SELF']); ?>
<nav class="bg-gradient-to-r from-slate-900 to-slate-800 text-white shadow-lg">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between h-14">

            <a href="/admin/dashboard.php" class="flex items-center gap-3 group">
                <img src="/public/img/logo.png"
                     alt="Logo"
                     class="h-8 w-auto object-contain"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                <div class="w-8 h-8 rounded-lg bg-red-600 items-center justify-center text-sm font-bold hidden" aria-hidden="true">A</div>
                <div>
                    <div class="text-sm font-bold tracking-wide leading-none group-hover:text-slate-200 transition-colors">SGA Admin</div>
                    <div class="text-[10px] text-slate-400 leading-none mt-0.5 hidden sm:block">Panel Administrativo</div>
                </div>
            </a>

            <div class="hidden md:flex items-center text-sm gap-1">
                <a href="/admin/dashboard.php"
                   class="px-3 py-2 rounded-md transition-colors <?= $current === 'dashboard.php' ? 'bg-white/15 font-semibold' : 'hover:bg-white/10' ?>">
                    Inicio
                </a>
                <a href="/admin/solicitudes.php"
                   class="px-3 py-2 rounded-md transition-colors <?= $current === 'solicitudes.php' ? 'bg-white/15 font-semibold' : 'hover:bg-white/10' ?>">
                    Solicitudes
                </a>

                <div class="relative group">
                    <button class="flex items-center gap-1 px-3 py-2 rounded-md transition-colors <?= in_array($current, ['estudiantes.php','administradores.php']) ? 'bg-white/15 font-semibold' : 'hover:bg-white/10' ?>">
                        Gestión
                        <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="absolute left-0 top-full hidden group-hover:block bg-white text-slate-700 shadow-xl rounded-lg min-w-[180px] z-50 py-1 border border-slate-100">
                        <a href="/admin/estudiantes.php"
                           class="block px-4 py-2.5 text-sm hover:bg-slate-50 transition-colors">Estudiantes</a>
                        <a href="/admin/administradores.php"
                           class="block px-4 py-2.5 text-sm hover:bg-slate-50 transition-colors">Administradores</a>
                    </div>
                </div>

                <div class="w-px h-5 bg-white/20 mx-2"></div>
                <span class="text-slate-400 text-xs mr-2 hidden lg:inline">
                    <?= htmlspecialchars($_SESSION['user']['nombre']) ?>
                </span>
                <a href="/logout.php"
                   class="px-3 py-2 rounded-md hover:bg-white/10 text-slate-300 hover:text-white transition-colors">
                    Salir
                </a>
            </div>

            <button onclick="document.getElementById('mobile-menu-admin').classList.toggle('hidden')"
                    class="md:hidden p-2 rounded-lg hover:bg-white/10 transition-colors" aria-label="Menu">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>

    <div id="mobile-menu-admin" class="hidden md:hidden bg-slate-900/95 backdrop-blur-sm border-t border-white/10">
        <div class="px-4 py-2.5 text-xs text-slate-400 flex items-center gap-2">
            <div class="w-6 h-6 rounded-full bg-red-600/80 flex items-center justify-center text-[10px] font-bold"><?= strtoupper(substr($_SESSION['user']['nombre'], 0, 1)) ?></div>
            <?= htmlspecialchars($_SESSION['user']['nombre']) ?> &mdash; <?= htmlspecialchars($_SESSION['user']['rol']) ?>
        </div>
        <a href="/admin/dashboard.php"
           class="block px-4 py-2.5 text-sm hover:bg-white/5 transition-colors <?= $current === 'dashboard.php' ? 'font-semibold bg-white/10' : '' ?>">
            Inicio
        </a>
        <a href="/admin/solicitudes.php"
           class="block px-4 py-2.5 text-sm hover:bg-white/5 transition-colors <?= $current === 'solicitudes.php' ? 'font-semibold bg-white/10' : '' ?>">
            Solicitudes
        </a>
        <a href="/admin/estudiantes.php"
           class="block px-4 py-2.5 text-sm hover:bg-white/5 transition-colors <?= $current === 'estudiantes.php' ? 'font-semibold bg-white/10' : '' ?>">
            Estudiantes
        </a>
        <a href="/admin/administradores.php"
           class="block px-4 py-2.5 text-sm hover:bg-white/5 transition-colors <?= $current === 'administradores.php' ? 'font-semibold bg-white/10' : '' ?>">
            Administradores
        </a>
        <div class="border-t border-white/10 mt-1">
            <a href="/logout.php"
               class="block px-4 py-2.5 text-sm hover:bg-white/5 text-slate-400 transition-colors">
                Cerrar Sesión
            </a>
        </div>
    </div>
</nav>
