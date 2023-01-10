<?php
include('../include/connection.php');
$EncodeData = file_get_contents('php://input');
$data = json_decode($EncodeData, true);
$from_id = $data['user_id'];
$to_id = $data['to_id'];
$date = $data['date'];

$uniqid = uniqid();
$noti_type = "friends to friends";


$sql = "Insert into notification (noti_type,uniqid,from_id,to_id,date,status) Values ('{$noti_type}','{$uniqid}','{$from_id}','{$to_id}','$date','unread')";

if (mysqli_query($conn, $sql)) {
    if ($noti_type = "friends to friends") {
        $sql1 = "SELECT * from notification where uniqid='$uniqid'";
        $result2 = mysqli_query($conn, $sql1);
        if ($result2) {
            while ($row = mysqli_fetch_assoc($result2)) {
                $id = $row['id'];
            }
        }
        $sql = "Insert into friends_notifications(noti_type_id,status,date) Values ('{$id}','requested','$date')";
        $result = mysqli_query($conn, $sql);
    }
    $sql1 = "Insert into friend_list(this_user_id,friend_user_id,date,status,noti_type_id) Values ('{$from_id}','{$to_id}','{$date}','requested','{$id}')";

    $query = mysqli_query($conn, $sql1);
    if ($query) {
        echo json_encode(array('from_id' => $from_id, 'your_frnd_id' => $to_id, 'message' => 'friend request sent', 'Notification id' => $id,  'error' => false, 'date' => $date));
    }
} else {
    echo json_encode(array('message' => 'Not Sent', 'error' => true));
}
