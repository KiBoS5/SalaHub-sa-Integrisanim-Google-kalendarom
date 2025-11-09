<?php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/../config/config.php';

class Model {
    protected $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
}
?>
