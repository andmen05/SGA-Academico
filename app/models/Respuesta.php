<?php

class Respuesta
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getBySolicitud(int $idSolicitud): ?array
    {
        $st = $this->db->prepare(
            "SELECT r.*, a.nombre AS admin_nombre
             FROM RESPUESTA_SOLICITUD r
             JOIN ADMINISTRADOR a ON a.id_admin = r.id_admin
             WHERE r.id_solicitud = ? LIMIT 1"
        );
        $st->execute([$idSolicitud]);
        return $st->fetch() ?: null;
    }

    public function create(array $data): int
    {
        $st = $this->db->prepare(
            "INSERT INTO RESPUESTA_SOLICITUD
                (fecha_respuesta, observacion, estado_final, archivo_respuesta, ruta_archivo_respuesta, id_solicitud, id_admin)
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $st->execute([
            date('Y-m-d'),
            $data['observacion'],
            $data['estado_final'],
            $data['archivo_respuesta']      ?? null,
            $data['ruta_archivo_respuesta'] ?? null,
            $data['id_solicitud'],
            $data['id_admin'],
        ]);
        return (int) $this->db->lastInsertId();
    }

    
    public function deleteBySolicitud(int $idSolicitud): void
    {
        $st = $this->db->prepare("DELETE FROM RESPUESTA_SOLICITUD WHERE id_solicitud = ?");
        $st->execute([$idSolicitud]);
    }
}

