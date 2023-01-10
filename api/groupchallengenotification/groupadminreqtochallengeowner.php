<?php
include('../include/connection.php');
$data = json_decode(file_get_contents("php://input"), true);
$noti_type_id = $data['noti_type_id'];
$uniqid = uniqid();
$date = $data['date'];
$noti_type = "group admin to challenge owner";
$sqlfinal = "SELECT *
FROM notification
INNER JOIN challenges_groups
ON notification.id = challenges_groups.noti_type_id where noti_type_id='$noti_type_id'";
$finalquery = mysqli_query($conn, $sqlfinal);
while ($row = mysqli_fetch_assoc($finalquery)) {
    $challengeid = $row['challenge_id'];
    $groupid = $row['group_id'];
    $fromid = $row['to_id']; //group admin id
}
//fetching created by user id of challenge
$sqlfinchallenge = "SELECT * from challenges where id='$challengeid'";
$query = mysqli_query($conn, $sqlfinchallenge);
if ($query) {
    while ($row = mysqli_fetch_assoc($query)) {
        $created_by_user_id = $row['created_by_user_id'];
    }
}
//$created_by_user_id 
$sqladmin = "Insert into notification(noti_type,uniqid,from_id,to_id,date,status)VALUES
('$noti_type','$uniqid','$fromid','$created_by_user_id','$date','unread')";
$querynew = mysqli_query($conn, $sqladmin);
if ($querynew) {
    $sqlfinal = "select * from notification where uniqid='$uniqid'";
    $queryfinal = mysqli_query($conn, $sqlfinal);
    while ($row = mysqli_fetch_assoc($queryfinal)) {
        $noti_type_id = $row['id'];
    }
    $sqlfinal1 = "Insert into challenges_groups(noti_type_id,challenge_id,group_id,status)
    VALUES('$noti_type_id','$challengeid','$groupid','requested')";

    $queryfinal1 = mysqli_query($conn, $sqlfinal1);
    if ($queryfinal1) {
        $response = array(
            "message" => "group admin sent request to challenge owner",
            "notification_id" => "$noti_type_id",
            "error" => true,
            "group_id" => $groupid,
            "groupadmin" => $fromid,
            "challenge admin" => $created_by_user_id,
        );
    }
}
echo json_encode($response);
