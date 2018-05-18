<?php
require("../incl/init.php");

    $fullname = filter_input(INPUT_POST, "fullname", FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING);
    $message = filter_input(INPUT_POST, "message", FILTER_SANITIZE_STRING);

    $params = array(
        $email,
        $fullname,
        $message
    );
    $sql = "INSERT INTO message (email, fullname, message) VALUES (?,?,?)";
    $db->query($sql, $params);

    $message = array("status" => "success", "output" => "Din er besked er sendt. Du vil modtage et svar på den angivne e-mail");
    echo json_encode($message);