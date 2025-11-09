<?php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../Models/Reservation.php';
require_once __DIR__ . '/../Models/Room.php';

class UserController extends Controller {

    public function __construct() {
        session_start();
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'user') {
            header('Location: /');
            exit;
        }
    }

    // Glavni dashboard (možemo ubaciti Google Calendar ovde)
    public function dashboard() {
        $this->view('user/dashboard', ['user' => $_SESSION['user_name']]);
    }

    // Forma za rezervaciju
    public function bookRoomForm() {
        $roomModel = new Room();
        $rooms = $roomModel->getAll();
        $this->view('user/book-room', ['rooms' => $rooms]);
    }

    // Kreiranje nove rezervacije
    public function bookRoom() {
    // ovaj metod se poziva kada korisnik odabere salu
    $pocetak = $_POST['pocetak'] ?? '';
    $kraj = $_POST['kraj'] ?? '';
    $sala_id = $_POST['sala_id'] ?? '';

    $this->view('user/finalize-reservation', [
        'pocetak' => $pocetak,
        'kraj' => $kraj,
        'sala_id' => $sala_id
    ]);
}

public function confirmBooking() {
    
    $korisnik_id = $_SESSION['user_id'] ?? 0;

    $sala_id = $_POST['sala_id'] ?? '';
    $pocetak = $_POST['pocetak'] ?? '';
    $kraj = $_POST['kraj'] ?? '';
    $naziv = $_POST['naziv_sastanka'] ?? '';
    $tema = $_POST['tema'] ?? '';
    $pozvani = $_POST['pozvani'] ?? '';
    $online = isset($_POST['online']) ? 1 : 0;

    //  Upis u bazu
    $reservationModel = new Reservation();

$reservationModel->add(
    $_SESSION['user_id'],
    $_POST['sala_id'],
    $_POST['pocetak'],
    $_POST['kraj'],
    $_POST['naziv_sastanka'],
    $_POST['tema'],
    $_POST['pozvani'],
    isset($_POST['online']) ? 1 : 0,
    $google_event_id ?? null
);

require_once __DIR__ . '/../../vendor/autoload.php';

try {
    //  Povezivanje sa OAuth nalozima (koristi token, ne service account)
    $client = new Google_Client();
    $client->setAuthConfig(__DIR__ . '/../../google-oauth.json');
    $client->addScope(Google_Service_Calendar::CALENDAR);
    $client->setAccessType('offline');

    $tokenPath = __DIR__ . '/../../google_token.json';
    if (!file_exists($tokenPath)) {
        throw new Exception(" Nema tokena! Pokreni /oauth2callback.php da se prijaviš na Google.");
    }

    $accessToken = json_decode(file_get_contents($tokenPath), true);
    $client->setAccessToken($accessToken);

    // Osveži ako je istekao
    if ($client->isAccessTokenExpired()) {
        $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    }

    $service = new Google_Service_Calendar($client);

    // Validacija i priprema vremena
    $startDateTime = date('c', strtotime($pocetak)); // ISO 8601 format
    $endDateTime = date('c', strtotime($kraj));

    // Pozvani (attendees)
    $attendees = [];
    if (!empty($pozvani)) {
        foreach (explode(',', $pozvani) as $email) {
            $trimmed = trim($email);
            if (filter_var($trimmed, FILTER_VALIDATE_EMAIL)) {
                $attendees[] = ['email' => $trimmed];
            }
        }
    }

    // Kreiranje događaja
    $event = new Google_Service_Calendar_Event([
        'summary' => $naziv,
        'description' => "Tema: {$tema}",
        'start' => [
            'dateTime' => $startDateTime,
            'timeZone' => 'Europe/Belgrade',
        ],
        'end' => [
            'dateTime' => $endDateTime,
            'timeZone' => 'Europe/Belgrade',
        ],
        'attendees' => $attendees
    ]);

    // Online sastanak (Google Meet)
    $optParams = [];
    if ($online) {
        $conference = new Google_Service_Calendar_ConferenceData([
            'createRequest' => [
                'requestId' => uniqid(),
                'conferenceSolutionKey' => ['type' => 'hangoutsMeet'],
            ],
        ]);
        $event->setConferenceData($conference);
        $optParams['conferenceDataVersion'] = 1;
    }

    // Dodaj događaj 
    $calendarId = 'primary';
    $optParams['sendUpdates'] = 'all'; // šalje mejlove svim učesnicima
    $createdEvent = $service->events->insert($calendarId, $event, $optParams);


    // Sačuvaj event ID 
    $googleEventId = $createdEvent->getId();

    

    
    $this->view('user/dashboard', [
        'naziv' => $naziv,
        'pocetak' => $pocetak,
        'kraj' => $kraj,
        'google_link' => $createdEvent->getHtmlLink()
    ]);

} catch (Exception $e) {
    echo "<pre> GREŠKA: " . htmlspecialchars($e->getMessage()) . "</pre>";
}
}


    // Tabelarni pregled rezervacija
public function myReservations() {
    
    $userId = $_SESSION['user_id'] ?? null;

    if (!$userId) {
        header('Location: ' . BASE_URL);
        exit;
    }

    $filters = [
        'sala' => $_GET['sala'] ?? '',
        'od' => $_GET['od'] ?? '',
        'do' => $_GET['do'] ?? '',
        'online' => $_GET['online'] ?? ''
    ];

    $reservationModel = new Reservation();

    $limit = 10;
    $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    $offset = ($page - 1) * $limit;

    $rezervacije = $reservationModel->getByUserIdFiltered($userId, $limit, $offset, $filters);
    $total = $reservationModel->countByUserIdFiltered($userId, $filters);
    $pages = ceil($total / $limit);

    $this->view('user/my-reservations', compact('rezervacije', 'page', 'pages', 'filters'));
}

public function findRooms() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $datum = $_POST['datum'] ?? '';
        $vremePocetka = $_POST['vreme_pocetka'] ?? '';
        $vremeKraja = $_POST['vreme_kraja'] ?? '';

        // spojimo u DATETIME format za bazu
        $pocetak = date('Y-m-d H:i:s', strtotime("$datum $vremePocetka"));
        $kraj = date('Y-m-d H:i:s', strtotime("$datum $vremeKraja"));

        $roomModel = new Room();
        $rooms = $roomModel->findFreeRooms($pocetak, $kraj);


        $this->view('user/available-rooms', [
            'sale' => $rooms,
            'pocetak' => $pocetak,
            'kraj' => $kraj
        ]);
    }
}

public function bookRoomDetails() {
    

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $sala_id = $_POST['sala_id'] ?? null;
        $pocetak = $_POST['pocetak'] ?? '';
        $kraj = $_POST['kraj'] ?? '';

        if (!$sala_id || !$pocetak || !$kraj) {
            $this->view('user/available-rooms', ['error' => 'Nedostaju podaci o sali ili terminu.']);
            return;
        }

        $roomModel = new Room();
        $sala = $roomModel->getById($sala_id);

        $this->view('user/finalize-reservation', [
            'sala' => $sala,
            'pocetak' => $pocetak,
            'kraj' => $kraj
        ]);
    }
}


}
?>
