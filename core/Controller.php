<?php
class Controller {

    // Učitavnje view i prosleđivanje podataka
    protected function view($view, $data = []) {
        extract($data);
        $path = __DIR__ . '/../app/Views/' . $view . '.php';

        if (file_exists($path)) {
            require $path;
        } else {
            echo "View fajl ne postoji: $view";
        }
    }

    // Učitavanje model-a
    protected function model($model) {
        $path = __DIR__ . '/../app/Models/' . $model . '.php';

        if (file_exists($path)) {
            require_once $path;
            return new $model();
        } else {
            die("Model $model ne postoji.");
        }
    }
}
?>
