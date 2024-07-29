<?php
session_start();
// DB connection
include_once('includes/config.php');
// Validating Session
if (strlen($_SESSION['aid']) == 0) {
    header('location:logout.php');
} else {
    if (isset($_POST['update'])) {
        $adminid = $_SESSION['aid'];
        $aname = $_POST['adminname'];
        $mobno = $_POST['mobilenumber'];
        $email = $_POST['email'];
        $imgfile = $_FILES["profileimage"]["name"];

        // Get the current profile image
        $currentProfileImage = $_POST['currentprofileimage'];
        $currentppath = "../assets/" . $currentProfileImage;

        // Get the image extension
        $extension = strtolower(pathinfo($imgfile, PATHINFO_EXTENSION));
        // Allowed extensions
        $allowed_extensions = array("jpg", "jpeg", "png", "gif");

        // Validation for allowed extensions
        if (!in_array($extension, $allowed_extensions) && !empty($imgfile)) {
            echo "<script>alert('Invalid format. Only jpg / jpeg / png / gif format allowed');</script>";
        } else {
            // Handle file upload if a new file is selected
            if (!empty($imgfile)) {
                $imgnewfile = md5(time()) . '.' . $extension;
                if (move_uploaded_file($_FILES["profileimage"]["tmp_name"], "../assets/" . $imgnewfile)) {
                    // Delete the old image if it exists and is not the default image
                    if (file_exists($currentppath) && $currentProfileImage != 'default.png') {
                        unlink($currentppath);
                    }
                } else {
                    echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
                }
            } else {
                $imgnewfile = $currentProfileImage; // Use the existing image if no new image is uploaded
            }

            // Update profile information
            $query = mysqli_query($con, "UPDATE admin SET AdminName='$aname', MobileNumber='$mobno', Email='$email', ProfileImage='$imgnewfile' WHERE ID='$adminid'");
            $uname = $_SESSION['uname'];
            $uip = $_SERVER['REMOTE_ADDR'];
            $link = $_SERVER['REQUEST_URI'];
            $action = 'Profile Updation';

            if ($query) {
                $status = 1;
                mysqli_query($con, "INSERT INTO logs(userName, userIp, userAction, actionUrl, actionStatus) VALUES('$uname', '$uip', '$action', '$link', '$status')");
                echo '<script>alert("Profile has been updated")</script>';
            } else {
                $status = 0;
                mysqli_query($con, "INSERT INTO logs(userName, userIp, userAction, actionUrl, actionStatus) VALUES('$uname', '$uip', '$action', '$link', '$status')");
                echo '<script>alert("Something Went Wrong. Please try again.")</script>';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Admin Profile</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style type="text/css">
        label {
            font-size:16px;
            font-weight:bold;
            color:#000;
        }
        .profile-img-preview {
            max-width: 100px;
            max-height: 100px;
            margin-top: 10px;
        }
    </style>
</head>
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include_once('includes/sidebar.php');?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <?php include_once('includes/topbar.php');?>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Admin Profile</h1>
                    <form method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-8">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4">
                                    <?php
                                    $adminid = $_SESSION['aid'];
                                    $ret = mysqli_query($con, "SELECT * FROM admin WHERE ID='$adminid'");
                                    while ($row = mysqli_fetch_array($ret)) {
                                    ?>
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Registration Date: <?php echo $row['AdminRegdate']; ?></h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Admin Name</label>
                                            <input type="text" class="form-control" name="adminname" value="<?php echo $row['AdminName']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>User Name</label>
                                            <input type="text" class="form-control" name="username" value="<?php echo $row['AdminuserName']; ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Email Id</label>
                                            <input type="email" class="form-control" name="email" value="<?php echo $row['Email']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Contact Number</label>
                                            <input type="text" class="form-control" name="mobilenumber" value="<?php echo $row['MobileNumber']; ?>" required maxlength="10">
                                        </div>
                                        <div class="form-group">
                                            <label>Profile Image</label>
                                            <div>
                                                <img id="profileImagePreview" src="../assets/<?php echo $row['ProfileImage']; ?>" class="profile-img-preview" alt="Profile Image">
                                            </div>
											<br>
                                            <input type="file" name="profileimage" class="form-control" onchange="previewImage(event)">
                                            <input type="hidden" name="currentprofileimage" value="<?php echo $row['ProfileImage']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary btn-user btn-block" name="update" id="update" value="Update">
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            <?php include_once('includes/footer.php');?>
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    <?php include_once('includes/footer2.php');?>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('profileImagePreview');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>
</html>

<?php } ?>
