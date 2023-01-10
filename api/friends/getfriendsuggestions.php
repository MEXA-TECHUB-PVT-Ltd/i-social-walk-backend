<?php

header('Content-Type: application/json');

include('../include/connection.php');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);
$this_user_id = $DecodeData['this_user_id'];
$sql = "SELECT * 
FROM users 
WHERE id !='$this_user_id' 
ORDER BY RAND()";

$run = mysqli_query($conn, $sql);
if (mysqli_num_rows($run)) {
    while ($row = mysqli_fetch_assoc($run)) {
        $friend_user_id = $row['id'];

        $query = "Select * from friend_list where this_user_id='$this_user_id' AND friend_user_id='$friend_user_id'";
        $run2 = mysqli_query($conn, $query);
        if (mysqli_num_rows($run2) <= 0) {
            $id = $row['id'];
            $last_name = $row['last_name'];
            $profile_image = $row['profile_image'];
            $firstname = $row['first_name'];
            $active_watch = $row['active_watch'];

            $response[] = array(
                "Friend ID" => $id,
                "First Name" =>  $firstname,
                "lastname" => $last_name,
                "status" => 'friend for suggestions',
                "image" => $profile_image,
                "active watch" => $active_watch,
                "error" => false,
            );
        }
    }
    if (empty($response)) {
        $response[] = array(
            "message" => "you are added in all users",
            "error" => true,
        );
    }
}



echo json_encode($response);
