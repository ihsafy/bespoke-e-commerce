<?php
// Include database connection and admin header
require_once '../includes/db.php';
include '../includes/admin_header.php';

// Fetch key statistics from the database
$user_query = "SELECT COUNT(id) AS total FROM users";
$total_users = $conn->query($user_query)->fetch_assoc()['total'];

$category_query = "SELECT COUNT(id) AS total FROM categories";
$total_categories = $conn->query($category_query)->fetch_assoc()['total'];

$product_query = "SELECT COUNT(id) AS total FROM products";
$total_products = $conn->query($product_query)->fetch_assoc()['total'];
?>

<style>
    /* Dashboard Specific Styles */
    .dashboard-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }
    
    .stat-card {
        background: var(--white);
        padding: 30px;
        border-radius: 8px;
        box-shadow: var(--box-shadow);
        text-align: center;
        border-bottom: 4px solid var(--secondary-color);
        transition: transform var(--transition-speed) ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
    }
    
    .stat-title {
        font-size: 1rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 15px;
    }
    
    .stat-number {
        font-size: 3rem;
        font-weight: 700;
        color: var(--primary-color);
        line-height: 1;
    }
</style>

<div class="dashboard-stats">
    <div class="stat-card">
        <div class="stat-title">Total Products</div>
        <div class="stat-number"><?php echo number_format($total_products); ?></div>
    </div>
    
    <div class="stat-card">
        <div class="stat-title">Total Categories</div>
        <div class="stat-number"><?php echo number_format($total_categories); ?></div>
    </div>
    
    <div class="stat-card">
        <div class="stat-title">Registered Users</div>
        <div class="stat-number"><?php echo number_format($total_users); ?></div>
    </div>
</div>

<div class="admin-card">
    <h3>Welcome to your Command Center</h3>
    <p style="color: var(--text-muted); line-height: 1.8;">
        This is the RORA Luxe administrative portal. From the sidebar on the left, you can seamlessly manage your entire e-commerce infrastructure. 
        Start by creating your main Categories (like Watches, Bags, Clothes) and Subcategories (like Men's Shirts, Women's Dresses). Once your taxonomy is set up, you can begin uploading your premium products to populate the live storefront.
    </p>
</div>

<?php 
// Include admin footer
include '../includes/admin_footer.php'; 
?>