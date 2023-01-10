<?php
include('../include/functions.php');
include('../include/connection.php');
$EncodeData = file_get_contents('php://input');
$data = json_decode($EncodeData, true);
$group_id = $data['group_id'];
$user_id = $data['user_id'];
$date = $data['date'];

$sql = "SELECT * from user_groups where id='$group_id'";

$result = mysqli_query($conn, $sql);
$rowcount = mysqli_num_rows($result);
if ($rowcount > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $name = $row['name'];
        $group_privacy = $row['group_privacy'];
        $created_at = $row['created_at'];
        $group_visibility = $row['group_visibility'];
        $created_by_user_id = $row['created_by_user_id'];
        $image = $row['image'];
    }
    if ($group_privacy == "private") {

        $noti_type = "user to group";
        $uniqid = uniqid();

        $sql1 = "Insert into notification(noti_type,uniqid,from_id,to_id,date,status) Values ('$noti_type','$uniqid','$user_id','$created_by_user_id','$date','unread')";
        $result = mysqli_query($conn, $sql1);
        if ($result) {
            $sql1 = "SELECT * from notification where uniqid='$uniqid'";
            $result2 = mysqli_query($conn, $sql1);
            if ($result2) {
                while ($row = mysqli_fetch_assoc($result2)) {
                    $id = $row['id'];
                }
            }
        }
        $name = getname($user_id);
        $sql = "Insert into group_notification(noti_type_id,group_id,status,created_date) Values ('{$id}','{$group_id}','requested','$date')";
        $result = mysqli_query($conn, $sql);
        $sql = "Insert into group_member(group_id,user_id,status,created_at) Values ('{$group_id}','{$user_id}','requested','$date')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            if ($result) {
                $response[] = array(
                    'message' => 'Request for group Sended',
                    'error' => 'false',
                    'Notification id' => $id,
                    'name' => $name,

                    'User Name' => $name,
                    'group_visibility' => $group_visibility,
                    'created_at' => $created_at,
                    'created_by_user_id' => $created_by_user_id,
                    'image' => $image,
                    'group_privacy' => $group_privacy,



                );
            }
        }
    } else {
        $sql = "Insert into group_member(group_id,user_id,status,created_at) Values ('{$group_id}','{$user_id}','membered','$date')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $response[] = array(
                'message' => 'joined group',
                'error' => 'false',
                'name' => $name,
                'created_at' => $created_at,
                'created_by_user_id' => $created_by_user_id,
                'image' => $image,
                'group_visibility' => $group_visibility,
                'group_privacy' => $group_privacy,



            );
        }
        $noti_type = "user to group";
        $uniqid = uniqid();
        $name = getname($user_id);

        $sql1 = "Insert into notification(noti_type,uniqid,from_id,to_id,date,status) Values ('$noti_type','$uniqid','$user_id','$created_by_user_id','$date','unread')";
        $result = mysqli_query($conn, $sql1);
        if ($result) {
            $sql1 = "SELECT * from notification where uniqid='$uniqid'";
            $result2 = mysqli_query($conn, $sql1);
            if ($result2) {
                while ($row = mysqli_fetch_assoc($result2)) {
                    $notificationid = $row['id'];
                }
            }
            $response[] = array(
                'message' => $name . 'joined your group',
                'error' => 'false',
                'userid' => $user_id,
                'Notification id' => '$notificationid',
                'User Name' => $name,
                'created_at' => $created_at,
                'created_by_user_id' => $created_by_user_id,




            );
        }
    }
} else {
    $response[] = array(
        'message' => 'This group does not  Exist',
        'error' => 'true',



    );
}
echo json_encode($response);
