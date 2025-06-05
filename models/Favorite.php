<?php
class Favorite {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function getByUser($user_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM Favorites WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll();
    }
    public function add($user_id, $favorited_user_id) {
        $stmt = $this->pdo->prepare("INSERT INTO Favorites (user_id, favorited_user_id) VALUES (?, ?)");
        return $stmt->execute([$user_id, $favorited_user_id]);
    }
    public function remove($user_id, $favorited_user_id) {
        $stmt = $this->pdo->prepare("DELETE FROM Favorites WHERE user_id = ? AND favorited_user_id = ?");
        return $stmt->execute([$user_id, $favorited_user_id]);
    }
}
?>