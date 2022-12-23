<?php
session_start();
include('../include/connection.php');

$id = $_POST['id'];
// user data
$login = '';
$name  = '';
$group_privacy = '';
$created_by_user_id  = '';

$target_dir = "../assets/";
$target_file = $target_dir . basename($_FILES["image"]["name"]);


if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {


    $dbpath = 'assets/' . basename($_FILES["image"]["name"]);

    $sql = "UPDATE groups SET image='$dbpath' WHERE  id='$id'";
    $run = mysqli_query($conn, $sql);
    if ($run) {
        $sql_user = "SELECT * FROM groups WHERE id='$id'";
        $run_user = mysqli_query($conn, $sql_user);

        while ($row_user = mysqli_fetch_assoc($run_user)) {
            $id = $row_user['id'];
            $name = $row_user['name'];
            $group_privacy = $row_user['group_privacy'];
            $created_by_user_id = $row_user['created_by_user_id'];



            $login = 1;
            break;
        }
        if ($login == 1) {
            $response[] = array(
                "message" => 'Image Updates Successful',
                "image" =>  $dbpath,
                "created_by_user_id" => $created_by_user_id,
                "name" => $name,

                "id" => $id,
                "group_privacy" => $group_privacy,

                "error" => false,
            );
            echo json_encode($response);
        } else {
            $response[] = array(
                "message" => 'Error uploading Image',
                "error" => true,
            );
            echo json_encode($response);
        }
    } else {

        $response[] = array(
            "message" => 'Error uploading Image',
            "error" => $user_id,
        );
        echo json_encode($response);
    }
}
