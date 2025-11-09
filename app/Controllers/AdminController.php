<?php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/Room.php';
require_once __DIR__ . '/../Models/Reservation.php';

class AdminController extends Controller {

    public function __construct() {
        session_start();
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: ' . BASE_URL);
            exit;
        }
    }

    /**
     * Glavni dashboard - pregled svih rezervacija i sala
     */
    public function dashboard() {
        $reservationModel = new Reservation();
        $reservations = $reservationModel->getAll();

        $roomModel = new Room();
        $rooms = $roomModel->getAll();

        $this->view('admin/dashboard', [
            'reservations' => $reservations,
            'rooms' => $rooms
        ]);
    }

    /**
     * Forma za dodavanje nove sale
     */
    public function addRoomForm() {
        $this->view('admin/add-room');
    }

    /**
     * Dodavanje nove sale u bazu
     */
    public function addRoom() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $naziv = $_POST['naziv'] ?? '';
            $lokacija = $_POST['lokacija'] ?? '';
            $kapacitet = $_POST['kapacitet'] ?? 0;
            $tv = isset($_POST['tv']) ? 1 : 0;
            $projektor = isset($_POST['projektor']) ? 1 : 0;
            $pametna_tabla = isset($_POST['pametna_tabla']) ? 1 : 0;
            $kamera = isset($_POST['kamera']) ? 1 : 0;
            $mikrofon = isset($_POST['mikrofon']) ? 1 : 0;
            $status = $_POST['status'] ?? 'slobodna';

            $roomModel = new Room();
            $roomModel->add($naziv, $lokacija, $kapacitet, $tv, $projektor, $pametna_tabla, $kamera, $mikrofon, $status);

            header('Location: ' . BASE_URL . 'admin/dashboard');
            exit;
        }
    }

    /**
     * Forma za registraciju korisnika
     */
    public function registerUserForm() {
        $this->view('admin/register-user');
    }

    /**
     * Dodavanje korisnika u bazu
     */
   public function registerUser() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $ime = $_POST['ime'] ?? '';
        $prezime = $_POST['prezime'] ?? '';
        $email = $_POST['email'] ?? '';
        $telefon = $_POST['telefon'] ?? '';
        $sektor = $_POST['sektor'] ?? '';
        $lozinka = $_POST['lozinka'] ?? '';
        $potvrda = $_POST['lozinka_potvrda'] ?? '';
        $uloga = $_POST['uloga'] ?? 'user';

        // Provera da li se lozinke poklapaju
        if ($lozinka !== $potvrda) {
            $this->view('admin/register-user', [
                'error' => 'Lozinke se ne poklapaju! Pokušajte ponovo.',
                'old' => $_POST // opciono, da prepopuni formu
            ]);
            return;
        }

        // Provera da li već postoji korisnik sa istim emailom
        $userModel = new User();
        $postojeci = $userModel->getByEmail($email);
        if ($postojeci) {
            $this->view('admin/register-user', [
                'error' => 'Korisnik sa ovim emailom već postoji!',
                'old' => $_POST
            ]);
            return;
        }

        // Ako sve OK – dodaj korisnika
        $userModel->add($ime, $prezime, $email, $telefon, $sektor, $lozinka, $uloga);

        //  Redirekcija
        header('Location: ' . BASE_URL . 'admin/dashboard');
        exit;
    }
}

    public function listUsers() {
    $userModel = new User();
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    $users = $userModel->getPaginated($limit, $offset);
    $total = $userModel->countAll();
    $pages = ceil($total / $limit);

    $this->view('admin/list-users', [
        'users' => $users,
        'page' => $page,
        'pages' => $pages
    ]);
}

public function listRooms() {
    $roomModel = new Room();
    $filters = [
        'lokacija' => $_GET['lokacija'] ?? '',
        'status' => $_GET['status'] ?? '',
        'tv' => $_GET['tv'] ?? ''
    ];

    $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    $rooms = $roomModel->getFiltered($limit, $offset, $filters);
    $total = $roomModel->countAll();
    $pages = ceil($total / $limit);

    $this->view('admin/list-rooms', compact('rooms', 'page', 'pages', 'filters'));
}

public function editRoomForm() {
    $id = $_GET['id'] ?? null;
    if (!$id) { header('Location: ' . BASE_URL . 'admin/list-rooms'); exit; }

    $roomModel = new Room();
    $room = $roomModel->getById($id);

    if (!$room) {
        $this->view('admin/list-rooms', ['error' => 'Sala nije pronađena.']);
        return;
    }

    // koristi istu formu kao add-room ali sa popunjenim podacima
    $this->view('admin/add-room', ['room' => $room]);
}

