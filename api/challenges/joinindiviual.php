<?php


include('../include/connection.php');

$noti_type = "user to join indiviual challenge";
//id is the group id
//userid the one who wants to join 
$EncodeData = file_get_contents('php://input');
$data = json_decode($EncodeData, true);
$challenge_id = $data['challenge_id'];
$user_id = $data['user_id'];
$date = $data['date'];

$sql1 = "SELECT * from challenges where id='$challenge_id'";

$result1 = mysqli_query($conn, $sql1);
if (mysqli_num_rows($result1) > 0) {
    while ($row = mysqli_fetch_assoc($result1)) {
        $name = $row['name'];
        $image = $row['image'];
        $challenge_type = $row['challenge_type'];
        $created_by_user_id = $row['created_by_user_id'];
        $challenge_privacy = $row['challenge_privacy'];
        $start_date = $row['start_date'];
        $end_date = $row['end_date'];
        $challenge_metric_no = $row['challenge_metric_no'];
        $challenge_metric_step_type = $row['challenge_metric_step_type'];

        if ($challenge_privacy == "private") {


            $uniqid = uniqid();

            $sql2 = "Insert into notification(noti_type,uniqid,from_id,to_id,date,status) Values ('$noti_type','$uniqid','$user_id','$created_by_user_id','$date','unread')";
            $result2 = mysqli_query($conn, $sql2);
            if ($result2) {

                $sql3 = "SELECT * from notification where uniqid='$uniqid'";
                $result3 = mysqli_query($conn, $sql3);
                if ($result3) {
                    while ($row = mysqli_fetch_assoc($result3)) {
                        $id = $row['id'];
                    }
                }
                $sql4 = "Insert into individual_challenge_notification(noti_type_id,challenge_id,status,created_date) Values ('{$id}','{$challenge_id}','requested','$date')";
                $result4 = mysqli_query($conn, $sql4);
                $sql5 = "Insert into challenges_participants(challenge_id,user_id,status) Values ('{$challenge_id}','{$user_id}','requested')";
                $result5 = mysqli_query($conn, $sql5);
                if ($result5) {
                    $response[] = array(
                        'message' => 'Request for Challenge Sended',
                        'error' => 'false',
                        'name' => $name,
                        'image' => $image,
                        'user_id' => $user_id,
                        'created_by_user_id' => $created_by_user_id,

                        'start_date' => $start_date

                    );
                }
            }
        } else {
            $sql = "Insert into challenges_participants(challenge_id,user_id,status) Values ('{$challenge_id}','{$user_id}','membered')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $response[] = array(
                    'message' => 'Challenge Joined',
                    'error' => 'false',
                    'name' => $name,
                    'created_at' => $date,
                    'created_by_user_id' => $created_by_user_id,
                    'image' => $image




                );
            }


            $uniqid = uniqid();

            $sql7 = "Insert into notification(noti_type,uniqid,from_id,to_id,date,status) Values ('$noti_type','$uniqid','$user_id','$created_by_user_id','$date','unread')";
            $result7 = mysqli_query($conn, $sql7);
            if ($result7) {

                $sql8 = "SELECT * from notification where uniqid='$uniqid'";
                $result8 = mysqli_query($conn, $sql8);
                if ($result8) {
                    while ($row8 = mysqli_fetch_assoc($result8)) {
                        $id = $row8['id'];
                    }
                }
                $sql = "Insert into individual_challenge_notification(noti_type_id,challenge_id,status,created_date) Values ('{$id}','{$challenge_id}','membered','$date')";
                $result6 = mysqli_query($conn, $sql);
                if ($result6) {
                    $response[] = array(
                        'message' => 'User ' . $user_id . 'Joined your Challenge admin ' . $created_by_user_id,
                        'error' => 'false',
                        'Notification id' => $id,
                        'name' => $name,
                        'image' => $image,
                        'user_id' => $user_id,
                        'created_by_user_id' => $created_by_user_id,

                        'start_date' => $start_date

                    );
                }
            }
        }
    }
} else {
    $response[] = array(
        'message' => 'This Challenge Does not Exists',
        'error' => true
    );
}
echo json_encode($response);
