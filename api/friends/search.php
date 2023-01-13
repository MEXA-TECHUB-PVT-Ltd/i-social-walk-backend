<?php

$data = json_decode(file_get_contents("php://input"), true);
include('../include/connection.php');
header('Content-Type: application/json');
$name = $data['name'];
$this_user_id = $data['this_user_id'];

$sql = "Select * from users WHERE first_name LIKE '%$name%' OR last_name LIKE '%$name%' AND id != $this_user_id";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row_f = mysqli_fetch_assoc($result)) {
        $id = $row_f['id'];
        $SQL_FINAL = "select * from friend_list  where this_user_id='$this_user_id' AND friend_user_id='$id' ";

        $sqa = mysqli_query($conn, $SQL_FINAL);
        if (mysqli_num_rows($sqa) > 0) {
            while ($row = mysqli_fetch_assoc($sqa)) {
                $response[] = array(
                    "status" => $row['status'],
                    "f_id" => $row_f['id'],
                    "first_name" => $row_f['first_name'],
                    "last_name" => $row_f['last_name'],
                    "active_watch" => $row_f['active_watch'],
                    "profile_image" => $row_f['profile_image'],
                    "phoneno" => $row_f['phoneno'],
                );
                break;
            }
        } else {

            $response[] = array(
                "status" => "Not Friends",
                "f_id" => $row_f['id'],
                "first_name" => $row_f['first_name'],
                "last_name" => $row_f['last_name'],
                "profile_image" => $row_f['profile_image'],
                "phoneno" => $row_f['phoneno'],
            );
            break;
        }
    }
} else {
    $response = array(

        "error" => false,
        "message" => 'NO person Found of this name',
    );
}

// }
echo json_encode($response);
