<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión — SGA Académico</title>
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

        .btn-login {
            background: linear-gradient(135deg, #b91c1c 0%, #7f1d1d 100%);
            transition: opacity 0.2s, transform 0.1s;
        }
        .btn-login:hover  { opacity: 0.92; transform: translateY(-1px); }
        .btn-login:active { transform: translateY(0); }

        
        .hero-grid {
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 40px 40px;
        }
    </style>
</head>
<body class="min-h-screen flex">

    


    <div class="hidden lg:flex lg:w-[52%] hero-panel hero-grid flex-col items-center justify-center relative overflow-hidden">

        
        <div class="absolute top-[-80px] left-[-80px] w-72 h-72 rounded-full bg-red-700/20 blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-[-60px] right-[-60px] w-64 h-64 rounded-full bg-red-900/30 blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col items-center text-center px-12">
            <img src="/public/img/logo.png"
                 alt="Logo SGA Académico"
                 class="logo-glow w-52 xl:w-64 select-none">

            <div class="mt-8 space-y-2">
                <h2 class="text-white text-2xl xl:text-3xl font-bold tracking-tight">SGA Académico</h2>
                <p class="text-red-300/70 text-sm xl:text-base font-light leading-relaxed max-w-xs">
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

    


    <div class="w-full lg:w-[48%] flex flex-col items-center justify-center bg-zinc-50 px-6 sm:px-12 py-12 min-h-screen">

        
        <div class="flex flex-col items-center mb-10 lg:hidden">
            <img src="/public/img/logo.png"
                 alt="Logo SGA Académico"
                 class="w-28 sm:w-36 drop-shadow-md">
            <p class="mt-3 text-zinc-400 text-xs tracking-wide">Sistema de Gestión de Solicitudes Académicas</p>
        </div>

        <div class="w-full max-w-sm">

            
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-zinc-800 tracking-tight">Bienvenido</h1>
                <p class="text-zinc-400 text-sm mt-1">Ingresa con tus credenciales institucionales</p>
            </div>

            
            <?php if ($error): ?>
                <div class="mb-5 flex items-start gap-3 px-4 py-3 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl">
                    <svg class="w-4 h-4 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9V6a1 1 0 112 0v3a1 1 0 11-2 0zm1 5a1.25 1.25 0 110-2.5 1.25 1.25 0 010 2.5z" clip-rule="evenodd"/>
                    </svg>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            
            <form method="POST" action="/" class="space-y-5">

                <div>
                    <label class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-2" for="correo">
                        Correo electrónico
                    </label>
                    <input id="correo" name="correo" type="email" required
                           placeholder="usuario@correo.edu"
                           value="<?= htmlspecialchars($_POST['correo'] ?? '') ?>"
                           class="input-field w-full bg-white border border-zinc-200 rounded-xl px-4 py-3 text-sm text-zinc-800 placeholder-zinc-300">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-2" for="password">
                        Contraseña
                    </label>
                    <input id="password" name="password" type="password" required
                           placeholder="••••••••"
                           class="input-field w-full bg-white border border-zinc-200 rounded-xl px-4 py-3 text-sm text-zinc-800 placeholder-zinc-300">
                </div>

                <button type="submit"
                        class="btn-login w-full text-white font-semibold py-3 rounded-xl text-sm mt-1 shadow-lg shadow-red-900/20">
                    Ingresar al sistema
                </button>
            </form>

            
            <p class="mt-6 text-center text-xs text-zinc-400">
                ¿No tienes cuenta?
                <a href="/register.php" class="text-red-700 hover:text-red-800 font-semibold transition-colors ml-1">Regístrate aquí</a>
            </p>
        </div>

        
        <p class="mt-12 text-[11px] text-zinc-300 lg:hidden">© <?= date('Y') ?> SGA Académico</p>
    </div>

</body>
</html>
