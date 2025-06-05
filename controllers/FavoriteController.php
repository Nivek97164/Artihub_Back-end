<?php
require_once __DIR__ . '/../models/Favorite.php';
class FavoriteController {
    private $fav;
    public function __construct($pdo) {
        $this->fav = new Favorite($pdo);
    }
    public function index($user_id) {
        echo json_encode($this->fav->getByUser($user_id));
    }
    public function store($data) {
        if ($this->fav->add($data['user_id'], $data['favorited_user_id'])) {
            echo json_encode(["success" => true]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Favorite addition failed"]);
        }
    }
    public function delete($data) {
        if ($this->fav->remove($data['user_id'], $data['favorited_user_id'])) {
            echo json_encode(["success" => true]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Favorite removal failed"]);
        }
    }
}
?>