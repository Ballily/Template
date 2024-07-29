<?php
include_once('../includes/config.php');

if (isset($_GET['requestid'])) {
    $requestid = intval($_GET['requestid']);

    // Update the status to "กำลังแก้ไข"
    $query = "UPDATE tblfirereport SET Track='กำลังแก้ไข' WHERE id='$requestid'";
    $result = mysqli_query($connect, $query);

    if ($result) {
        header("Location: admin_complete.php"); // Redirect back to the complete page
        exit();
    } else {
        echo "Failed to update status.";
    }

    mysqli_close($connect);
}
?>
