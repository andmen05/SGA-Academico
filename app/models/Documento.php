<?php

class Documento
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getBySolicitud(int $idSolicitud): array
    {
        $st = $this->db->prepare(
            "SELECT * FROM DOCUMENTO WHERE id_solicitud = ?"
        );
        $st->execute([$idSolicitud]);
        return $st->fetchAll();
    }

    public function create(array $data): int
    {
        $st = $this->db->prepare(
            "INSERT INTO DOCUMENTO (nombre_archivo, ruta, tipo, id_solicitud)
             VALUES (?, ?, ?, ?)"
        );
        $st->execute([
            $data['nombre_archivo'],
            $data['ruta'],
            $data['tipo'],
            $data['id_solicitud'],
        ]);
        return (int) $this->db->lastInsertId();
    }
}
