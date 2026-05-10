<?php
// Include database connection and header
require_once 'includes/db.php';
include 'includes/header.php';

// Fetch all products along with their category and subcategory names
$query = "
    SELECT p.*, 
           c.name AS category_name, 
           s.name AS subcategory_name
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    LEFT JOIN categories s ON p.subcategory_id = s.id
    ORDER BY p.created_at DESC
";
$result = $conn->query($query);
?>

<style>
    /* Hero Banner Styles */
    .hero {
        background-color: var(--primary-color);
        color: var(--white);
        padding: 80px 20px;
        text-align: center;
        margin-bottom: 50px;
    }
    .hero h1 {
        color: var(--secondary-color);
        font-size: 3rem;
        margin-bottom: 15px;
    }
    .hero p {
        font-size: 1.2rem;
        max-width: 600px;
        margin: 0 auto 30px auto;
        color: #cccccc;
    }
    
    /* Product Grid Adjustments */
    .section-title {
        text-align: center;
        margin-bottom: 40px;
        font-size: 2rem;
        position: relative;
    }
    .section-title::after {
        content: '';
        display: block;
        width: 60px;
        height: 3px;
        background-color: var(--secondary-color);
        margin: 10px auto 0;
    }
    .category-badge {
        font-size: 0.75rem;
        background-color: var(--border-color);
        color: var(--text-muted);
        padding: 3px 8px;
        border-radius: 4px;
        display: inline-block;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .no-products {
        text-align: center;
        padding: 50px;
        color: var(--text-muted);
        grid-column: 1 / -1; /* Spans across all columns in grid */
    }
</style>

<section class="hero">
    <div class="container">
        <h1>Welcome to RORA Luxe</h1>
        <p>Discover premium collections of watches, bags, clothes, and accessories tailored for the modern lifestyle.</p>
        <a href="#all-products" class="btn">Explore Collection</a>
    </div>
</section>

<section id="all-products" class="container">
    <h2 class="section-title">New Arrivals</h2>
    
    <div class="grid grid-cols-4">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($product = $result->fetch_assoc()): ?>
                <div class="product-card">
                    <img src="assets/uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>" class="product-image" onerror="this.src='assets/images/placeholder.jpg'">
                    
                    <div class="product-info">
                        <span class="category-badge">
                            <?php 
                            echo htmlspecialchars($product['category_name']); 
                            if (!empty($product['subcategory_name'])) {
                                echo " > " . htmlspecialchars($product['subcategory_name']);
                            }
                            ?>
                        </span>
                        <h3 class="product-title"><?php echo htmlspecialchars($product['title']); ?></h3>
                        <div class="product-price">$<?php echo number_format($product['price'], 2); ?></div>
                        
                        <a href="product.php?id=<?php echo $product['id']; ?>" class="btn btn-outline" style="width: 100%; margin-top: 15px;">View Details</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-products">
                <h3>No products available yet.</h3>
                <p>Check back later or log in to the Admin Portal to add new inventory.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php 
// Include footer
include 'includes/footer.php'; 
?>