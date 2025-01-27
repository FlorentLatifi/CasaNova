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
        
        <div class="nav-list">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="buy.php">Properties</a></li>
                <li><a href="#footer">Contact Us</a></li>
                
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <li><a href="login.html" class="navbar-login">Log In</a></li>
                    <li><a href="signup.html" class="navbar-login">Sign Up</a></li>
                
                <?php elseif ($userRole == 2): // Admin ?>
                    <li><a href="manage_properties.php">Manage Properties</a></li>
                    <li><a href="add_property.php">Add Property</a></li>
                    <li class="dropdown">
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
                    <li><a href="manage_properties.php">Manage Properties</a></li>
                    <li><a href="add_property.php">Add Property</a></li>
                    <li><a href="admin_logs.php">Admin Logs</a></li>
                    <li><a href="dashboard.php"><i class="fas fa-users-cog"></i> User Management</a></li>
                    <li class="dropdown">
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
                    <li class="dropdown">
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