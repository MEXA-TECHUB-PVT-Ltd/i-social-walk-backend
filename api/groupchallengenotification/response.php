<?php
include('../include/connection.php');
$data = json_decode(file_get_contents("php://input"), true);
$noti_type_id = $data['noti_type_id'];
$uniqid = uniqid();
$date = $data['date'];
$status = $data['status'];
$noti_type = "group challenge response";

$sqlfinal = "SELECT *
FROM notification
INNER JOIN challenges_groups
ON notification.id = challenges_groups.noti_type_id where noti_type_id='$noti_type_id'";

$finalquery = mysqli_query($conn, $sqlfinal);
while ($row = mysqli_fetch_assoc($finalquery)) {
    $challengeid = $row['challenge_id'];
    $group_id = $row['group_id'];
    $groupadmin = $row['from_id'];
}
//fetching created by user id of challenge
$sqlfinchallenge = "SELECT * from challenges where id='$challengeid'";
$query = mysqli_query($conn, $sqlfinchallenge);
if ($query) {
    while ($row = mysqli_fetch_assoc($query)) {
        $created_by_user_id = $row['created_by_user_id'];
    }
}

$sqlupdate = "Update challenges_groups SET status='$status' where noti_type_id='$noti_type_id'";
$sqlfinal = mysqli_query($conn, $sqlupdate);


if ($status == "membered") {

    $sql = "SELECT user_id from group_member where group_id='$group_id'";

    $query = mysqli_query($conn, $sql);
    if ($query) {
        $r = array();
        while ($row = mysqli_fetch_assoc($query)) {
            $r[] = $row['user_id'];
        }
        if (count($r) > 0) {
            foreach ($r as $user_id_list) {

                $sql = "Insert into challenges_participants(challenge_id,user_id,status) Values ('{$challengeid}','{$user_id_list}','membered')";
                $query = mysqli_query($conn, $sql);
                if ($query) {
                    $response[] = array(
                        "message" => "challenge admin accepted your requested",
                        "notification_id" => "$noti_type_id",
                        "error" => true,
                        "group_id" => $group_id,
                        "groupadmin" => $groupadmin,
                        "challenge admin" => $created_by_user_id,
                    );
                }
            }

            foreach ($r as $user_id_list) {
                $uniqid1 = uniqid();
                $sqladmin = "Insert into notification(noti_type,uniqid,from_id,to_id,date,status)VALUES
        ('$noti_type','$uniqid1','$created_by_user_id','$user_id_list','$date','unread')";

                $queryfinal11 = mysqli_query($conn, $sqladmin);
                $finalsql = "select * from notification where uniqid='$uniqid1'";
                $Query = mysqli_query($conn, $finalsql);
                while ($row = mysqli_fetch_assoc($Query)) {
                    $noti_type_id = $row['id'];

                    $sqlfinal1 = "Insert into challenges_groups(noti_type_id,challenge_id,group_id,status)
        VALUES('$noti_type_id','$challengeid','$group_id','$status')";
                    $f_query = mysqli_query($conn, $sqlfinal1);
                    if ($f_query) {
                    }
                }
            }
        }
    } else {
        if ($queryfinal) {
            $response = array(
                "message" => "request cancelled",
                "noti_type_id" => $noti_type_id,
                "group_admin" => $groupadmin,
                'message' => 'challenge owner acception of group request',
            );
        }
    }
}

$response[] = array(
    "message" => "Not Added in group ",
    "noti_id" => $noti_type_id,
    'message' => 'challenge owner cancelation of group request',
    "error" => true,
);

echo json_encode($response);
