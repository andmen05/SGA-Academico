<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Estudiante — SGA Académico</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }

        .hero-panel {
            background: radial-gradient(ellipse at 30% 50%, #7f1d1d 0%, #450a0a 55%, #1a0404 100%);
        }

        .logo-glow {
            filter: drop-shadow(0 0 40px rgba(239,68,68,0.35));
            animation: float 5s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50%       { transform: translateY(-10px); }
        }

        .input-field {
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .input-field:focus {
            outline: none;
            border-color: #b91c1c;
            box-shadow: 0 0 0 3px rgba(185,28,28,0.12);
        }

        .btn-register {
            background: linear-gradient(135deg, #b91c1c 0%, #7f1d1d 100%);
            transition: opacity 0.2s, transform 0.1s;
        }
        .btn-register:hover  { opacity: 0.92; transform: translateY(-1px); }
        .btn-register:active { transform: translateY(0); }

        
        .hero-grid {
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 40px 40px;
        }
    </style>
</head>
<body class="min-h-screen flex">

    


    <div class="hidden lg:flex lg:w-[35%] hero-panel hero-grid flex-col items-center justify-center relative overflow-hidden">

        
        <div class="absolute top-[-80px] left-[-80px] w-72 h-72 rounded-full bg-red-700/20 blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-[-60px] right-[-60px] w-64 h-64 rounded-full bg-red-900/30 blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col items-center text-center px-8">
            <img src="/public/img/logo.png"
                 alt="Logo SGA Académico"
                 class="logo-glow w-44 xl:w-52 select-none">

            <div class="mt-8 space-y-2">
                <h2 class="text-white text-xl xl:text-2xl font-bold tracking-tight">SGA Académico</h2>
                <p class="text-red-300/70 text-xs xl:text-sm font-light leading-relaxed max-w-xs">
                    Sistema de Gestión de<br>Solicitudes Académicas
                </p>
            </div>

            
            <div class="mt-10 flex items-center gap-3">
                <div class="h-px w-12 bg-red-700/50"></div>
                <div class="w-1.5 h-1.5 rounded-full bg-red-500/60"></div>
                <div class="h-px w-12 bg-red-700/50"></div>
            </div>
        </div>

        
        <p class="absolute bottom-6 text-red-900/60 text-[11px] select-none">
            © <?= date('Y') ?> SGA Académico
        </p>
    </div>

    


    <div class="w-full lg:w-[65%] flex flex-col items-center justify-center bg-zinc-50 px-6 sm:px-12 md:px-16 py-10 min-h-screen">

        
        <div class="flex flex-col items-center mb-6 lg:hidden">
            <img src="/public/img/logo.png"
                 alt="Logo SGA Académico"
                 class="w-24 sm:w-28 drop-shadow-md">
            <p class="mt-2 text-zinc-400 text-[11px] tracking-wide">Sistema de Gestión de Solicitudes Académicas</p>
        </div>

        <div class="w-full max-w-xl">

            
            <div class="mb-6 text-center lg:text-left">
                <h1 class="text-2xl font-bold text-zinc-800 tracking-tight">Registro de Estudiante</h1>
                <p class="text-zinc-400 text-sm mt-1">Crea tu cuenta para acceder al portal académico</p>
            </div>

            
            <?php if (!empty($errores)): ?>
                <div class="mb-5 flex flex-col gap-1.5 px-4 py-3 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl">
                    <div class="flex items-center gap-2 font-semibold">
                        <svg class="w-4 h-4 shrink-0 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9V6a1 1 0 112 0v3a1 1 0 11-2 0zm1 5a1.25 1.25 0 110-2.5 1.25 1.25 0 010 2.5z" clip-rule="evenodd"/>
                        </svg>
                        Por favor corrija los siguientes errores:
                    </div>
                    <ul class="list-disc list-inside pl-1 space-y-0.5 text-xs text-red-600/90">
                        <?php foreach ($errores as $e): ?>
                            <li><?= htmlspecialchars($e) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            
            <form method="POST" action="/register.php" class="space-y-4">

                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-1.5" for="nombre">
                            Nombre <span class="text-red-500">*</span>
                        </label>
                        <input id="nombre" name="nombre" type="text" required
                               placeholder="Ej: Carlos"
                               value="<?= htmlspecialchars($post['nombre'] ?? '') ?>"
                               class="input-field w-full bg-white border border-zinc-200 rounded-xl px-4 py-2.5 text-sm text-zinc-800 placeholder-zinc-300">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-1.5" for="apellido">
                            Apellido <span class="text-red-500">*</span>
                        </label>
                        <input id="apellido" name="apellido" type="text" required
                               placeholder="Ej: Gómez"
                               value="<?= htmlspecialchars($post['apellido'] ?? '') ?>"
                               class="input-field w-full bg-white border border-zinc-200 rounded-xl px-4 py-2.5 text-sm text-zinc-800 placeholder-zinc-300">
                    </div>
                </div>

                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-1.5" for="documento">
                            Número de Documento <span class="text-red-500">*</span>
                        </label>
                        <input id="documento" name="documento" type="text" required
                               placeholder="Ej: 1098765432"
                               value="<?= htmlspecialchars($post['documento'] ?? '') ?>"
                               class="input-field w-full bg-white border border-zinc-200 rounded-xl px-4 py-2.5 text-sm text-zinc-800 placeholder-zinc-300">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-1.5" for="telefono">
                            Teléfono
                        </label>
                        <input id="telefono" name="telefono" type="tel"
                               placeholder="Ej: 3001234567"
                               value="<?= htmlspecialchars($post['telefono'] ?? '') ?>"
                               class="input-field w-full bg-white border border-zinc-200 rounded-xl px-4 py-2.5 text-sm text-zinc-800 placeholder-zinc-300">
                    </div>
                </div>

                
                <div>
                    <label class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-1.5" for="correo">
                        Correo electrónico <span class="text-red-500">*</span>
                    </label>
                    <input id="correo" name="correo" type="email" required
                           placeholder="usuario@correo.edu"
                           value="<?= htmlspecialchars($post['correo'] ?? '') ?>"
                           class="input-field w-full bg-white border border-zinc-200 rounded-xl px-4 py-2.5 text-sm text-zinc-800 placeholder-zinc-300">
                </div>

                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-1.5" for="programa">
                            Programa Académico <span class="text-red-500">*</span>
                        </label>
                        <input id="programa" name="programa" type="text" required
                               placeholder="Ej: Ingeniería de Software"
                               value="<?= htmlspecialchars($post['programa'] ?? '') ?>"
                               class="input-field w-full bg-white border border-zinc-200 rounded-xl px-4 py-2.5 text-sm text-zinc-800 placeholder-zinc-300">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-1.5" for="semestre">
                            Semestre <span class="text-red-500">*</span>
                        </label>
                        <input id="semestre" name="semestre" type="number" min="1" max="12" required
                               placeholder="1-12"
                               value="<?= htmlspecialchars($post['semestre'] ?? '') ?>"
                               class="input-field w-full bg-white border border-zinc-200 rounded-xl px-4 py-2.5 text-sm text-zinc-800 placeholder-zinc-300">
                    </div>
                </div>

                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-zinc-100">
                    <div>
                        <label class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-1.5" for="password">
                            Contraseña <span class="text-red-500">*</span>
                        </label>
                        <input id="password" name="password" type="password" required
                               placeholder="Mínimo 6 caracteres"
                               class="input-field w-full bg-white border border-zinc-200 rounded-xl px-4 py-2.5 text-sm text-zinc-800 placeholder-zinc-300">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-1.5" for="password_confirm">
                            Confirmar Contraseña <span class="text-red-500">*</span>
                        </label>
                        <input id="password_confirm" name="password_confirm" type="password" required
                               placeholder="Repite tu contraseña"
                               class="input-field w-full bg-white border border-zinc-200 rounded-xl px-4 py-2.5 text-sm text-zinc-800 placeholder-zinc-300">
                    </div>
                </div>

                
                <div class="flex flex-col sm:flex-row gap-3 pt-3">
                    <button type="submit"
                            class="btn-register flex-1 text-white font-semibold py-3 rounded-xl text-sm shadow-lg shadow-red-900/20">
                        Crear Cuenta
                    </button>
                    <a href="/"
                       class="flex-1 text-center border border-zinc-200 bg-white hover:bg-zinc-100 text-zinc-700 font-semibold py-3 rounded-xl text-sm transition-colors">
                        Ya tengo cuenta
                    </a>
                </div>
            </form>

            <p class="text-center text-xs text-zinc-400 mt-8">
                &copy; <?= date('Y') ?> SGA Académico — Todos los derechos reservados
            </p>
        </div>
    </div>

</body>
</html>
