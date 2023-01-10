<?php
include('../include/connection.php');
$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'];
$sql = "Select * from notification where id='$id' ";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) {
        $noti_type = $row['noti_type'];

        if ($noti_type == 'friends to friends') {
            $sql1 = "
            SELECT *
            FROM notification
            INNER JOIN friends_notifications
            ON notification.id = friends_notifications.noti_type_id where noti_type_id='$id'";

            $result1 = mysqli_query($conn, $sql1);
            while ($row1 = mysqli_fetch_assoc($result1)) {
                $responsequery[] = array(
                    'to_id' => $row1['to_id'],
                    'from_id' => $row1['from_id'],
                    'staus' => $row1['status'],
                    'date' => $row1['date'],
                );
            }
        } elseif ($noti_type == 'admin to user for challenges') {

            $sql0 = "
            SELECT *
FROM notification
INNER JOIN individual_challenge_notification
ON notification.id = individual_challenge_notification.noti_type_id where noti_type_id='$id'";

            $result0 = mysqli_query($conn, $sql0);
            while ($row0 = mysqli_fetch_assoc($result0)) {
                $responsequery[] = array(
                    'challenge_id' => $row0['challenge_id'],
                    'status' => $row0['status'],
                    'to_id' => $row0['to_id'],
                    'from_id' => $row0['from_id'],
                    'created_date' => $row0['created_date'],
                    'noti_type_id' => $row0['noti_type_id'],
                );
            }
        } elseif ($noti_type == 'user to group') {

            $sql2 = "
            SELECT *
FROM notification
INNER JOIN group_notification
ON notification.id = group_notification.noti_type_id where noti_type_id='$id'";

            $result2 = mysqli_query($conn, $sql2);
            while ($row2 = mysqli_fetch_assoc($result2)) {
                $responsequery[] = array(
                    'group_id' => $row2['group_id'],
                    'status' => $row2['status'],
                    'to_id' => $row2['to_id'],
                    'from_id' => $row2['from_id'],
                    'created_date' => $row2['created_date'],
                    'noti_type_id' => $row2['noti_type_id'],
                );
            }
        } elseif ($noti_type == 'admin to indiviual challenge acception') {
            $noti_type;
            $sqlqu = "SELECT *
            FROM notification
            INNER JOIN individual_challenge_notification
            ON notification.id = individual_challenge_notification.noti_type_id where noti_type_id='$id'";

            $resultqu = mysqli_query($conn, $sqlqu);
            while ($rowqu = mysqli_fetch_assoc($resultqu)) {
                $responsequery[] = array(
                    'challenge_id' => $rowqu['challenge_id'],
                    'status' => $rowqu['status'],
                    'to_id' => $rowqu['to_id'],
                    'from_id' => $rowqu['from_id'],
                    'created_date' => $rowqu['created_date'],
                    'noti_type_id' => $rowqu['noti_type_id'],
                    'status' => $rowqu['status'],
                    'challenge_id' => $rowqu['challenge_id'],
                    'noti_type_id' => $rowqu['noti_type_id'],
                );
            }
        } elseif ($noti_type == 'user to join indiviual challenge') {
            $noti_type;
            $sqlnew = "SELECT *
            FROM notification
            INNER JOIN individual_challenge_notification
            ON notification.id = individual_challenge_notification.noti_type_id where noti_type_id='$id'";

            $resultnew = mysqli_query($conn, $sqlnew);
            while ($rownew = mysqli_fetch_assoc($resultnew)) {
                $responsequery[] = array(
                    'challenge_id' => $rownew['challenge_id'],
                    'status' => $rownew['status'],
                    'to_id' => $rownew['to_id'],
                    'from_id' => $rownew['from_id'],
                    'created_date' => $rownew['created_date'],
                    'noti_type_id' => $rownew['noti_type_id'],
                    'status' => $rownew['status'],
                    'challenge_id' => $rownew['challenge_id'],
                    'noti_type_id' => $rownew['noti_type_id'],
                );
            }
        } elseif ($noti_type == 'group admin to user') {
            $noti_type;

            $sql4 = "SELECT *
FROM notification
INNER JOIN group_notification
ON notification.id = group_notification.noti_type_id where noti_type_id='$id'";



            $result4 = mysqli_query($conn, $sql4);
            while ($row4 = mysqli_fetch_assoc($result4)) {
                $responsequery[] = array(
                    'group_id' => $row4['group_id'],
                    'status' => $row4['status'],
                    'to_id' => $row4['to_id'],
                    'from_id' => $row4['from_id'],
                    'created_date' => $row4['created_date'],
                    'noti_type_id' => $row4['noti_type_id'],
                );
            }
        } elseif ($noti_type == 'user to group admin for challenge joining') {
            $noti_type;

            $sqlgroupch = "SELECT *
FROM notification
INNER JOIN challenges_groups
ON notification.id = challenges_groups.noti_type_id where noti_type_id='$id'";



            $resultgroupch = mysqli_query($conn, $sqlgroupch);
            while ($rowgroupch = mysqli_fetch_assoc($resultgroupch)) {
                $responsequery[] = array(
                    'group_id' => $rowgroupch['group_id'],
                    'challenge_id' => $rowgroupch['challenge_id'],
                    'status' => $rowgroupch['status'],
                    'to_id' => $rowgroupch['to_id'],
                    'from_id' => $rowgroupch['from_id'],

                    'noti_type_id' => $rowgroupch['noti_type_id'],
                );
            }
        } elseif ($noti_type == 'group admin to challenge owner') {
            $noti_type;

            $sqlgroupadmin = "SELECT *
FROM notification
INNER JOIN challenges_groups
ON notification.id = challenges_groups.noti_type_id where noti_type_id='$id'";



            $resultgroupadmin = mysqli_query($conn, $sqlgroupadmin);
            while ($rowgroupadmin = mysqli_fetch_assoc($resultgroupadmin)) {
                $responsequery[] = array(
                    'group_id' => $rowgroupadmin['group_id'],
                    'challenge_id' => $rowgroupadmin['challenge_id'],
                    'message' => 'group admin to challenge owner',
                    'status' => $rowgroupadmin['status'],
                    'to_id' => $rowgroupadmin['to_id'],
                    'from_id' => $rowgroupadmin['from_id'],

                    'noti_type_id' => $rowgroupadmin['noti_type_id'],
                );
            }
        } elseif ($noti_type == 'group challenge response') {
            $noti_type;

            $sqlgroupadd = "SELECT *
FROM notification
INNER JOIN challenges_groups
ON notification.id = challenges_groups.noti_type_id where noti_type_id='$id'";



            $resultgroupadd = mysqli_query($conn, $sqlgroupadd);
            while ($rowgroupadd = mysqli_fetch_assoc($resultgroupadd)) {
                $responsequery[] = array(
                    'group_id' => $rowgroupadd['group_id'],
                    'challenge_id' => $rowgroupadd['challenge_id'],

                    'status' => $rowgroupadd['status'],
                    'to_id' => $rowgroupadd['to_id'],
                    'from_id' => $rowgroupadd['from_id'],

                    'noti_type_id' => $rowgroupadd['noti_type_id'],
                );
            }
        } else {

            $sql5 = "Select * from group_challenge_notification where noti_type_id='$id'";

            $result5 = mysqli_query($conn, $sql5);
            while ($row5 = mysqli_fetch_assoc($result5)) {
                $responsequery[] = array(

                    'status' => $row5['status'],
                    'challenge_id' => $row5['challenge_id'],
                    'noti_type_id' => $row5['noti_type_id'],
                );
            }
        }
    }
    echo json_encode($responsequery);
} else {
    echo json_encode(array('error' => true, 'Message' => 'No notification found'));
}
