<footer class="bg-slate-900 text-slate-400 mt-auto">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 py-6">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <img src="/public/img/logo.png"
                         alt="Logo"
                         class="h-7 w-auto object-contain opacity-90"
                         style="filter:drop-shadow(0 1px 4px rgba(185,28,28,0.3))"
                         onerror="this.style.display='none'">
                    <p class="text-white font-bold tracking-wide text-sm">SGA Académico</p>
                </div>
                <p class="text-xs text-slate-500 leading-relaxed">Sistema de Gestión de Solicitudes Académicas</p>
            </div>
            <div>
                <p class="text-slate-300 text-xs font-semibold uppercase tracking-wider mb-2">Enlaces</p>
                <div class="space-y-1 text-xs">
                    <a href="/student/dashboard.php" class="block hover:text-white transition-colors">Portal Estudiante</a>
                    <a href="/admin/dashboard.php"   class="block hover:text-white transition-colors">Panel Administrativo</a>
                </div>
            </div>
            <div class="text-xs">
                <p class="text-slate-300 font-semibold uppercase tracking-wider mb-2">Contacto</p>
                <p>secretaria@correo.edu</p>
                <p class="mt-1 text-slate-500">Lun — Vie: 8:00 a.m. — 5:00 p.m.</p>
            </div>
        </div>
        <div class="border-t border-slate-800 mt-5 pt-4 text-center text-xs text-slate-600">
            &copy; <?= date('Y') ?> SGA Académico &mdash; Todos los derechos reservados
        </div>
    </div>
</footer>
