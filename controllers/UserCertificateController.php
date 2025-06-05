<?php
require_once __DIR__ . '/../models/UserCertificate.php';
class UserCertificateController {
    private $cert;
    public function __construct($pdo) {
        $this->cert = new UserCertificate($pdo);
    }
    public function index($user_id) {
        echo json_encode($this->cert->getByUser($user_id));
    }
    public function store($data) {
        if ($this->cert->add($data['user_id'], $data['certificate_name'], $data['issued_date'])) {
            echo json_encode(["success" => true]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Certificate creation failed"]);
        }
    }
}
?>