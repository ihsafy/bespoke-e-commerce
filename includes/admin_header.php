<?php
// Start the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Security Check: If the admin is not logged in, redirect them to the login page
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Get the current page file name to highlight the active menu link
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal | RORA Luxe</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="admin-body">

<aside class="admin-sidebar">
    <div class="admin-brand">
        RORA Luxe
    </div>
    <ul class="admin-nav">
        <li>
            <a href="dashboard.php" class="<?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">Dashboard Overview</a>
        </li>
        <li>
            <a href="manage_categories.php" class="<?php echo ($current_page == 'manage_categories.php') ? 'active' : ''; ?>">Manage Categories</a>
        </li>
        <li>
            <a href="add_product.php" class="<?php echo ($current_page == 'add_product.php') ? 'active' : ''; ?>">Add New Product</a>
        </li>
        <li>
            <a href="manage_products.php" class="<?php echo ($current_page == 'manage_products.php') ? 'active' : ''; ?>">Manage Products</a>
        </li>
        
        <li style="margin-top: 40px;">
            <a href="../auth/logout.php" style="color: #ff6b6b;">Secure Logout</a>
        </li>
        <li>
            <a href="../index.php" target="_blank" style="color: var(--text-muted); font-size: 0.8rem;">&uarr; View Live Site</a>
        </li>
    </ul>
</aside>

<main class="admin-main">
    
    <header class="admin-topbar">
        <h2 style="font-size: 1.2rem; margin: 0; color: var(--text-main);">Control Panel</h2>
        <div style="font-weight: 500; font-size: 0.9rem; color: var(--text-muted);">
            Logged in as: <strong><?php echo htmlspecialchars($_SESSION['admin_username']); ?></strong>
        </div>
    </header>
    
    <div class="admin-content fade-in">