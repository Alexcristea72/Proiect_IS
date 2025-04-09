<?php
require_once 'database.php';
require_once 'config.php';

class OfferModel {
    protected $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getTopOffers($limit) {
        $stmt = $this->db->prepare("SELECT * FROM offers ORDER BY buyers DESC LIMIT :limit");
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
