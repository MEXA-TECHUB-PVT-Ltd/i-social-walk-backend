<?php
include('../include/connection.php');
$id = $_POST["id"];
$target_dir = "../assets/";
$target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
    // $dbpath = 'assets/images/' . basename($_FILES["profile_image"]["name"]);
    $dbpath = 'assets/' . basename($_FILES["profile_image"]["name"]);
    $sql = "UPDATE users SET profile_image='$dbpath' WHERE id='$id'";
    $run = mysqli_query($conn, $sql);
    if ($run) {
        $response[] = array(
            "message" => 'users Image Updated : ' . $id,
            "img_link" => $dbpath,
            "error" => true
        );
        echo json_encode($response);
    } else {
        $response[] = array(
            "message" => 'Error uploading Image',
            "error" => false,
        );
        echo json_encode($response);
    }
}
