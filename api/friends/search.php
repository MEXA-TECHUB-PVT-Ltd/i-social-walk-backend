<?php

$data = json_decode(file_get_contents("php://input"), true);

header('Content-Type: application/json');
$name = $data['name'];
$this_user_id = $data['this_user_id'];
include('../include/connection.php');
$sql = "Select * from friend_list WHERE  this_user_id='$this_user_id' AND status='friends'";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $sql_f = "SELECT * FROM users WHERE first_name LIKE '%$name%' OR last_name LIKE '%$name%'";
        $result_f = mysqli_query($conn, $sql_f);
        while ($row_f = mysqli_fetch_assoc($result_f)) {
            if ($row['friend_user_id'] == $row_f['id']) {
                $response[] = array(
                    "f_id" => $row_f['id'],
                    "first_name" => $row_f['first_name'],
                    "last_name" => $row_f['last_name'],
                    "profile_image" => $row_f['profile_image'],
                );
                break;
            }
        }
    }


    if (empty($response)) {
        $response[] = array(
            "message" => "No friends found of this name",
            "error" => true,
        );
    }
} else {
    $response = array(

        "error" => false,
        "message" => 'empty friend list',
    );
}

// }
echo json_encode($response);