public function editRoom() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? null;
        $naziv = $_POST['naziv'] ?? '';
        $lokacija = $_POST['lokacija'] ?? '';
        $kapacitet = $_POST['kapacitet'] ?? 0;
        $status = $_POST['status'] ?? 'slobodna';

        $roomModel = new Room();
        $roomModel->update($id, $naziv, $lokacija, $kapacitet, $status);

        header('Location: ' . BASE_URL . 'admin/list-rooms');
        exit;
    }
}

public function deleteRoom() {
    $id = $_GET['id'] ?? null;
    if (!$id) exit;

    $roomModel = new Room();

    // proveri da li je sala zauzeta
    if ($roomModel->isUsed($id)) {
        echo "<script>alert('Sala se koristi u rezervacijama. Umesto brisanja, možete je deaktivirati.'); window.location.href='" . BASE_URL . "admin/list-rooms';</script>";
        exit;
    }

    $roomModel->delete($id);
    header('Location: ' . BASE_URL . 'admin/list-rooms');
    exit;
}

public function deactivateRoom() {
    $id = $_GET['id'] ?? null;
    if (!$id) exit;

    $roomModel = new Room();
    $roomModel->setStatus($id, 'neaktivna');

    header('Location: ' . BASE_URL . 'admin/list-rooms');
    exit;
}

public function editUserForm() {
    $id = $_GET['id'] ?? null;
    if (!$id) { header('Location: ' . BASE_URL . 'admin/list-users'); exit; }

    $userModel = new User();
    $user = $userModel->getById($id);

    if (!$user) {
        $this->view('admin/list-users', ['error' => 'Korisnik nije pronađen.']);
        return;
    }

    $this->view('admin/register-user', ['user' => $user]);
}

public function editUser() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? null;
        $ime = $_POST['ime'] ?? '';
        $prezime = $_POST['prezime'] ?? '';
        $email = $_POST['email'] ?? '';
        $telefon = $_POST['telefon'] ?? '';
        $sektor = $_POST['sektor'] ?? '';
        $uloga = $_POST['uloga'] ?? 'user';
        $status = $_POST['status'] ?? 'aktivan';

        $userModel = new User();
        $userModel->update($id, $ime, $prezime, $email, $telefon, $sektor, $uloga, $status);

        header('Location: ' . BASE_URL . 'admin/list-users');
        exit;
    }
}

public function deleteUser() {
    $id = $_GET['id'] ?? null;
    if (!$id) exit;

    $userModel = new User();

    // proveri da li korisnik ima rezervacije
    if ($userModel->hasReservations($id)) {
        echo "<script>alert('Korisnik ima rezervacije i ne može biti obrisan. Možete ga deaktivirati.'); 
              window.location.href='" . BASE_URL . "admin/list-users';</script>";
        exit;
    }

    $userModel->delete($id);
    header('Location: ' . BASE_URL . 'admin/list-users');
    exit;
}

public function deactivateUser() {
    $id = $_GET['id'] ?? null;
    if (!$id) exit;

    $userModel = new User();
    $userModel->setStatus($id, 'neaktivan');

    header('Location: ' . BASE_URL . 'admin/list-users');
    exit;
}

public function editReservationForm() {
    $id = $_GET['id'] ?? null;
    if (!$id) { header('Location: ' . BASE_URL . 'admin/dashboard'); exit; }

    $reservationModel = new Reservation();
    $roomModel = new Room();
    $userModel = new User();

    $reservation = $reservationModel->getById($id);
    $rooms = $roomModel->getAll();
    $users = $userModel->getAll();

    if (!$reservation) {
        $this->view('admin/dashboard', ['error' => 'Rezervacija nije pronađena.']);
        return;
    }

    $this->view('admin/edit-reservation', [
        'reservation' => $reservation,
        'rooms' => $rooms,
        'users' => $users
    ]);
}

public function editReservation() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? null;
        $sala_id = $_POST['sala_id'] ?? '';
        $korisnik_id = $_POST['korisnik_id'] ?? '';
        $datum = $_POST['datum'] ?? '';
        $trajanje = $_POST['trajanje'] ?? '';
        $naziv_sastanka = $_POST['naziv_sastanka'] ?? '';
        $tema = $_POST['tema'] ?? '';
        $lokacija = $_POST['lokacija'] ?? '';
        $online = isset($_POST['online']) ? 1 : 0;

        $reservationModel = new Reservation();
        $reservationModel->update(
            $id, $sala_id, $korisnik_id, $datum, $trajanje,
            $naziv_sastanka, $tema, $lokacija, $online
        );

        header('Location: ' . BASE_URL . 'admin/dashboard');
        exit;
    }
}


}
?>
