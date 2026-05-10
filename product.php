<?php
require_once 'includes/db.php';
include 'includes/header.php';

// Get the product ID from the URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the specific product details
$query = "
    SELECT p.*, 
           c.name AS category_name, 
           s.name AS subcategory_name
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    LEFT JOIN categories s ON p.subcategory_id = s.id
    WHERE p.id = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

$product = $result->fetch_assoc();

// If product doesn't exist, show an error message
if (!$product) {
    echo "<div class='container' style='padding: 100px 20px; text-align: center;'>
            <h2>Product Not Found</h2>
            <p>The product you are looking for does not exist or has been removed.</p>
            <a href='index.php' class='btn' style='margin-top: 20px;'>Back to Shop</a>
          </div>";
    include 'includes/footer.php';
    exit();
}

// --- WHATSAPP LOGIC ---
$wa_number = "8801812117699";
$product_title = $product['title'];
$product_price = number_format($product['price'], 2);
// Get current page URL to send to admin
$current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$wa_message = "Hello RORA Luxe! I am interested in purchasing this item:\n\n" . 
              "*Product:* " . $product_title . "\n" . 
              "*Price:* $" . $product_price . "\n" . 
              "*Link:* " . $current_url;

$wa_final_url = "https://wa.me/" . $wa_number . "?text=" . urlencode($wa_message);
?>

<style>
    .single-product-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 50px;
        margin: 60px auto;
        background: #ffffff;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    
    .product-image-wrapper {
        width: 100%;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #eee;
        background: #fdfdfd;
    }
    
    .product-image-wrapper img {
        width: 100%;
        height: auto;
        display: block;
        transition: transform 0.5s ease;
    }

    .product-image-wrapper:hover img {
        transform: scale(1.05);
    }
    
    .product-details {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    .breadcrumb {
        font-size: 0.85rem;
        color: #888;
        margin-bottom: 15px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-weight: 600;
    }
    
    .single-product-title {
        font-size: 2.8rem;
        color: #1a1a1a;
        margin-bottom: 10px;
        line-height: 1.1;
        font-weight: 700;
    }
    
    .single-product-price {
        font-size: 2.2rem;
        color: #c5a059; /* A luxury gold/bronze color */
        font-weight: 600;
        margin-bottom: 25px;
    }
    
    .single-product-description {
        font-size: 1.05rem;
        color: #555;
        line-height: 1.8;
        margin-bottom: 35px;
        white-space: pre-line;
    }
    
    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .buy-wa-btn {
        background-color: #25D366;
        color: white;
        text-align: center;
        padding: 18px;
        font-size: 1.2rem;
        font-weight: 700;
        border-radius: 6px;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: background 0.3s ease, transform 0.2s ease;
    }

    .buy-wa-btn:hover {
        background-color: #1ebd58;
        transform: translateY(-3px);
        color: white;
    }

    .btn-back {
        text-align: center;
        color: #666;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 600;
        margin-top: 10px;
    }

    .btn-back:hover {
        text-decoration: underline;
    }
    
    @media (max-width: 900px) {
        .single-product-container {
            grid-template-columns: 1fr;
            padding: 20px;
            margin: 20px auto;
        }
        .single-product-title {
            font-size: 2rem;
        }
    }
</style>

<div class="container fade-in">
    <div class="single-product-container">
        <div class="product-image-wrapper">
            <img src="assets/uploads/<?php echo htmlspecialchars($product['image']); ?>" 
                 alt="<?php echo htmlspecialchars($product['title']); ?>" 
                 onerror="this.src='assets/images/placeholder.jpg'">
        </div>
        
        <div class="product-details">
            <div class="breadcrumb">
                <?php 
                echo htmlspecialchars($product['category_name']); 
                if (!empty($product['subcategory_name'])) {
                    echo " <i class='fas fa-chevron-right' style='font-size:0.7rem; margin:0 5px;'></i> " . htmlspecialchars($product['subcategory_name']);
                }
                ?>
            </div>
            
            <h1 class="single-product-title"><?php echo htmlspecialchars($product['title']); ?></h1>
            <div class="single-product-price">$<?php echo number_format($product['price'], 2); ?></div>
            
            <div class="single-product-description">
                <?php echo htmlspecialchars($product['description']); ?>
            </div>
            
            <div class="action-buttons">
                <a href="<?php echo $wa_final_url; ?>" target="_blank" class="buy-wa-btn">
                    <i class="fab fa-whatsapp" style="font-size: 1.5rem;"></i> BUY VIA WHATSAPP
                </a>
                
                <a href="index.php#shop" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Continue Shopping
                </a>
            </div>
            
            <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
                <p style="font-size: 0.85rem; color: #999;">
                    <i class="fas fa-shield-alt"></i> Secure and Authentic Luxury Guaranteed.
                </p>
            </div>
        </div>
    </div>
</div>

<?php 
$stmt->close();
include 'includes/footer.php'; 
?>