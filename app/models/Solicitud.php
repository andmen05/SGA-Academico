<?php

class Solicitud
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    
    public function getAll(array $filtros = []): array
    {
        $sql = "SELECT s.*, 
                       e.nombre      AS est_nombre,
                       e.apellido    AS est_apellido,
                       e.documento   AS est_documento,
                       e.correo      AS est_correo,
                       e.telefono    AS est_telefono,
                       e.semestre    AS est_semestre,
                       e.programa    AS est_programa,
                       t.nombre_tipo AS tipo_nombre
                FROM SOLICITUD s
                JOIN ESTUDIANTE     e ON e.id_estudiante     = s.id_estudiante
                JOIN TIPO_SOLICITUD t ON t.id_tipo_solicitud = s.id_tipo_solicitud
                WHERE 1=1";
        $params = [];

        if (!empty($filtros['id_tipo_solicitud'])) {
            $sql .= " AND s.id_tipo_solicitud = ?";
            $params[] = $filtros['id_tipo_solicitud'];
        }
        if (!empty($filtros['estado'])) {
            $sql .= " AND s.estado = ?";
            $params[] = $filtros['estado'];
        }
        if (!empty($filtros['id_estudiante'])) {
            $sql .= " AND s.id_estudiante = ?";
            $params[] = $filtros['id_estudiante'];
        }

        $sql .= " ORDER BY s.id_solicitud DESC";

        $st = $this->db->prepare($sql);
        $st->execute($params);
        return $st->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $st = $this->db->prepare(
            "SELECT s.*,
                    e.nombre      AS est_nombre,
                    e.apellido    AS est_apellido,
                    e.documento   AS est_documento,
                    e.correo      AS est_correo,
                    e.telefono    AS est_telefono,
                    e.semestre    AS est_semestre,
                    e.programa    AS est_programa,
                    t.nombre_tipo AS tipo_nombre
             FROM SOLICITUD s
             JOIN ESTUDIANTE     e ON e.id_estudiante     = s.id_estudiante
             JOIN TIPO_SOLICITUD t ON t.id_tipo_solicitud = s.id_tipo_solicitud
             WHERE s.id_solicitud = ? LIMIT 1"
        );
        $st->execute([$id]);
        return $st->fetch() ?: null;
    }

    public function getByEstudiante(int $idEstudiante): array
    {
        return $this->getAll(['id_estudiante' => $idEstudiante]);
    }

    public function create(array $data): int
    {
        $st = $this->db->prepare(
            "INSERT INTO SOLICITUD (fecha, estado, prioridad, descripcion, id_estudiante, id_tipo_solicitud)
             VALUES (?, 'Pendiente', ?, ?, ?, ?)"
        );
        $st->execute([
            date('Y-m-d'),
            $data['prioridad'] ?? 'Media',
            $data['descripcion'],
            $data['id_estudiante'],
            $data['id_tipo_solicitud'],
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function updateEstado(int $id, string $estado): void
    {
        $st = $this->db->prepare(
            "UPDATE SOLICITUD SET estado = ? WHERE id_solicitud = ?"
        );
        $st->execute([$estado, $id]);
    }

    
    public function countByEstado(): array
    {
        $rows = $this->db->query(
            "SELECT estado, COUNT(*) AS total FROM SOLICITUD GROUP BY estado"
        )->fetchAll();

        $counts = ['Pendiente' => 0, 'En revisión' => 0, 'Aprobada' => 0, 'Rechazada' => 0, '_total' => 0];
        foreach ($rows as $r) {
            $counts[$r['estado']] = (int) $r['total'];
            $counts['_total']    += (int) $r['total'];
        }
        return $counts;
    }

    
    public function topTipos(int $limit = 5): array
    {
        $st = $this->db->prepare(
            "SELECT t.nombre_tipo, COUNT(*) AS total
             FROM SOLICITUD s
             JOIN TIPO_SOLICITUD t ON t.id_tipo_solicitud = s.id_tipo_solicitud
             GROUP BY s.id_tipo_solicitud
             ORDER BY total DESC
             LIMIT ?"
        );
        $st->execute([$limit]);
        return $st->fetchAll();
    }

    
    public function pendientesRecientes(int $limit = 6): array
    {
        $st = $this->db->prepare(
            "SELECT s.*,
                    e.nombre      AS est_nombre,
                    e.apellido    AS est_apellido,
                    t.nombre_tipo AS tipo_nombre
             FROM SOLICITUD s
             JOIN ESTUDIANTE     e ON e.id_estudiante     = s.id_estudiante
             JOIN TIPO_SOLICITUD t ON t.id_tipo_solicitud = s.id_tipo_solicitud
             WHERE s.estado = 'Pendiente'
             ORDER BY s.id_solicitud DESC
             LIMIT ?"
        );
        $st->execute([$limit]);
        return $st->fetchAll();
    }

    
    public function getReportData(array $filtros = []): array
    {
        $sql = "SELECT s.id_solicitud,
                       s.fecha,
                       s.prioridad,
                       s.estado,
                       s.descripcion,
                       e.nombre AS est_nombre,
                       e.apellido AS est_apellido,
                       e.documento AS est_documento,
                       e.correo AS est_correo,
                       e.programa AS est_programa,
                       e.semestre AS est_semestre,
                       t.nombre_tipo AS tipo_nombre,
                       r.fecha_respuesta,
                       r.observacion AS resp_observacion,
                       a.nombre AS admin_nombre,
                       DATEDIFF(r.fecha_respuesta, s.fecha) AS dias_respuesta
                FROM SOLICITUD s
                JOIN ESTUDIANTE e ON s.id_estudiante = e.id_estudiante
                JOIN TIPO_SOLICITUD t ON s.id_tipo_solicitud = t.id_tipo_solicitud
                LEFT JOIN RESPUESTA_SOLICITUD r ON s.id_solicitud = r.id_solicitud
                LEFT JOIN ADMINISTRADOR a ON r.id_admin = a.id_admin
                WHERE 1=1";
        $params = [];

        if (!empty($filtros['fecha_inicio'])) {
            $sql .= " AND s.fecha >= ?";
            $params[] = $filtros['fecha_inicio'];
        }
        if (!empty($filtros['fecha_fin'])) {
            $sql .= " AND s.fecha <= ?";
            $params[] = $filtros['fecha_fin'];
        }
        if (!empty($filtros['id_tipo_solicitud'])) {
            $sql .= " AND s.id_tipo_solicitud = ?";
            $params[] = $filtros['id_tipo_solicitud'];
        }
        if (!empty($filtros['estado'])) {
            $sql .= " AND s.estado = ?";
            $params[] = $filtros['estado'];
        }
        if (!empty($filtros['prioridad'])) {
            $sql .= " AND s.prioridad = ?";
            $params[] = $filtros['prioridad'];
        }
        if (!empty($filtros['programa'])) {
            $sql .= " AND e.programa = ?";
            $params[] = $filtros['programa'];
        }

        $sql .= " ORDER BY s.id_solicitud DESC";

        $st = $this->db->prepare($sql);
        $st->execute($params);
        return $st->fetchAll();
    }

    
    public function getAverageResolutionTime(array $filtros = []): ?float
    {
        $sql = "SELECT AVG(DATEDIFF(r.fecha_respuesta, s.fecha)) AS avg_days
                FROM SOLICITUD s
                JOIN RESPUESTA_SOLICITUD r ON s.id_solicitud = r.id_solicitud
                JOIN ESTUDIANTE e ON s.id_estudiante = e.id_estudiante
                WHERE 1=1";
        $params = [];

        if (!empty($filtros['fecha_inicio'])) {
            $sql .= " AND s.fecha >= ?";
            $params[] = $filtros['fecha_inicio'];
        }
        if (!empty($filtros['fecha_fin'])) {
            $sql .= " AND s.fecha <= ?";
            $params[] = $filtros['fecha_fin'];
        }
        if (!empty($filtros['id_tipo_solicitud'])) {
            $sql .= " AND s.id_tipo_solicitud = ?";
            $params[] = $filtros['id_tipo_solicitud'];
        }
        if (!empty($filtros['estado'])) {
            $sql .= " AND s.estado = ?";
            $params[] = $filtros['estado'];
        }
        if (!empty($filtros['prioridad'])) {
            $sql .= " AND s.prioridad = ?";
            $params[] = $filtros['prioridad'];
        }
        if (!empty($filtros['programa'])) {
            $sql .= " AND e.programa = ?";
            $params[] = $filtros['programa'];
        }

        $st = $this->db->prepare($sql);
        $st->execute($params);
        $res = $st->fetch();
        return $res['avg_days'] !== null ? round((float)$res['avg_days'], 1) : null;
    }

    
    public function getDistinctPrograms(): array
    {
        $rows = $this->db->query(
            "SELECT DISTINCT programa 
             FROM ESTUDIANTE 
             WHERE programa IS NOT NULL AND programa != '' 
             ORDER BY programa"
        )->fetchAll();
        return array_column($rows, 'programa');
    }

    
    public function updateRespuestaEstudiante(int $id, string $descripcion, string $estado): void
    {
        $st = $this->db->prepare(
            "UPDATE SOLICITUD SET descripcion = ?, estado = ? WHERE id_solicitud = ?"
        );
        $st->execute([$descripcion, $estado, $id]);
    }
}
