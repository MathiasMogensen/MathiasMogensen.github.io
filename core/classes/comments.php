<?php

class comments {

    private $db;

    public function __construct() {
        global $db;
        $this->db = $db;
    }
    public function commentCount($id) {
        $sql = "SELECT * FROM comment WHERE product_id = $id AND deleted = 0";
        return count($this->db->fetch_array($sql));
    }
    public function getComments($id) {
        $params = array(
            $id
        );
        $sql = "SELECT
        comment.id AS id,
        comment.content AS content,
        comment.created_at AS created_at,
        user.id AS user_id,
        user.firstname AS firstname,
        user.avatar AS avatar,
        user.lastname AS lastname
        FROM comment
        JOIN user ON user_id = user.id
        WHERE product_id = ? AND deleted = 0
        ORDER BY created_at DESC";
        return $this->db->fetch_array($sql, $params);
    }
    public function save() {
        $params = array(
            $this->user_id,
            $this->product_id,
            $this->content
        );
        $sql = "INSERT INTO comment (user_id, product_id, content) 
        VALUES (?,?,?)";
        return $this->db->query($sql, $params);
    }
    public function delete($id) {
        $sql = "UPDATE comment SET deleted = 1 WHERE id = $id";
        $this->db->query($sql);
    }
}