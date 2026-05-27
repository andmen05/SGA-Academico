# SGA Académico — Sistema de Gestión de Solicitudes Académicas

Este es un sistema web robusto e intuitivo diseñado para la radicación, seguimiento y gestión de solicitudes académicas universitarias. Permite a los estudiantes realizar trámites digitales con soportes adjuntos y comunicarse por mensajería interna con la administración, mientras que proporciona a los administradores herramientas avanzadas de resolución de casos, control de usuarios y análisis de datos en tiempo real mediante reportes gráficos.

---

## 🚀 Características Principales

### 👨‍🎓 Módulo de Estudiantes
*   **Registro y Autenticación Segura**: Validación de unicidad de documento de identidad y correo electrónico institucional.
*   **Radicación de Trámites**: Formulario interactivo para radicar solicitudes académicas especificando:
    *   Tipo de solicitud (Cancelaciones, traslados, certificados, etc.).
    *   Prioridad (Alta, Media, Baja).
    *   Descripción detallada y carga de documentos de soporte (PDF, imágenes, etc.).
*   **Bandeja de Seguimiento**: Historial de solicitudes con estados dinámicos (*Pendiente*, *En revisión*, *Aprobada*, *Rechazada*).
*   **Mensajería Interna**: Chat bidireccional en cada radicado para recibir retroalimentación directa y adjuntar nuevos soportes si son solicitados.

### 👮‍♂️ Módulo de Administradores
*   **Panel de Control (Dashboard)**: Métricas clave (KPIs) con contadores automáticos de solicitudes según su estado.
*   **Gestión de Casos**: Bandeja de solicitudes con filtros. Permite actualizar el estado de los trámites y emitir respuestas oficiales adjuntando resoluciones o documentos.
*   **Reportes Analíticos Gráficos**:
    *   Integración con **Chart.js** para visualizaciones en tiempo real.
    *   Gráficas de distribución por Estado, Prioridad, Programa Académico e Historial de Tipos de solicitudes frecuentes.
    *   Filtros dinámicos por fechas y categorías.
    *   **Exportación a CSV**: Descarga de bases de datos consolidadas de las solicitudes filtradas para análisis en Microsoft Excel.
*   **Gestión de Usuarios**: Administración de listas de estudiantes registrados y asignación de cuentas para otros administradores/coordinadores.

---

## 🛠️ Tecnologías Utilizadas

*   **Backend**: PHP 8.x (Programación Orientada a Objetos, Arquitectura limpia **MVC** sin dependencias externas).
*   **Base de Datos**: MySQL / MariaDB (Motor Relacional).
*   **Frontend**: HTML5, Tailwind CSS (Diseño responsive y moderno) y Google Fonts (Inter).
*   **Librerías**: Chart.js para visualización de datos de reportería.
*   **Conectividad**: PDO (PHP Data Objects) con consultas preparadas contra inyección SQL.

---

## 📂 Estructura del Proyecto

```text
SGA-Academico/
├── app/                  # Directorio principal del MVC
│   ├── controllers/      # Lógica de flujo (AuthController, AdminController, StudentController)
│   ├── models/           # Gestión y consultas a base de datos (Estudiante, Solicitud, etc.)
│   └── views/            # Vistas del frontend organizadas por actor
│       ├── admin/        # Vistas del panel administrativo e informes
│       ├── auth/         # Vistas de acceso y registro de estudiantes
│       ├── layouts/      # Plantillas reutilizables (Navegación, pie de página, sidebars)
│       └── student/      # Vistas del panel del estudiante
├── config/               # Configuraciones globales
│   ├── app.php           # Configuración general, sesiones y autoloading
│   ├── database.php.example # Plantilla de conexión a base de datos (copiar como database.php)
│   └── database.php      # Parámetros de conexión PDO (ignorado en Git)
├── database/             # Respaldos de estructura de datos
│   └── academico.sql     # Script SQL para montar la base de datos
├── public/               # Recursos estáticos (Logos, imágenes de la interfaz)
├── uploads/              # Carpeta de almacenamiento para archivos cargados
├── index.php             # Enrutador principal de la aplicación
├── router.php            # Enrutamiento para el servidor integrado de desarrollo PHP
└── README.md             # Documentación del sistema
```

