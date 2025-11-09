<?php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../Models/User.php';

class LoginController extends Controller {

    public function index() {
        $this->view('login');
    }

    public function login() {
        session_start();
        $email = $_POST['email'] ?? '';
        $lozinka = $_POST['password'] ?? '';

        $userModel = new User();
        $user = $userModel->getByEmail($email);

        if ($user && password_verify($lozinka, $user['lozinka'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['ime'];
            $_SESSION['user_role'] = $user['uloga'];

            if ($user['uloga'] === 'admin') {
           header('Location:'. BASE_URL . 'admin/dashboard');
            exit;
            } else {
               header('Location:'. BASE_URL . 'user/dashboard');
               exit;
             }

        } else {
            $this->view('login', ['error' => 'Pogrešan email ili lozinka!']);
        }
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header('Location:'.BASE_URL);
        exit;
    }
}
?>
