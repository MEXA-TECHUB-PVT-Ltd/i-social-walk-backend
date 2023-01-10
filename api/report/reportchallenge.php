<?php
include('../include/connection.php');

$EncodeData = file_get_contents('php://input');
$data = json_decode($EncodeData, true);
$report_challenge = $data['report_challenge'];
$reported_by = $data['reported_by'];
$comments = $data['comments'];

$date = date('d-m-y');
$sql = "Insert into report_challenge(report_challenge,reported_by,comments,created_date) Values ('{$report_challenge}','{$reported_by}','{$comments}','$date')";

if (mysqli_query($conn, $sql)) {
    $sqlqu = "Select * from report_challenge where report_challenge='$report_challenge' ORDER BY id DESC limit 1";
    $sqlquery = mysqli_query($conn, $sqlqu);
    if ($sqlquery) {
        while ($row = mysqli_fetch_assoc($sqlquery)) {
            $id = $row['id'];
            $report_challenge = $row['report_challenge'];
            $reported_by = $row['reported_by'];
            $comments = $row['comments'];
        }
    }
    echo json_encode(array(
        'id' => $id,
        'report_challenge' => $report_challenge,
        'reported_by' => $reported_by,
        'comments' => $comments,
        'reported_by' => $reported_by,
    ));
} else {
    echo json_encode(array('message' => 'Not Added', 'error' => true));
}
