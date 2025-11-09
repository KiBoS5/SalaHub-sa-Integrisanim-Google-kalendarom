<?php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../Models/User.php';

class ProfileController extends Controller
{
    public function show()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $userModel = new User();
        $user = $userModel->getById($_SESSION['user_id']);

        if (!$user) {
            die('Korisnik nije pronađen.');
        }

        $this->view('profile', ['user' => $user]);
    }
}
?>
