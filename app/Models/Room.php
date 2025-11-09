<?php
require_once __DIR__ . '/../../core/Model.php';

class Room extends Model
{
    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM Sale");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function add($naziv, $lokacija, $kapacitet, $tv, $projektor, $pametna_tabla, $kamera, $mikrofon, $status)
    {
        $stmt = $this->db->prepare("
            INSERT INTO Sale (Naziv, Lokacija, Kapacitet, TV, Projektor, PametnaTabla, Kamera, Mikrofon, Status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("ssiiiiiis", $naziv, $lokacija, $kapacitet, $tv, $projektor, $pametna_tabla, $kamera, $mikrofon, $status);
        $stmt->execute();
    }

    public function getPaginated($limit, $offset) {
    $stmt = $this->db->prepare("SELECT * FROM sale ORDER BY id DESC LIMIT ? OFFSET ?");
    $stmt->bind_param("ii", $limit, $offset);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
   }

    public function countAll() {
    $result = $this->db->query("SELECT COUNT(*) AS total FROM sale");
    return $result->fetch_assoc()['total'];
    }

public function getFiltered($limit, $offset, $filters = []) {
    $query = "SELECT * FROM sale WHERE 1=1";
    $params = [];
    $types = "";

    if (!empty($filters['lokacija'])) {
        $query .= " AND Lokacija LIKE ?";
        $params[] = "%" . $filters['lokacija'] . "%";
        $types .= "s";
    }
    if (!empty($filters['status'])) {
        $query .= " AND Status = ?";
        $params[] = $filters['status'];
        $types .= "s";
    }
    if (isset($filters['tv']) && $filters['tv'] !== '') {
        $query .= " AND TV = ?";
        $params[] = (int)$filters['tv'];
        $types .= "i";
    }

    $query .= " ORDER BY id DESC LIMIT ? OFFSET ?";
    $params[] = $limit;
    $params[] = $offset;
    $types .= "ii";

    $stmt = $this->db->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

public function getById($id) {
    $stmt = $this->db->prepare("SELECT * FROM sale WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

public function update($id, $naziv, $lokacija, $kapacitet, $status) {
    $stmt = $this->db->prepare("UPDATE sale SET naziv = ?, Lokacija = ?, kapacitet = ?, Status = ? WHERE id = ?");
    $stmt->bind_param("ssisi", $naziv, $lokacija, $kapacitet, $status, $id);
    return $stmt->execute();
}

public function delete($id) {
    $stmt = $this->db->prepare("DELETE FROM sale WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

public function isUsed($id) {
    $stmt = $this->db->prepare("SELECT COUNT(*) AS broj FROM rezervacije WHERE sala_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    return $res['broj'] > 0;
}

public function setStatus($id, $status) {
    $stmt = $this->db->prepare("UPDATE sale SET Status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    return $stmt->execute();
}

public function findFreeRooms($pocetak, $kraj) {
    $query = "
        SELECT * FROM sale
        WHERE id NOT IN (
            SELECT sala_id FROM rezervacije
            WHERE (? < kraj AND ? > pocetak)
        ) AND Status = 'slobodna'
    ";
    $stmt = $this->db->prepare($query);
    $stmt->bind_param("ss", $pocetak, $kraj);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

}