---

## ⚙️ Requisitos de Instalación

Para ejecutar este proyecto de forma local, asegúrate de contar con:
1.  **PHP >= 8.0** con la extensión `pdo_mysql` habilitada en tu archivo `php.ini`.
2.  Un gestor de base de datos **MySQL / MariaDB** (puedes usar XAMPP, Laragon, WampServer o Docker).
3.  Servidor Web Apache o usar el servidor de desarrollo integrado de PHP.

---

## 🚀 Pasos para la Configuración Local

### 1. Clonar el repositorio
Descarga el código en tu máquina local:
```bash
git clone <url-de-tu-repositorio>
cd SGA-Academico
```

### 2. Configurar la Base de Datos
1.  Abre tu gestor de base de datos MySQL (por ejemplo phpMyAdmin).
2.  Crea una nueva base de datos llamada `academico`.
3.  Importa el script SQL ubicado en `database/academico.sql`.

### 3. Crear el Administrador Inicial
Dado que el registro en línea está diseñado únicamente para estudiantes, es necesario insertar al primer administrador manualmente en la base de datos. Ejecuta la siguiente consulta SQL en tu base de datos `academico`:

```sql
INSERT INTO `administrador` (`nombre`, `correo`, `password`, `rol`) VALUES 
('Administrador Principal', 'admin@sga.edu.co', '$2y$10$ZzeemEVdxJzdewpISGs3q.rwuOYLvyIw/E5d5rDRhmqogYsO2JVla', 'Coordinador Académico');
```
*   **Correo**: `admin@sga.edu.co`
*   **Contraseña**: `admin123` *(Esta consulta ya incluye la contraseña encriptada correctamente con `bcrypt`)*.

### 4. Configurar Parámetros de Conexión
El archivo de configuración real `config/database.php` está ignorado en Git para proteger tus credenciales locales de base de datos. Para configurarlo:

1. Crea una copia del archivo plantilla `config/database.php.example` y asígnale el nombre `config/database.php`.
2. Edita el archivo [config/database.php](file:///c:/Users/carlo/Escritorio/SGA-Academico/config/database.php) si tus credenciales de MySQL (servidor, puerto, usuario o contraseña) son diferentes a las predeterminadas:

```php
define('DB_HOST',    'localhost');
define('DB_PORT',    '3306');
define('DB_NAME',    'academico');
define('DB_USER',    'root');
define('DB_PASS',    ''); // Coloca tu contraseña de MySQL aquí
```

### 5. Iniciar la Aplicación
Puedes arrancar la aplicación de dos maneras:

*   **Opción A: Servidor integrado de PHP** (Recomendado)
    Abre una terminal en la raíz del proyecto y ejecuta:
    ```bash
    php -S localhost:8000 router.php
    ```
    Luego ingresa a tu navegador en: [http://localhost:8000](http://localhost:8000)

*   **Opción B: Servidores Locales (XAMPP / Laragon)**
    Copia la carpeta del proyecto en el directorio correspondiente (`htdocs` o `www`) e ingresa mediante el alias local configurado.

---

## 🔄 Flujo de Navegación del Sistema

1.  **Ingreso general (`/`)**: Los estudiantes y administradores inician sesión en el mismo formulario. El sistema valida el correo y los redirige automáticamente a su respectivo panel de control según su rol.
2.  **Registro de estudiantes (`/register.php`)**: Formulario para la creación de perfiles estudiantiles. Requiere ingresar programa académico y semestre en curso.
3.  **Flujo de Solicitud**:
    *   El estudiante crea la solicitud.
    *   La solicitud aparece en la bandeja de entrada del administrador con estado `Pendiente`.
    *   Al ser revisada, el administrador puede cambiarla a `En revisión`, enviar preguntas a través del chat interno de la solicitud, o resolverla finalmente marcándola como `Aprobada` o `Rechazada` (adjuntando su debido soporte de respuesta).
