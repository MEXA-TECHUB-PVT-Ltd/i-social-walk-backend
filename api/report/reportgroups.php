<?php
include('../include/connection.php');

$EncodeData = file_get_contents('php://input');
$data = json_decode($EncodeData, true);
$report_group = $data['report_group'];
$reported_by = $data['reported_by'];
$comments = $data['comments'];

$date = date('d-m-y');
$sql = "Insert into report_group(report_group,reported_by,comments,created_date) Values ('{$report_group}','{$reported_by}','{$comments}','$date')";

if (mysqli_query($conn, $sql)) {
    $sqlqu = "Select * from report_group where report_group='$report_group' ORDER BY id DESC limit 1";
    $sqlquery = mysqli_query($conn, $sqlqu);
    if ($sqlquery) {
        while ($row = mysqli_fetch_assoc($sqlquery)) {
            $id = $row['id'];
            $report_group = $row['report_group'];
            $reported_by = $row['reported_by'];
            $comments = $row['comments'];
        }
    }
    echo json_encode(array(
        'id' => $id, 'report_group' => $report_group, 'reported_by' => $reported_by, 'comments' => $comments,
        'reported_by' => $reported_by,
    ));
} else {
    echo json_encode(array('message' => 'Not Added', 'error' => true));
}
