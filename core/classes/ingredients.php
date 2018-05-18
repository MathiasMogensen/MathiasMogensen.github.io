<?php

class ingredients {

    private $db;

    public $id;
    public $name;
    public $deleted;

    public function __construct() {
        global $db;
        $this->db = $db;
    }

    public function getIngredients($productId) {
        $sql = "SELECT *,
        ingr_prod.id AS id, 
        ingredient.id AS ingr_Id, 
        ingredient.name AS name, 
        measure.id AS measure_id,
        measure.name AS measure_name
        FROM ingr_prod
        JOIN ingredient ON ingredient_id = ingredient.id
        JOIN measure ON measure_id = measure.id
        WHERE product_id = $productId
        ORDER BY ingr_prod.id DESC";
        return $this->db->fetch_array($sql);
    }
    public function getAllIngredients() {
        $sql = "SELECT * FROM ingredient";
        return $this->db->fetch_array($sql);
    }
}