<?php

class Mensaje
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
        $this->ensureTableExists();
    }

    
    private function ensureTableExists(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS MENSAJE_SOLICITUD (
            id_mensaje INT NOT NULL AUTO_INCREMENT,
            id_solicitud INT NOT NULL,
            remitente VARCHAR(50) NOT NULL, -- 'estudiante' o 'admin'
            nombre_remitente VARCHAR(150) NOT NULL,
            mensaje TEXT NOT NULL,
            fecha_envio DATETIME NOT NULL,
            archivo_adjunto VARCHAR(255) DEFAULT NULL,
            ruta_adjunto VARCHAR(500) DEFAULT NULL,
            PRIMARY KEY (id_mensaje),
            FOREIGN KEY (id_solicitud) REFERENCES SOLICITUD(id_solicitud) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        $this->db->exec($sql);
    }

    
    public function getBySolicitud(int $idSolicitud): array
    {
        $st = $this->db->prepare(
            "SELECT * FROM MENSAJE_SOLICITUD 
             WHERE id_solicitud = ? 
             ORDER BY fecha_envio ASC"
        );
        $st->execute([$idSolicitud]);
        return $st->fetchAll();
    }

    
    public function create(array $data): int
    {
        $st = $this->db->prepare(
            "INSERT INTO MENSAJE_SOLICITUD (id_solicitud, remitente, nombre_remitente, mensaje, fecha_envio, archivo_adjunto, ruta_adjunto)
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $st->execute([
            $data['id_solicitud'],
            $data['remitente'],
            $data['nombre_remitente'],
            $data['mensaje'],
            date('Y-m-d H:i:s'),
            $data['archivo_adjunto'] ?? null,
            $data['ruta_adjunto'] ?? null,
        ]);
        return (int) $this->db->lastInsertId();
    }
}
