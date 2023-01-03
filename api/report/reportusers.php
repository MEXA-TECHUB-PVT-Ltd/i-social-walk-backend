<?php
include('../include/connection.php');

$EncodeData = file_get_contents('php://input');
$data = json_decode($EncodeData, true);
$report_user = $data['report_user'];
$comments = $data['comments'];
$reported_by = $data['reported_by'];

$date = date('d-m-y');
$sql = "Insert into reportusers(reported_by,report_user,comments,created_date) Values ('{$reported_by}','{$report_user}','{$comments}','$date')";

if (mysqli_query($conn, $sql)) {
    $sqlqu = "Select * from reportusers where report_user='$report_user' ORDER BY id DESC limit 1";
    $sqlquery = mysqli_query($conn, $sqlqu);
    if ($sqlquery) {
        while ($row = mysqli_fetch_assoc($sqlquery)) {
            $id = $row['id'];
        }
    }
    echo json_encode(array(
        'id' => $id, 'report_user' => $report_user, 'report_user' => $report_user, 'comments' => $comments,
        'reported_by' => $reported_by,
    ));
} else {
    echo json_encode(array('message' => 'Not Added', 'error' => true));
}
