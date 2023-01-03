<?php
session_start();

header('Content-Type: application/json');

include('../include/connection.php');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);
$this_user_id = $DecodeData['this_user_id'];
$sql = "Select * from friend_list WHERE this_user_id='$this_user_id' AND status='friends'";

$run = mysqli_query($conn, $sql);
if (mysqli_num_rows($run)) {
    while ($row = mysqli_fetch_assoc($run)) {
        $friend_user_id = $row['friend_user_id'];

        $query = "Select * from users where id='$friend_user_id'";
        $run2 = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($run2)) {

            $profile[] = array(
                "id" => $row['id'],
                "first_name" => $row['first_name'],
                "last_name" => $row['last_name'],
                "profile_image" => $row['profile_image'],
                "active_watch" => $row['active_watch'],
                "phoneno" => $row['phoneno'],
                "createdat" => $row['created_at'],
            );
        }
    }
    $response[] = array(


        "profile" => $profile,
    );
} else {
    $response[] = array(


        "profile" => 'No Friends',
    );
}



echo json_encode($response);
