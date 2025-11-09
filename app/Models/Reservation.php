<?php
require_once __DIR__ . '/../../core/Model.php';

class Reservation extends Model
{
    public function add($korisnik_id, $sala_id, $pocetak, $kraj, $naziv, $tema, $pozvani, $online, $google_event_id = null)
{
    $query = "
        INSERT INTO rezervacije
        (korisnik_id, sala_id, pocetak, kraj, naziv_sastanka, tema, pozvani, online, google_event_id)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ";

    $stmt = $this->db->prepare($query);
    if (!$stmt) {
        die("Greška u pripremi upita: " . $this->db->error);
    }

    $stmt->bind_param(
        "iisssssis",
        $korisnik_id,
        $sala_id,
        $pocetak,
        $kraj,
        $naziv,
        $tema,
        $pozvani,
        $online,
        $google_event_id
    );

    if (!$stmt->execute()) {
        die("Greška pri izvršavanju upita: " . $stmt->error);
    }

    return true;
}


    public function getAll()
    {
        $sql = "
            SELECT r.*, k.Ime, k.Prezime, s.Naziv AS NazivSale
            FROM Rezervacije r
            JOIN Korisnici k ON r.korisnik_id = k.ID
            JOIN Sale s ON r.sala_id = s.ID
            
        ";
        $stmt = $this->db->query($sql);
        return $stmt->fetch_all(MYSQLI_ASSOC);
    }

    public function getByUser($idKorisnik)
    {
        $stmt = $this->db->prepare("
            SELECT r.*, s.Naziv AS NazivSale 
            FROM Rezervacije r 
            JOIN Sale s ON r.sala_id = s.ID 
            WHERE korisnik_id = ?
            
        ");
        $stmt->bind_param("i", $idKorisnik);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

public function getByUserIdFiltered($korisnik_id, $limit, $offset, $filters = []) {
    $query = "
        
    SELECT 
        r.id,
        r.korisnik_id,
        r.sala_id,
        r.datum,
        r.pocetak,
        r.kraj,
        r.Online,
        s.naziv AS sala,
        k.ime AS korisnik
    FROM rezervacije r
    JOIN sale s ON r.sala_id = s.id
    JOIN korisnici k ON r.korisnik_id = k.id
    ORDER BY r.pocetak DESC

    ";

    $params = [$korisnik_id];
    $types = "i";

    // 🔹 Filtriranje po sali
    if (!empty($filters['sala'])) {
        $query .= " AND s.naziv LIKE ?";
        $params[] = "%" . $filters['sala'] . "%";
        $types .= "s";
    }

    // 🔹 Filtriranje po datumu (od)
    if (!empty($filters['od'])) {
        $query .= " AND r.datum >= ?";
        $params[] = $filters['od'];
        $types .= "s";
    }

    // 🔹 Filtriranje po datumu (do)
    if (!empty($filters['do'])) {
        $query .= " AND r.datum <= ?";
        $params[] = $filters['do'];
        $types .= "s";
    }

    // 🔹 Filtriranje po tipu sastanka (online/fizički)
    if (isset($filters['online']) && $filters['online'] !== '') {
        $query .= " AND r.Online = ?";
        $params[] = (int)$filters['online'];
        $types .= "i";
    }

    $query .= " ORDER BY r.pocetak DESC LIMIT ? OFFSET ?";
    $params[] = $limit;
    $params[] = $offset;
    $types .= "ii";

    $stmt = $this->db->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

public function countByUserIdFiltered($korisnik_id, $filters = []) {
    $query = "SELECT COUNT(*) AS total
              FROM rezervacije r
              JOIN sale s ON r.sala_id = s.id
              WHERE r.korisnik_id = ?";
    $params = [$korisnik_id];
    $types = "i";

    if (!empty($filters['sala'])) {
        $query .= " AND s.naziv LIKE ?";
        $params[] = "%" . $filters['sala'] . "%";
        $types .= "s";
    }
    if (!empty($filters['od'])) {
        $query .= " AND r.datum >= ?";
        $params[] = $filters['od'];
        $types .= "s";
    }
    if (!empty($filters['do'])) {
        $query .= " AND r.datum <= ?";
        $params[] = $filters['do'];
        $types .= "s";
    }
    if (isset($filters['online']) && $filters['online'] !== '') {
        $query .= " AND r.Online = ?";
        $params[] = (int)$filters['online'];
        $types .= "i";
    }

    $stmt = $this->db->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['total'] ?? 0;
}


public function countByUserId($korisnik_id) {
    $stmt = $this->db->prepare("SELECT COUNT(*) AS total FROM rezervacije WHERE korisnik_id = ?");
    $stmt->bind_param("i", $korisnik_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['total'] ?? 0;
}

public function getById($id) {
    $stmt = $this->db->prepare("SELECT * FROM rezervacije WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

public function update($id, $sala_id, $korisnik_id, $datum, $trajanje, $naziv_sastanka, $tema, $lokacija, $Online) {
    $stmt = $this->db->prepare("
        UPDATE rezervacije 
        SET sala_id = ?, korisnik_id = ?, datum = ?, trajanje = ?, 
            naziv_sastanka = ?, tema = ?, lokacija = ?, Online = ?
        WHERE id = ?
    ");
    $stmt->bind_param(
        "iisssssii",
        $sala_id, $korisnik_id, $datum, $trajanje,
        $naziv_sastanka, $tema, $lokacija, $Online, $id
    );
    return $stmt->execute();
}


}
