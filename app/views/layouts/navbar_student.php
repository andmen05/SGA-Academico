<?php $current = basename($_SERVER['PHP_SELF']); ?>
<nav class="bg-gradient-to-r from-red-800 to-red-700 text-white shadow-lg">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between h-14">

            <a href="/student/dashboard.php" class="flex items-center gap-3 group">
                <img src="/public/img/logo.png"
                     alt="Logo"
                     class="h-8 w-auto object-contain"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                <div class="w-8 h-8 rounded-lg bg-white/15 items-center justify-center text-sm font-bold backdrop-blur-sm hidden" aria-hidden="true">S</div>
                <div>
                    <div class="text-sm font-bold tracking-wide leading-none group-hover:text-red-100 transition-colors">SGA Académico</div>
                    <div class="text-[10px] text-red-200/80 leading-none mt-0.5 hidden sm:block">Portal Estudiantil</div>
                </div>
            </a>

            <div class="hidden md:flex items-center text-sm gap-1">
                <a href="/student/dashboard.php"
                   class="px-3 py-2 rounded-md transition-colors <?= $current === 'dashboard.php' ? 'bg-white/20 font-semibold' : 'hover:bg-white/10' ?>">
                    Inicio
                </a>
                <a href="/student/nueva-solicitud.php"
                   class="px-3 py-2 rounded-md transition-colors <?= $current === 'nueva-solicitud.php' ? 'bg-white/20 font-semibold' : 'hover:bg-white/10' ?>">
                    Nueva Solicitud
                </a>
                <a href="/student/mis-solicitudes.php"
                   class="px-3 py-2 rounded-md transition-colors <?= $current === 'mis-solicitudes.php' ? 'bg-white/20 font-semibold' : 'hover:bg-white/10' ?>">
                    Mis Solicitudes
                </a>
                <div class="w-px h-5 bg-white/20 mx-2"></div>
                <span class="text-red-200 text-xs mr-2 hidden lg:inline">
                    <?= htmlspecialchars($_SESSION['user']['nombre'] . ' ' . $_SESSION['user']['apellido']) ?>
                </span>
                <a href="/logout.php"
                   class="px-3 py-2 rounded-md hover:bg-white/10 text-red-100 hover:text-white transition-colors">
                    Salir
                </a>
            </div>

            <button onclick="document.getElementById('mobile-menu-student').classList.toggle('hidden')"
                    class="md:hidden p-2 rounded-lg hover:bg-white/10 transition-colors" aria-label="Menu">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>

    <div id="mobile-menu-student" class="hidden md:hidden bg-red-900/90 backdrop-blur-sm border-t border-white/10">
        <div class="px-4 py-2.5 text-xs text-red-300 flex items-center gap-2">
            <div class="w-6 h-6 rounded-full bg-white/15 flex items-center justify-center text-[10px] font-bold"><?= strtoupper(substr($_SESSION['user']['nombre'], 0, 1)) ?></div>
            <?= htmlspecialchars($_SESSION['user']['nombre'] . ' ' . $_SESSION['user']['apellido']) ?>
        </div>
        <a href="/student/dashboard.php"
           class="block px-4 py-2.5 text-sm hover:bg-white/5 transition-colors <?= $current === 'dashboard.php' ? 'font-semibold bg-white/10' : '' ?>">
            Inicio
        </a>
        <a href="/student/nueva-solicitud.php"
           class="block px-4 py-2.5 text-sm hover:bg-white/5 transition-colors <?= $current === 'nueva-solicitud.php' ? 'font-semibold bg-white/10' : '' ?>">
            Nueva Solicitud
        </a>
        <a href="/student/mis-solicitudes.php"
           class="block px-4 py-2.5 text-sm hover:bg-white/5 transition-colors <?= $current === 'mis-solicitudes.php' ? 'font-semibold bg-white/10' : '' ?>">
            Mis Solicitudes
        </a>
        <div class="border-t border-white/10 mt-1">
            <a href="/logout.php"
               class="block px-4 py-2.5 text-sm hover:bg-white/5 text-red-200 transition-colors">
                Cerrar Sesión
            </a>
        </div>
    </div>
</nav>
