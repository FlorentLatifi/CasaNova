<?php
// Kontrollo nëse sesioni është filluar
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Merr rolin e përdoruesit
$userRole = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : null;
?>

<nav class="nav">
    <div class="nav-container">
        <a href="index.php" class="nav-logo">
            <img src="./fotot/logo.png" alt="Logo" />
        </a>
        
        <div class="menu-toggle" id="menuToggle">
            <i class="fas fa-bars"></i>
        </div>
        
        <div class="nav-list">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="buy.php">Properties</a></li>
                <li><a href="#footer">Contact Us</a></li>
                
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <li><a href="login.html" class="navbar-login">Log In</a></li>
                    <li><a href="signup.html" class="navbar-login">Sign Up</a></li>
                
                <?php elseif ($userRole == 2): // Admin ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-trigger">
                            <i class="fas fa-tachometer-alt"></i> Dashboards
                        </a>
                        <div class="dropdown-content">
                            <a href="admin_dashboard.php"><i class="fas fa-home"></i> Admin Dashboard</a>
                            <a href="manage_properties.php"><i class="fas fa-building"></i> Property Dashboard</a>
                            <a href="add_property.php"><i class="fas fa-plus-circle"></i> Add Property</a>
                        </div>
                    </li>
                    <li class="dropdown nav-right">
                        <a href="#" class="dropdown-trigger">
                            <i class="fas fa-user-shield"></i> Admin
                        </a>
                        <div class="dropdown-content">
                            <a href="profile.php"><i class="fas fa-user"></i> Profile</a>
                            <a href="manage_properties.php"><i class="fas fa-home"></i> Properties</a>
                            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </div>
                    </li>
                
                <?php elseif ($userRole == 3): // Superadmin ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-trigger">
                            <i class="fas fa-tachometer-alt"></i> Dashboards
                        </a>
                        <div class="dropdown-content">
                            <a href="superadmin_dashboard.php"><i class="fas fa-crown"></i> Superadmin Dashboard</a>
                            <a href="admin_dashboard.php"><i class="fas fa-home"></i> Admin Dashboard</a>
                            <a href="manage_properties.php"><i class="fas fa-building"></i> Property Dashboard</a>
                            <a href="dashboard.php"><i class="fas fa-users"></i> User Dashboard</a>
                            <a href="add_property.php"><i class="fas fa-plus-circle"></i> Add Property</a>
                            <a href="admin_logs.php"><i class="fas fa-history"></i> Admin Logs</a>
                        </div>
                    </li>
                    <li class="dropdown nav-right">
                        <a href="#" class="dropdown-trigger">
                            <i class="fas fa-crown"></i> Superadmin
                        </a>
                        <div class="dropdown-content">
                            <a href="profile.php"><i class="fas fa-user"></i> Profile</a>
                            <a href="dashboard.php"><i class="fas fa-users-cog"></i> User Management</a>
                            <a href="admin_logs.php"><i class="fas fa-history"></i> Logs</a>
                            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </div>
                    </li>
                
                <?php else: // Regular user ?>
                    <li class="dropdown nav-right">
                        <a href="#" class="dropdown-trigger">
                            <i class="fas fa-user"></i> My Account
                        </a>
                        <div class="dropdown-content">
                            <a href="profile.php"><i class="fas fa-user"></i> Profile</a>
                            <a href="my_favorites.php"><i class="fas fa-heart"></i> Favorites</a>
                            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<script>
// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Get necessary elements
    const menuToggle = document.getElementById('menuToggle');
    const navList = document.querySelector('.nav-list');
    const dropdowns = document.querySelectorAll('.dropdown-trigger');

    // Toggle menu when clicking the hamburger icon
    menuToggle.addEventListener('click', function(e) {
        e.stopPropagation(); // Prevent event from bubbling up
        navList.classList.toggle('active');
        
        // Toggle between hamburger and close icons
        const icon = this.querySelector('i');
        if (icon.classList.contains('fa-bars')) {
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-times');
        } else {
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
        }
    });

    // Handle dropdown menus in mobile view
    dropdowns.forEach(dropdown => {
        dropdown.addEventListener('click', function(e) {
            if (window.innerWidth <= 768) { // Only for mobile view
                e.preventDefault();
                e.stopPropagation();
                this.parentElement.classList.toggle('active');
            }
        });
    });

    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
        if (!navList.contains(e.target) && !menuToggle.contains(e.target)) {
            navList.classList.remove('active');
            const icon = menuToggle.querySelector('i');
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
            // Close all dropdowns
            document.querySelectorAll('.dropdown').forEach(d => {
                d.classList.remove('active');
            });
        }
    });
});
</script> 