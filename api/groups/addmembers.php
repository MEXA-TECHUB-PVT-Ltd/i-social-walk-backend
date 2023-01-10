<?php
include('../include/connection.php');

$EncodeData = file_get_contents('php://input');
$data = json_decode($EncodeData, true);
$user_id = $data['user_id'];
$group_id = $data['group_id'];
$adminid = $data['adminid'];
$date = $data['date'];
$status = "Membered";
foreach ($user_id as $user_id_list) {

    $sql = "Insert into group_member(group_id,user_id,status,created_at) Values ('{$group_id}','{$user_id_list}','membered','$date')";
    $query = mysqli_query($conn, $sql);
}
if ($query) {
    $response[] = array(
        "message" => 'Successfully Added All Members in Group',
        "Group" => $group_id,

        "error" => false

    );
    foreach ($user_id as $user_id_list_member) {
        $noti_type = "Admin to User For group";
        $uniqid = uniqid();

        $sql = "Insert into notification(noti_type,uniqid,from_id,to_id,date,status) Values ('{$noti_type}','{$uniqid}','{$adminid}','{$user_id_list_member}','$date','unread')";
        $query = mysqli_query($conn, $sql);
        if ($query) {
            $response[] = array(
                "message" => 'You are Added in group ',
                "adminid" => $adminid,
                "userid" => $user_id,
                "group_id" => $group_id,
                "error" => false

            );
        }

        $sql1 = "Select * from notification where uniqid='$uniqid'";
        $query = mysqli_query($conn, $sql1);
        if (mysqli_num_rows($query)) {
            while ($row = mysqli_fetch_assoc($query)) {
                $noti_type_id = $row['id'];
            }
        }
        $sql = "Insert into group_notification(noti_type_id,group_id,status,created_date) Values ('{$noti_type_id}','{$group_id}','Membered','$date')";
        $query = mysqli_query($conn, $sql);
        if (!$query) {

            $response[] = array(
                "message" => 'Not Added',

                "error" => false

            );
        }
    }
}
echo json_encode($response);
