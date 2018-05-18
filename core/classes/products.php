<?php

class products {

    private $db;

    public $id;
    public $name;
    public $description;
    public $category_id;
    public $image;
    public $created_at;
    public $deleted;

    public $products;

    public $ingrAmount;
    public $ingrId;
    public $measureId;

    public function __construct() {
        global $db;
        $this->db = $db;
    }

    public function searchProducts($query) {
        $sql = "SELECT *
        FROM product WHERE
        deleted = 0 AND
        name LIKE '%$query%' OR
        deleted = 0 AND
        description LIKE '%$query%' ";
        $this->productsquery = $this->db->fetch_array($sql);

        $sql = "SELECT * FROM ingredient WHERE name LIKE '%$query%'";
        $this->ingredients = $this->db->fetch_array($sql);

        foreach ($this->ingredients as $ingr) {
            $sql = "SELECT product.*,
            product.id AS id
            FROM ingr_prod
            JOIN product ON ingr_prod.product_id = product.id
            WHERE ingredient_id = ". $ingr['id'] ." AND product.deleted = 0";
            $this->ingrquery = $this->db->fetch_array($sql);
        }
        if ($this->ingredients && $this->productsquery) {
            $this->products = array_merge($this->productsquery, $this->ingrquery);
        } elseif ($this->productsquery) {
            $this->products = $this->productsquery;
        } elseif ($this->ingredients) {
            $this->products = $this->ingrquery;
        }
            return $this->products;
    }
    public function searchProductsByCategory($category, $query) {
        $currProducts = $this->searchProducts($query);
        
        $this->productsArray = array();
        foreach ($currProducts as $product) {
            $sql = "SELECT * FROM product WHERE id = ".$product['id']." AND category_id = $category";
            array_push($this->productsArray, $this->db->fetch_array($sql));
        }
        $this->products = call_user_func_array('array_merge', $this->productsArray);
        return $this->products;
    }

    public function getProduct($id) {
        $params = array(
            $id
        );
        $sql = "SELECT *,
        product.id AS id,
        product.name AS name,
        category.name AS category_name,
        category.id AS category_id
        FROM product 
        JOIN category ON category_id = category.id 
        WHERE product.id = ?";
	    $row = $this->db->fetch_array($sql, $params);

	    if (count($row)){
		    $row = call_user_func_array('array_merge', $row);

		    $this->id = $row['id'];
		    $this->name = $row['name'];
            $this->description = $row['description'];
            $this->image = $row['image'];
            $this->category_id = $row['category_id'];
            $this->category_name = $row['category_name'];
            $this->created_at = $row['created_at'];
            $this->deleted = $row['deleted'];
	    }
    }
    public function getAllMeasures() {
        $sql = "SELECT * FROM measure";
        return $this->db->fetch_array($sql);
    }
    public function getProducts() {
        $sql = "SELECT *,
        product.id AS id,
        product.name AS name,
        category.id AS category_id,
        category.name AS category_name
        FROM product 
        JOIN category ON category_id = category.id
        WHERE product.deleted = 0
        ORDER BY created_at DESC";
	    return $this->db->fetch_array($sql);
    }
    public function getProductsLimit($limit) {
        $sql = "SELECT *,
        product.id AS id,
        product.name AS name,
        category.id AS category_id,
        category.name AS category_name
        FROM product 
        JOIN category ON category_id = category.id
        WHERE product.deleted = 0
        ORDER BY created_at DESC
        LIMIT $limit";
	    return $this->db->fetch_array($sql);
    }
    public function getProductsByCategory($categoryId) {
        $sql = "SELECT *,
        product.id AS id,
        product.name AS name,
        category.id AS category_id,
        category.name AS category_name
        FROM product 
        JOIN category ON category_id = category.id
        WHERE product.deleted = 0 AND category_id = $categoryId
        ORDER BY created_at DESC";
	    return $this->db->fetch_array($sql);
    }
    public function deleteingr($id){
        $sql = "DELETE FROM ingr_prod WHERE id = $id";
        return $this->db->query($sql);
    }
    public function saveingr($productId) {
        $params = array(
            $productId,
            $this->ingrId,
            $this->measureId,
            $this->ingrAmount
        );
        $sql = "INSERT INTO ingr_prod (
            product_id,
            ingredient_id,
            measure_id,
            amount
        ) 
        VALUES (?,?,?,?)";
        $this->db->query($sql, $params);
    }
    public function delete($id){
        $sql = "UPDATE product SET deleted = 1 WHERE id = $id";
        return $this->db->query($sql);
    }
    public function save($id, $fileDestination){
            
        $file = $_FILES['file'];

        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileType = $file['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $fileNameNew = uniqid('', true) . "." . $fileActualExt;
        $fileDestinationWithName = $fileDestination . $fileNameNew;

        $allowed = array('jpg', 'png', 'gif', 'jpeg');
        
        // If file exists, add it to params
        $fileUpdate = file_exists($_FILES['file']['tmp_name']) ? ", image = ?" : "";
        $fileSave = file_exists($_FILES['file']['tmp_name']) ? ", image" : "";
        $fileSetParam = file_exists($_FILES['file']['tmp_name']) ? ",?" : "";

        // Set general params
        $params = array(
            $this->name,
            $this->description,
            $this->category_id
        );
        if ($id > 0) {
            $sql = "UPDATE product 
            SET name = ?, 
            description = ?,
            category_id = ?
            $fileUpdate
            WHERE id = $id";
        } else {
            $sql = "INSERT INTO product(
                name, 
                description,
                category_id
                $fileSave
                ) VALUES (?,?,? $fileSetParam)";
        }

        // If file not empty
        if(file_exists($_FILES['file']['tmp_name'])) {
            if (in_array($fileActualExt, $allowed)) {
                //Checks for errors
                if ($fileError === 0) {
                    //Get product for current image
                    $product = new products();
                    $product->getProduct($id);
                    $currentImg = $fileDestination . $product->image;

                    if ($id > 1) {
                        if(file_exists($_FILES['file']['tmp_name'])) {
                            //Delete current image
                            unlink(DOCROOT . $currentImg);
                        }
                    }

                    //Move raw file
                    move_uploaded_file($fileTmpName, DOCROOT . $fileDestinationWithName);

                    //Add file to params
                    array_push($params, $fileNameNew);

                    $this->db->query($sql, $params);

                    /* Return new id */
                    return $this->db->getinsertid();

                } else {
                    echo "Fejl i uploading af fil: " . $_FILES["file"]["error"];
                }
            } else {
                echo "Du kan ikke uploade denne type filer";
            }
        } else {
            // If file is empty
            $this->db->query($sql, $params);

            /* Return new id */
            return $this->db->getinsertid();
        }
    }

}