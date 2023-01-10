<?php

include('../include/connection.php');
$data = json_decode(file_get_contents("php://input"), true);
$status = $data['status'];
$noti_type_id = $data['noti_type_id'];
$date = $data['date'];
$sql = "Select * from notification where id='$noti_type_id' ";
$query = mysqli_query($conn, $sql);
if ($query) {
    while ($row = mysqli_fetch_assoc($query)) {

        $noti_type = $row['noti_type'];
        $to_id = $row['to_id'];
        $from_id = $row['from_id'];
    }
}

$noti_type = "user to group";
$uniqid = uniqid();

$sql = "update group_notification  SET status='$status' where noti_type_id='$noti_type_id'";
$query = mysqli_query($conn, $sql);
if ($query) {
    $sql = "Select * from group_notification where noti_type_id='$noti_type_id' ";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        while ($row = mysqli_fetch_assoc($query)) {
            $noti_type_id = $row['noti_type_id'];
            $group_id = $row['group_id'];
        }
        $sql = "update group_member  SET status='$status' where user_id='$from_id' AND group_id='$group_id'";
        $query = mysqli_query($conn, $sql);
        $sqlqu = "Insert into notification(noti_type,uniqid,from_id,to_id,date,status) Values ('group admin to user','{$uniqid}','{$to_id}','{$from_id}','$date','unread')";
        $resultqu = mysqli_query($conn, $sqlqu);
        if ($resultqu) {
            $sql1 = "SELECT * from notification where uniqid='$uniqid'";
            $result2 = mysqli_query($conn, $sql1);
            if ($result2) {
                while ($row1 = mysqli_fetch_assoc($result2)) {
                    $notiid = $row1['id'];
                    $response[] = array(
                        "id" => $row1['id'],
                        "to id" => $row1['to_id'],
                        "from id" => $row1['from_id'],
                        "date" => $row1['date']
                    );
                }
            }
            $sqlqueryfinal = "Insert into group_notification(noti_type_id,group_id,status,created_date)VALUES('$notiid','$group_id','$status','$date')";
            $finalquery = mysqli_query($conn, $sqlqueryfinal);
        }
    }
}

echo json_encode($response);
