<?php
include('../include/connection.php');
include('../include/functions.php');
$EncodeData = file_get_contents('php://input');
$data = json_decode($EncodeData, true);
$challenge_id = $data['challenge_id'];
$group_id = $data['group_id'];
$User_id = $data['user_id'];
$date = $data['date'];
$noti_type = "user to group admin for challenge joining";
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
    $sql = "select * from users where id='$created_by_user_id'";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        while ($row1 = mysqli_fetch_assoc($query)) {
            $first_name = $row1['first_name'];
            $last_name = $row1['last_name'];
            $profile_image = $row1['profile_image'];
            $active_watch = $row1['active_watch'];
        }
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
                $sql = "INSERT Into  notification(noti_type,uniqid,from_id,to_id,date,status)VALUES('$noti_type','$uniqid','$User_id','$created_by_user_id','$date','unread')";
                $query = mysqli_query($conn, $sql);
                if ($query) {

                    $response[] = array(
                        " message" => $first_name . ' ' . $last_name . 'sent you request to join challlenge' . $user_name_challenge,
                        "error" => false,


                    );
                    $queryrun = "SELECT * from notification where uniqid='$uniqid'";
                    $querynot = mysqli_query($conn, $queryrun);
                    if ($querynot) {
                        while ($rownot = mysqli_fetch_assoc($querynot)) {
                            $noti_type_id = $rownot['id'];
                        }
                        $sql = "INSERT into challenges_groups(noti_type_id,challenge_id,group_id,status)VALUES('$noti_type_id','$challenge_id','$group_id','requested')";
                        $querychallenge_groups = mysqli_query($conn, $sql);
                        if ($querychallenge_groups) {
                        }
                    }
                }
                $sql = "SELECT user_id from group_member where group_id='$group_id'";
                $query = mysqli_query($conn, $sql);
                if ($query) {
                    while ($row = mysqli_fetch_assoc($query)) {
                        $r[] = $row['user_id'];
                    }
                    foreach ($r as $user_id_list) {
                        $sql = "Insert into challenges_participants(challenge_id,user_id,status) Values ('{$challenge_id}','{$user_id_list}','membered')";
                        $query = mysqli_query($conn, $sql);
                        if ($query) {
                        }
                    }
                }

                $response[] = array(
                    "from id" => $User_id,
                    "to id" => $created_by_user_id,
                    "Group Name " => $groupname,
                    "Challenge owner name" => $user_name_challenge,

                    "Group Image " => $groupimage,
                    "First Name " => $first_name,
                    "Last Name " => $last_name,
                    "Profile Image " => $profile_image,
                    "Active Watch " => $active_watch,
                    "Challenge Name " => $challengename,
                    "Created by User Id of Challenge " =>   $created_by_user_id,
                    "Active Watch " => $active_watch,
                    "Challenge Image" => $challengeimage,
                    "Challenge Name " => $challengename,
                    "Challenge Visibility " => $challenge_visibility,
                    "error" => true
                );
            } else {
                $response = array(
                    "message" => 'This challenge is indiviual',
                    "error" => true
                );
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
