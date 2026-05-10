<?php
require_once 'includes/db.php';
include 'includes/header.php';

// Initialize variables for filtering and sorting
$category_filter = isset($_GET['category']) ? (int)$_GET['category'] : 0;
$sort_order = isset($_GET['sort']) ? $_GET['sort'] : 'desc';

// Build the SQL query dynamically based on user selection
$query = "
    SELECT p.*, c.name AS category_name 
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
";

// Apply category filter if selected
if ($category_filter > 0) {
    $query .= " WHERE p.category_id = $category_filter OR p.subcategory_id = $category_filter ";
}

// Apply sorting
if ($sort_order == 'asc') {
    $query .= " ORDER BY p.price ASC";
} elseif ($sort_order == 'desc') {
    $query .= " ORDER BY p.price DESC";
} else {
    $query .= " ORDER BY p.created_at DESC"; // Default
}

$result = $conn->query($query);

// Fetch all main categories for the sidebar filter
$cat_query = "SELECT * FROM categories WHERE parent_id IS NULL";
$categories = $conn->query($cat_query);
?>

<style>
    .shop-container {
        display: flex;
        gap: 30px;
        margin-top: 40px;
        margin-bottom: 60px;
    }
    
    /* Sidebar Styling */
    .shop-sidebar {
        width: 250px;
        flex-shrink: 0;
        background: var(--white);
        padding: 20px;
        border-radius: 8px;
        box-shadow: var(--box-shadow);
        height: fit-content;
    }
    .shop-sidebar h3 {
        margin-bottom: 15px;
        font-size: 1.2rem;
        border-bottom: 2px solid var(--border-color);
        padding-bottom: 10px;
    }
    .filter-list {
        list-style: none;
        margin-bottom: 25px;
    }
    .filter-list li {
        margin-bottom: 10px;
    }
    .filter-list a {
        color: var(--text-muted);
        font-size: 0.95rem;
    }
    .filter-list a:hover, .filter-list a.active {
        color: var(--secondary-color);
        font-weight: 600;
    }

    /* Main Shop Area */
    .shop-main {
        flex-grow: 1;
    }
    .shop-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        background: var(--white);
        padding: 15px 20px;
        border-radius: 8px;
        box-shadow: var(--box-shadow);
    }
    .sort-form select {
        width: auto;
        padding: 8px 15px;
        margin: 0;
    }
    
    @media (max-width: 768px) {
        .shop-container {
            flex-direction: column;
        }
        .shop-sidebar {
            width: 100%;
        }
    }
</style>

<div class="container shop-container">
    <aside class="shop-sidebar">
        <h3>Categories</h3>
        <ul class="filter-list">
            <li>
                <a href="shop.php" class="<?php echo ($category_filter == 0) ? 'active' : ''; ?>">All Products</a>
            </li>
            <?php while($cat = $categories->fetch_assoc()): ?>
                <li>
                    <a href="shop.php?category=<?php echo $cat['id']; ?>" class="<?php echo ($category_filter == $cat['id']) ? 'active' : ''; ?>">
                        <?php echo htmlspecialchars($cat['name']); ?>
                    </a>
                </li>
            <?php endwhile; ?>
        </ul>
    </aside>

    <main class="shop-main">
        <div class="shop-header">
            <h2>Shop Collection</h2>
            <form method="GET" action="shop.php" class="sort-form">
                <?php if($category_filter > 0): ?>
                    <input type="hidden" name="category" value="<?php echo $category_filter; ?>">
                <?php endif; ?>
                <label for="sort" style="font-size:0.9rem; margin-right:10px;">Sort By:</label>
                <select name="sort" id="sort" onchange="this.form.submit()">
                    <option value="newest" <?php echo ($sort_order == 'newest') ? 'selected' : ''; ?>>Newest Arrivals</option>
                    <option value="asc" <?php echo ($sort_order == 'asc') ? 'selected' : ''; ?>>Price: Low to High</option>
                    <option value="desc" <?php echo ($sort_order == 'desc') ? 'selected' : ''; ?>>Price: High to Low</option>
                </select>
            </form>
        </div>

        <div class="grid grid-cols-4">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($product = $result->fetch_assoc()): ?>
                    <div class="product-card">
                        <img src="assets/uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>" class="product-image" onerror="this.src='assets/images/placeholder.jpg'">
                        <div class="product-info">
                            <span class="category-badge" style="font-size: 0.75rem; background: var(--border-color); padding: 3px 8px; border-radius: 4px; display: inline-block; margin-bottom: 10px; color: var(--text-muted);">
                                <?php echo htmlspecialchars($product['category_name']); ?>
                            </span>
                            <h3 class="product-title"><?php echo htmlspecialchars($product['title']); ?></h3>
                            <div class="product-price">$<?php echo number_format($product['price'], 2); ?></div>
                            <a href="product.php?id=<?php echo $product['id']; ?>" class="btn btn-outline" style="width: 100%; margin-top: 15px;">View Details</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: var(--text-muted); background: var(--white); border-radius: 8px;">
                    <h3>No products found matching your criteria.</h3>
                </div>
            <?php endif; ?>
        </div>
    </main>
</div>

<?php include 'includes/footer.php'; ?>