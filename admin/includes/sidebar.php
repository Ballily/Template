<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <?php 
    $query = mysqli_query($con, "select * from site");
    while ($row = mysqli_fetch_array($query)) {
        $logo = $row['siteLogo']; 
        $wtitle = $row['siteTitle'];
    }  
    ?>
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
        <div class="sidebar-brand-icon">
            <img src="../assets/<?php echo $logo; ?>" alt="<?php echo $wtitle; ?>" style="width: 40px; height: 40px;">
        </div>
        <div class="sidebar-brand-text mx-3"><?php echo $wtitle; ?></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <li class="nav-item">
        <a class="nav-link" href="dashboard.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
	
    <li class="nav-item">
        <a class="nav-link" href="calendar.php">
            <i class="fas fa-fw fa-calendar-alt"></i>
            <span>Calendar</span>
        </a>
    </li>	

    <li class="nav-item">
        <a class="nav-link" href="menu1.php">
            <i class="fas fa-fw fa-file"></i>
            <span>Menu 1</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages2" aria-expanded="true" aria-controls="collapsePages2">
            <i class="fas fa-fw fa-file"></i>


            <span>Menu 2</span>
        </a>
        <div id="collapsePages2" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="#">Submenu 1</a>
                <a class="collapse-item" href="#">Submenu 2</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="manage-site.php">
            <i class="fas fa-fw fa-cog"></i>
            <span>Manage Website</span>
        </a>
    </li> 

    <li class="nav-item">
        <a class="nav-link" href="../">
            <i class="fas fa fa-home"></i>
            <span>Homepage</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->
