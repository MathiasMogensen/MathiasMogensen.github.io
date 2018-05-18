<?php

class categories {

    private $db;

    public $id;
    public $name;
    public $description;
    public $deleted;

    public function __construct() {
        global $db;
        $this->db = $db;
    }

    public function getCategories() {
        $sql = "SELECT * FROM category";
        return $this->db->fetch_array($sql);
    }
}