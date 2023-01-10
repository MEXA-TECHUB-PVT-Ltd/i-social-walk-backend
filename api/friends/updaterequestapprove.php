<?php
include('../include/connection.php');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);
$this_user_id = $DecodeData['this_user_id'];
$friend_user_id = $DecodeData['friend_user_id'];
$noti_type_id = $DecodeData['noti_type_id'];
$date = $DecodeData['date'];

$sql = "UPDATE friends_notifications SET status='friends' WHERE noti_type_id='$noti_type_id'";

$run1 = mysqli_query($conn, $sql);

$sql = "UPDATE friend_list SET status='friends' WHERE this_user_id='$friend_user_id' AND friend_user_id='$this_user_id'";

$run1 = mysqli_query($conn, $sql);
if ($run1) {
    $sqlquery = "INSERT INTO friend_list (this_user_id,friend_user_id,date,status,noti_type_id)VALUES('$this_user_id','$friend_user_id','$date','friends','$noti_type_id')";
    $runquery = mysqli_query($conn, $sqlquery);
    $response[] = array(
        "your id" => $this_user_id,
        "friend id" => $friend_user_id,
        "message" => 'friend Added in your friend list ',


        "error" => false


    );
} else {
    $response[] = array(
        "message" => 'Not Added',
        "error" => true
    );
}

$noti_type = "friends to friends";
$uniqid1 = uniqid();

$sqlquery = "insert into notification(noti_type,uniqid,from_id,to_id,date,status) VALUES ('$noti_type','$uniqid1','$this_user_id','$friend_user_id','$date','unread')";

$run3 = mysqli_query($conn, $sqlquery);
if ($run3) {
    $sqlfinal = "Select * from notification where uniqid='$uniqid1'";
    $runfinal = mysqli_query($conn, $sqlfinal);
    if ($runfinal) {
        while ($row = mysqli_fetch_assoc($runfinal)) {
            $id = $row['id'];
            $response[] = array(
                "to_id" => $row['to_id'],
                "from_id" => $row['from_id'],

                "Notification id" => $row['id'],

                "message" => 'Friend Request Accepted ',
                "error" => false
            );
        }
        $newquery = "Insert into friends_notifications(noti_type_id,date,status)Value('$id','$date','approved')";
        $finalquery = mysqli_query($conn, $newquery);
        if ($finalquery) {
        }
    }
}
// $final = "Insert into friends_notifications(noti_type_id,date,status)Values('$uniqid1','$date','approved')";
// $queryfinal1 = mysqli_query($conn, $final);
// if ($queryfinal1) {
//     while ($row1 = mysqli_fetch_assoc($queryfinal1)) {
//         $response[] = array(

//             "Notification id" => $row1['noti_type_id'],

//             "message" => 'Friend Request Accepted ',
//             "error" => false
//         );
//     }
// }
echo json_encode($response);
