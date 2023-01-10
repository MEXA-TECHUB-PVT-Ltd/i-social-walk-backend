<?php
include('../include/connection.php');

$EncodeData = file_get_contents('php://input');
$data = json_decode($EncodeData, true);
$created_by_user_id = $data['created_by_user_id'];
$name = $data['name'];
$challenge_type = $data['challenge_type'];
$challenge_visibility = $data['challenge_visibility'];
$challenge_privacy = $data['challenge_privacy'];
$start_date = $data['start_date'];
$end_date = $data['end_date'];
$challenge_metric_no = $data['challenge_metric_no'];

$challenge_metric_step_type = $data['challenge_metric_step_type'];
$sql = "SELECT * FROM users WHERE  id='$created_by_user_id' ";
$resultquery = mysqli_query($conn, $sql);
$rowcount = mysqli_num_rows($resultquery);
if ($rowcount > 0) {
    while ($row = mysqli_fetch_assoc($resultquery)) {
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $profile_image = $row['profile_image'];
        $email = $row['email'];
    }
}

$sql = "Insert into challenges(created_by_user_id,name,challenge_type,challenge_visibility,challenge_privacy,start_date,end_date,challenge_metric_no,challenge_metric_step_type) Values ('{$created_by_user_id}','{$name}','{$challenge_type}','{$challenge_visibility}','{$challenge_privacy}','{$start_date}','{$end_date}','{$challenge_metric_no}','{$challenge_metric_step_type}')";

if (mysqli_query($conn, $sql)) {
    $sql = "SELECT * from challenges where  created_by_user_id='$created_by_user_id' ORDER BY id desc limit 1";
    $group_query = mysqli_query($conn, $sql);
    if ($group_query) {
        while ($row = mysqli_fetch_assoc($group_query)) {
            $id = $row['id'];
        }
    }
    $sqlqueryfinal = "Insert into challenges_participants(challenge_id,user_id,status)VALUES('$id','$created_by_user_id','membered')";
    $queryfinal = mysqli_query($conn, $sqlqueryfinal);
    if ($queryfinal) {

        echo json_encode(array(
            'challenge id' => $id,
            'name' => $name,
            'created_by_user_id'
            => $created_by_user_id,
            'challenge_type' => $challenge_type,
            'challenge_visibility' => $challenge_visibility,
            'challenge_privacy' => $challenge_privacy,
            'challenge_privacy' => $challenge_privacy,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'challenge_metric_no' => $challenge_metric_no,
            'First Name' =>
            $first_name, 'Last Name' => $last_name,
            'profile_image' => $profile_image,
            'email' => $email,
            'message' => 'Challenge Created Successfully ', 'error' => false
        ));
    }
} else {
    echo json_encode(array('message' => 'Not Created', 'error' => true));
}
