<?php

class Administrador
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function findByCorreo(string $correo): ?array
    {
        $st = $this->db->prepare(
            "SELECT * FROM ADMINISTRADOR WHERE correo = ? LIMIT 1"
        );
        $st->execute([$correo]);
        return $st->fetch() ?: null;
    }

    public function findById(int $id): ?array
    {
        $st = $this->db->prepare(
            "SELECT * FROM ADMINISTRADOR WHERE id_admin = ? LIMIT 1"
        );
        $st->execute([$id]);
        return $st->fetch() ?: null;
    }

    public function getAll(): array
    {
        return $this->db
            ->query("SELECT * FROM ADMINISTRADOR ORDER BY nombre")
            ->fetchAll();
    }

    



    public function search(array $filtros = []): array
    {
        $where  = [];
        $params = [];

        if (!empty($filtros['q'])) {
            $like = '%' . $filtros['q'] . '%';
            $where[]  = "(nombre LIKE ? OR correo LIKE ?)";
            $params[] = $like;
            $params[] = $like;
        }

        if (!empty($filtros['rol'])) {
            $where[]  = "rol = ?";
            $params[] = $filtros['rol'];
        }

        $sql = "SELECT * FROM ADMINISTRADOR";
        if ($where) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        $sql .= ' ORDER BY nombre';

        $st = $this->db->prepare($sql);
        $st->execute($params);
        return $st->fetchAll();
    }

    
    public function getRoles(): array
    {
        return $this->db
            ->query("SELECT DISTINCT rol FROM ADMINISTRADOR ORDER BY rol")
            ->fetchAll(PDO::FETCH_COLUMN);
    }
}
