<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";

class AnimalModel extends Database {
    public function getPurchases() {
        $username = $_SESSION['username'] ?? 'testuser';

        return $this->select(
            "SELECT * FROM `animals` WHERE username=?",
            ["s", $username]
        );
    }

    public function createPurchase($username, $animal) {
        global $config;

        // Get next purchase ID manually
        $result = $config->query("SELECT COUNT(*) AS count FROM animals");
        $row = $result->fetch_assoc();
        $purchase_id = $row['count'] + 1;

        $currentTimestamp = date('Y-m-d H:i:s');

        // ✅ Use "isss" for 4 bind values (int, str, str, str)
        return $this->select(
            "INSERT INTO `animals` (`purchase_id`, `username`, `animal`, `time_date`) VALUES (?, ?, ?, ?)",
            ["isss", $purchase_id, $username, $animal, $currentTimestamp]
        );
    }

    public function deletePurchase($purchase_id) {
        return $this->select(
            "DELETE FROM `animals` WHERE purchase_id=?",
            ["i", $purchase_id]
        );
    }

    public function updatePurchase($purchase_id, $animal) {
        return $this->select(
            "UPDATE animals SET animal=? WHERE purchase_id=?",
            ["si", $animal, $purchase_id]
        );
    }
}
