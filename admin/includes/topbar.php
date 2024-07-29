<?php
session_start();
error_reporting(0);
include_once('includes/config.php');

if (strlen($_SESSION['aid']) == 0) {
    header('location:logout.php');
} else {
    // Fetching site title
    $query = mysqli_query($con, "SELECT siteTitle FROM site LIMIT 1");
    $row = mysqli_fetch_array($query);
    $webTitle = $row['siteTitle'];

    // Fetching admin profile image
    $adid = $_SESSION['aid'];
    $queryProfile = mysqli_query($con, "SELECT ProfileImage FROM admin WHERE ID='$adid'");
    $profileRow = mysqli_fetch_array($queryProfile);
    $profile = $profileRow['ProfileImage']; // ชื่อไฟล์ภาพโปรไฟล์

    // Set default image if profile image is not set
    if (empty($profile)) {
        $profile = 'default.png'; // หรือไฟล์ภาพโปรไฟล์เริ่มต้นที่คุณต้องการใช้
    }
}
?>

<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Search -->
    <?php if ($_SESSION['aid']): ?>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                            aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <?php
                // Fetching admin Name
                $ret1 = mysqli_query($con, "SELECT AdminName FROM admin WHERE ID='$adid'");
                while ($row1 = mysqli_fetch_array($ret1)) {
                ?>
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo htmlspecialchars($row1['AdminName']); ?></span>
                <?php } ?>
                <img class="img-profile rounded-circle" src="../../assets/<?php echo htmlspecialchars($profile); ?>" alt="<?php echo htmlspecialchars($webTitle); ?>"> <!-- ใช้ชื่อไฟล์ภาพโปรไฟล์ -->
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="profile.php">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <a class="dropdown-item" href="change-password.php">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Change Password
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
    <?php endif; ?>
</nav>
