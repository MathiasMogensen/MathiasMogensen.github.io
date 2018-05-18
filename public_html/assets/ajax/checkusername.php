<?php
include("../incl/init.php");

    $email = filter_input(INPUT_POST, "register_user_name", FILTER_SANITIZE_STRING);

    $params = array(
        $email
    );

    $sql = "SELECT * FROM user WHERE email = ?";

    if (!$result = $db->fetch_value($sql, $params)) {
        $message = array("status" => "success", "output" => "Denne e-mail vil nu modtage vores nyhedsbreve");
    } else {
        $message = array("status" => "error", "output" => "Denne e-mail modtager allerede nyhedsbreve");
    }
    echo json_encode($message);