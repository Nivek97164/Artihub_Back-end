<?php
require_once __DIR__ . '/../models/Notification.php';
class NotificationController {
    private $notif;
    public function __construct($pdo) {
        $this->notif = new Notification($pdo);
    }
    public function index($user_id) {
        echo json_encode($this->notif->getByUser($user_id));
    }
    public function store($data) {
        if ($this->notif->create($data['user_id'], $data['type'], $data['message'])) {
            echo json_encode(["success" => true]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Notification creation failed"]);
        }
    }
}
?>