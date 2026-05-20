<?php

class Estudiante
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function findByCorreo(string $correo): ?array
    {
        $st = $this->db->prepare(
            "SELECT * FROM ESTUDIANTE WHERE correo = ? LIMIT 1"
        );
        $st->execute([$correo]);
        return $st->fetch() ?: null;
    }

    public function findById(int $id): ?array
    {
        $st = $this->db->prepare(
            "SELECT * FROM ESTUDIANTE WHERE id_estudiante = ? LIMIT 1"
        );
        $st->execute([$id]);
        return $st->fetch() ?: null;
    }

    public function getAll(): array
    {
        return $this->db
            ->query("SELECT * FROM ESTUDIANTE ORDER BY apellido, nombre")
            ->fetchAll();
    }

    



    public function search(array $filtros = []): array
    {
        $where  = [];
        $params = [];

        if (!empty($filtros['q'])) {
            $like = '%' . $filtros['q'] . '%';
            $where[]  = "(nombre LIKE ? OR apellido LIKE ? OR documento LIKE ? OR correo LIKE ?)";
            $params[] = $like;
            $params[] = $like;
            $params[] = $like;
            $params[] = $like;
        }

        if (!empty($filtros['programa'])) {
            $where[]  = "programa LIKE ?";
            $params[] = '%' . $filtros['programa'] . '%';
        }

        if (!empty($filtros['semestre'])) {
            $where[]  = "semestre = ?";
            $params[] = (int) $filtros['semestre'];
        }

        $sql = "SELECT * FROM ESTUDIANTE";
        if ($where) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        $sql .= ' ORDER BY apellido, nombre';

        $st = $this->db->prepare($sql);
        $st->execute($params);
        return $st->fetchAll();
    }

    public function count(): int
    {
        return (int) $this->db->query("SELECT COUNT(*) FROM ESTUDIANTE")->fetchColumn();
    }

    public function correoExiste(string $correo): bool
    {
        $st = $this->db->prepare("SELECT COUNT(*) FROM ESTUDIANTE WHERE correo = ?");
        $st->execute([$correo]);
        return (int) $st->fetchColumn() > 0;
    }

    public function documentoExiste(string $doc): bool
    {
        $st = $this->db->prepare("SELECT COUNT(*) FROM ESTUDIANTE WHERE documento = ?");
        $st->execute([$doc]);
        return (int) $st->fetchColumn() > 0;
    }

    public function create(array $data): int
    {
        $st = $this->db->prepare(
            "INSERT INTO ESTUDIANTE (nombre, apellido, documento, correo, password, telefono, programa, semestre)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $st->execute([
            $data['nombre'],
            $data['apellido'],
            $data['documento'],
            $data['correo'],
            password_hash($data['password'], PASSWORD_BCRYPT),
            $data['telefono'] ?? null,
            $data['programa'] ?? null,
            $data['semestre'] ?? 1,
        ]);
        return (int) $this->db->lastInsertId();
    }
}
