<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";

class AnimalModel extends Database {
    public function getPurchases() {
        $username = 'bleh';/*$_SESSION["username"];*/

        return $this->select("SELECT * FROM `animals` WHERE username=?", ["s", $username]);
    }

    public function createPurchase($purchase_id, $username, $animal, $currentTimestamp) {
        return $this->executeStatement("INSERT INTO `animals` (`purchase_id`, `username`, `animal`, `time_date`) VALUES (?, ?, ?, ?)", ["isss", $purchase_id, $username, $animal, $currentTimestamp]);
    }


    public function deletePurchase($purchase_id) {
        return $this->select("DELETE FROM `animals` WHERE purchase_id=?", ["i", [$purchase_id]]);
    }


    public function updatePurchase($purchase_id, $animal) {
        return $this->select("UPDATE animals SET animal=? WHERE purchase_id=?", ["si", $animal, $purchase_id]);
    }

}

