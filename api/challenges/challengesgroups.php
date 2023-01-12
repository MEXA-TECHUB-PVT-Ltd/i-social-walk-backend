<?php
include('../include/connection.php');
include('../include/functions.php');
$EncodeData = file_get_contents('php://input');
$data = json_decode($EncodeData, true);
$challenge_id = $data['challenge_id'];
$group_id = $data['group_id'];

$date = $data['date'];
$noti_type = "challenge admin to user";
$uniqid = uniqid();
$sql = "SELECT * from user_groups where id='$group_id'";
$query = mysqli_query($conn, $sql);
if (mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_assoc($query)) {
        $created_by_user_id = $row['created_by_user_id'];
        $id = $row['id'];
        $groupname = $row['name'];
        $groupimage = $row['image'];
        $group_privacy = $row['group_privacy'];
        $group_visibility = $row['group_visibility'];
        $created_at = $row['created_at'];
    }

    $sqlquery = "select * from challenges where id='$challenge_id'";
    $query3 = mysqli_query($conn, $sqlquery);
    if (mysqli_num_rows($query3)) {
        if ($query3) {
            while ($row3 = mysqli_fetch_assoc($query3)) {
                $challengename = $row3['name'];
                $challengeimage = $row3['image'];
                $user_id = $row3['created_by_user_id'];
                $user_name_challenge = getname($user_id);
                $profile_image = $row3['image'];
                $challenge_type = $row3['challenge_type'];
                $challenge_visibility = $row3['challenge_visibility'];
                $challenge_privacy = $row3['challenge_privacy'];
                $start_date = $row3['start_date'];
                $end_date = $row3['end_date'];
            }
            if ($challenge_type != 'indiviual ') {


                $sql = "SELECT user_id from group_member where group_id='$group_id' AND user_id!='$user_id'";
                $query = mysqli_query($conn, $sql);
                if ($query) {
                    while ($row = mysqli_fetch_assoc($query)) {
                        $r[] = $row['user_id'];
                    }
                    foreach ($r as $user_id_list) {
                        $sql3 = "INSERT Into  notification(noti_type,uniqid,from_id,to_id,date,status)VALUES('$noti_type','$uniqid','$user_id','$user_id_list','$date','unread')";
                        $query = mysqli_query($conn, $sql3);
                        $sql = "Insert into challenges_participants(challenge_id,user_id,status) Values ('{$challenge_id}','{$user_id_list}','membered')";
                        $queryfinal = mysqli_query($conn, $sql);
                        if ($queryfinal) {

                            $queryrun = "SELECT * from notification where uniqid='$uniqid'";
                            $querynot = mysqli_query($conn, $queryrun);
                            if ($querynot) {
                                while ($rownot = mysqli_fetch_assoc($querynot)) {
                                    $noti_type_id = $rownot['id'];
                                }
                                $sqlfinal = "INSERT into challenges_groups(noti_type_id,challenge_id,group_id,status)VALUES('$noti_type_id','$challenge_id','$group_id','membered')";
                                $querychallenge_groups = mysqli_query($conn, $sqlfinal);
                            }

                            $response[] = array(
                                "from id" => $user_id,
                                "to id" => $user_id_list,
                                "Group Name " => $groupname,
                                "Challenge owner name" => $user_name_challenge,

                                "Group Image " => $groupimage,

                                "Challenge Name " => $challengename,
                                "Created by User Id of Challenge " =>   $created_by_user_id,
                                "Challenge Image" => $challengeimage,
                                "Challenge Name " => $challengename,
                                "Challenge Visibility " => $challenge_visibility,
                                "error" => true
                            );
                        }
                    }
                }
            }
        }
    }
} else {
    $response = array(
        "message" => 'This challenge doesnot exist',
        "error" => true
    );
}

echo json_encode($response);
