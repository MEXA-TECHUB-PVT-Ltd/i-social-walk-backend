<?php
session_start();
include('../include/connection.php');

$id = $_POST['id'];


$email = '';
$password = '';
$first_name = '';
$last_name = '';

$login = 1;

$target_dir = "../assets/";
$target_file = $target_dir . basename($_FILES["image"]["name"]);


if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {


    $dbpath = 'assets/' . basename($_FILES["image"]["name"]);

    $sql = "UPDATE challenges SET image='$dbpath' WHERE  id='$id' ";
    $run = mysqli_query($conn, $sql);
    if ($run) {
        $sql = "SELECT * FROM challenges WHERE id='$id'";
        $run = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($run)) {
            $created_by_user_id = $row['created_by_user_id'];
            $id = $row['id'];
            $challenge_type = $row['challenge_type'];
            $challenge_visibility = $row['challenge_visibility'];

            $name = $row['name'];
            $id = $row['id'];
            $image = $row['image'];
            $challenge_type = $row['challenge_type'];
            $challenge_privacy = $row['challenge_privacy'];

            $start_date = $row['start_date'];
            $end_date = $row['end_date'];
            $challenge_metric_no = $row['challenge_metric_no'];
            $challenge_metric_step_type = $row['challenge_metric_step_type'];
            $login = 1;
            break;
        }
        if ($login == 1) {
            $response[] = array(
                'message' => 'Image Updated Successfully',
                'name' => $name, 'created_by_user_id' => $created_by_user_id,
                'challenge_type' => $challenge_type,
                'challenge_visibility' => $challenge_visibility,
                'challenge_privacy' => $challenge_privacy,
                'start_date' => $start_date,
                'Image' => $image,
                'end_date' => $end_date,
                'challenge_metric_no' => $challenge_metric_no,
                'error' => false
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
            "error" => true,
        );
        echo json_encode($response);
    }
} else {

    $response[] = array(
        "message" => 'Image not uploaded',
        "error" => true,
    );
    echo json_encode($response);
}
