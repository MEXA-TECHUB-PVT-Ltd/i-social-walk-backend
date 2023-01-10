<?php

include('../include/connection.php');
$data = json_decode(file_get_contents("php://input"), true);

$challenge_id = $data['challenge_id'];
$sql = "Select * from users";
$finalquery = mysqli_query($conn, $sql);
if (mysqli_num_rows($finalquery) > 0) {
    while ($row = mysqli_fetch_assoc($finalquery)) {
        $id = $row['id'];

        $sql2 = "Select * from challenges_participants where challenge_id='$challenge_id' and user_id='$id'";

        $result = mysqli_query($conn, $sql2);
        if (mysqli_num_rows($result) <= 0) {
            $output[] = array(
                "User id" => $row['id'],
                "First Name" => $row['first_name'],
                "Last Name" => $row['last_name'],
                "Profile Image" => $row['profile_image'],
            );
        }
    }
    if (empty($output)) {
        $output[] = array(
            "message" => "All users are added in this challenge",
            "error" => true,
        );
    }
} else {
    $output[] = array(
        "message" => "No Users Exists in this challenge",
        "error" => true,
    );
}
echo json_encode(array('error' => true, 'Challenges' => $output));
