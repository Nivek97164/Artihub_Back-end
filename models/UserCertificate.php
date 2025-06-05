<?php
class UserCertificate {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function getByUser($user_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM UserCertificates WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll();
    }
    public function add($user_id, $certificate_name, $issued_date) {
        $stmt = $this->pdo->prepare("INSERT INTO UserCertificates (user_id, certificate_name, issued_date) VALUES (?, ?, ?)");
        return $stmt->execute([$user_id, $certificate_name, $issued_date]);
    }
}
?>