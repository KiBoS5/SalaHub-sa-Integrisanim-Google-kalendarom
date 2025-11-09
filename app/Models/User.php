<?php
require_once __DIR__ . '/../../core/Model.php';

class User extends Model {

    /**
     * Dohvata korisnika po email adresi
     */
    public function getByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM Korisnici WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    /**
     * Dohvata sve korisnike (admin pregled)
     */
    public function getAll() {
        $result = $this->db->query("SELECT * FROM Korisnici");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Dodaje novog korisnika
     */
    public function add($ime, $prezime, $email, $telefon, $sektor, $lozinka, $uloga = 'user') {
        $hash = password_hash($lozinka, PASSWORD_BCRYPT);

        $stmt = $this->db->prepare("
            INSERT INTO Korisnici (Ime, Prezime, Email, Telefon, Sektor, Lozinka, Uloga)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("sssssss", $ime, $prezime, $email, $telefon, $sektor, $hash, $uloga);
        return $stmt->execute();
    }

    /**
     * Dohvata korisnika po ID-u
     */
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Korisnici WHERE ID = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * Ažurira podatke korisnika (za profil)
     */
    public function updateProfile($id, $ime, $prezime, $email, $telefon, $sektor) {
        $stmt = $this->db->prepare("
            UPDATE Korisnici 
            SET Ime = ?, Prezime = ?, Email = ?, Telefon = ?, Sektor = ?
            WHERE ID = ?
        ");
        $stmt->bind_param("sssssi", $ime, $prezime, $email, $telefon, $sektor, $id);
        return $stmt->execute();
    }

    /**
     * Promena lozinke korisnika
     */
    public function updatePassword($id, $novaLozinka) {
        $hash = password_hash($novaLozinka, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("UPDATE Korisnici SET Lozinka = ? WHERE ID = ?");
        $stmt->bind_param("si", $hash, $id);
        return $stmt->execute();
    }

    public function getPaginated($limit, $offset) {
    $stmt = $this->db->prepare("SELECT * FROM korisnici ORDER BY id DESC LIMIT ? OFFSET ?");
    $stmt->bind_param("ii", $limit, $offset);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function countAll() {
    $result = $this->db->query("SELECT COUNT(*) AS total FROM korisnici");
    return $result->fetch_assoc()['total'];
    }

    public function getFiltered($limit, $offset, $filters = []) {
    $query = "SELECT * FROM korisnici WHERE 1=1";
    $params = [];
    $types = "";

    if (!empty($filters['sektor'])) {
        $query .= " AND sektor = ?";
        $params[] = $filters['sektor'];
        $types .= "s";
    }
    if (!empty($filters['uloga'])) {
        $query .= " AND uloga = ?";
        $params[] = $filters['uloga'];
        $types .= "s";
    }
    if (!empty($filters['q'])) {
        $query .= " AND (ime LIKE ? OR email LIKE ?)";
        $params[] = "%" . $filters['q'] . "%";
        $params[] = "%" . $filters['q'] . "%";
        $types .= "ss";
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

public function update($id, $ime, $prezime, $email, $telefon, $sektor, $uloga, $status) {
    $stmt = $this->db->prepare("UPDATE korisnici 
                                SET ime = ?, prezime = ?, email = ?, telefon = ?, sektor = ?, uloga = ?, status = ?
                                WHERE id = ?");
    $stmt->bind_param("sssssssi", $ime, $prezime, $email, $telefon, $sektor, $uloga, $status, $id);
    return $stmt->execute();
}

public function delete($id) {
    $stmt = $this->db->prepare("DELETE FROM korisnici WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

public function hasReservations($id) {
    $stmt = $this->db->prepare("SELECT COUNT(*) AS broj FROM rezervacije WHERE korisnik_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    return $res['broj'] > 0;
}

public function setStatus($id, $status) {
    $stmt = $this->db->prepare("UPDATE korisnici SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    return $stmt->execute();
}

}
?>
