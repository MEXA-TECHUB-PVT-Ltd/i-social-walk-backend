<?php
session_start();
include('../include/connection.php');

    $id = $_POST['id'];
    $privacytext = $_POST['privacytext'];




    // if ()

    $sql = "UPDATE privacy SET 
privacytext='$privacytext', 

   WHERE id='$id'";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        $_SESSION['status_text'] = "privacy olicy  Updated Successfully";
        $_SESSION['status_title'] = "";
        $_SESSION['status_code'] = "success";
        header('location: ../privacypolicy.php');
    } else {
        $_SESSION['status_text'] = "Contact Not Updated";
        $_SESSION['status_title'] = "";
        $_SESSION['status_code'] = "error";
        header('location: ../privacypolicy.php');
    }
