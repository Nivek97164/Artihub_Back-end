<?php
class LabelProject {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function getByProject($project_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM LabelProjects WHERE project_id = ?");
        $stmt->execute([$project_id]);
        return $stmt->fetchAll();
    }
    public function add($project_id, $label) {
        $stmt = $this->pdo->prepare("INSERT INTO LabelProjects (project_id, label) VALUES (?, ?)");
        return $stmt->execute([$project_id, $label]);
    }
}
?>