<?php

class TipoSolicitud
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getAll(): array
    {
        return $this->db
            ->query("SELECT * FROM TIPO_SOLICITUD ORDER BY id_tipo_solicitud")
            ->fetchAll();
    }

    
    public function getAllIndexed(): array
    {
        $rows = $this->getAll();
        $out  = [];
        foreach ($rows as $r) {
            $out[$r['id_tipo_solicitud']] = $r['nombre_tipo'];
        }
        return $out;
    }

    public function findById(int $id): ?array
    {
        $st = $this->db->prepare(
            "SELECT * FROM TIPO_SOLICITUD WHERE id_tipo_solicitud = ? LIMIT 1"
        );
        $st->execute([$id]);
        return $st->fetch() ?: null;
    }
}
