<?php

/* 
 * Class user
 */

class user {
    
    /* Class Member Properties*/
    public $id;
    public $username;
    public $password;
    public $firstname;
    public $lastname;
    public $address;
    public $zipcode;
    public $city;
    public $country;
    public $email;
    public $phone1;
    public $phone2;
    public $phone3;
    public $birthdate;
    public $gender;
    public $created;
    public $suspended;
    public $deleted;

    public $arrLabels;
    public $arrFormElms;
    public $arrValues;
    public $arrGroups;


    /**
     * Class Constructor
     * @global object $db
     */
    public function __construct() {
        global $db;
        $this->db = $db;
    }
    
    /**
     * Class Method GetList
     * @return array Returns selected rows as an array
     */
    public function getlist() {
        $sql = "SELECT * FROM user " . 
                "WHERE deleted = 0";
        return $this->db->fetch_array($sql);
    }
    
    /**
     * Class Method GetUser
     * @param int $id
     * Selects by id and add values to class properties
     */
    public function getuser($id) {
        $this->id = $id;
        $sql = "SELECT * " .
                "FROM user " .
                "WHERE id = ?";
        if($row = $this->db->fetch_array($sql, array($this->id))) {

            foreach($row[0] as $key => $value) {
                $this->$key = $value;
            }
        }
    }
    public function delete($id) {
        $params = array($id);
        $strUpdate = "UPDATE user SET deleted = 1 " . 
                        "WHERE id = ?";
        $this->db->query($strUpdate, $params);
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
        $fileUpdate = file_exists($_FILES['file']['tmp_name']) ? ", avatar = ?" : "";
        $fileSave = file_exists($_FILES['file']['tmp_name']) ? ", avatar" : "";
        $fileSetParam = file_exists($_FILES['file']['tmp_name']) ? ",?" : "";

        // Set general params
        $params = array(
            $this->firstname,
            $this->lastname
        );
        if ($id > 0) {
            $sql = "UPDATE user 
            SET firstname = ?, 
            lastname = ?
            $fileUpdate
            WHERE id = $id";
        } else {
            $sql = "INSERT INTO user(
                firstname, 
                lastname
                $fileSave
                ) VALUES (?,? $fileSetParam)";
        }

        // If file not empty
        if(file_exists($_FILES['file']['tmp_name'])) {
            if (in_array($fileActualExt, $allowed)) {
                //Checks for errors
                if ($fileError === 0) {
                    //Get product for current image
                    $user = new user();
                    $user->getuser($id);
                    $currentImg = $fileDestination . $user->avatar;

                    if ($id > 1) {
                        unlink(DOCROOT . $currentImg);
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