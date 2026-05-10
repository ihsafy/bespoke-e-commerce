<?php
// Start the session if it hasn't been started already
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Define the absolute base URL for the project
$base_url = '/rora_luxe/';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RORA Luxe | Premium E-Commerce</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/style.css">
</head>
<body>

<header class="main-header">
    <div style="background: #1a1a1a; color: #ffffff; padding: 10px 0; font-size: 0.85rem; border-bottom: 1px solid #333;">
        <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
            
            <div class="header-contact">
                <a href="https://wa.me/8801812117699" target="_blank" style="color: #ffffff; text-decoration: none; display: flex; align-items: center; gap: 8px;">
                    <i class="fab fa-whatsapp" style="color: #25D366; font-size: 1.1rem;"></i> 
                    <span>+880 1812-117699</span>
                </a>
            </div>

            <div class="header-socials">
                <a href="https://www.facebook.com/people/RORA-Luxe/61587170679360/" target="_blank" style="color: #ffffff; text-decoration: none; display: flex; align-items: center; gap: 8px;">
                    <i class="fab fa-facebook-f"></i>
                    <span>Follow RORA Luxe</span>
                </a>
            </div>
        </div>
    </div>

    <div class="container header-container" style="display: flex; justify-content: space-between; align-items: center; padding: 25px 0;">
        
        <a href="<?php echo $base_url; ?>index.php" class="logo" style="text-decoration: none; font-size: 1.8rem; font-weight: 800; color: #1a1a1a; letter-spacing: 1px;">
            RORA <span style="font-weight: 300; color: #666;">LUXE</span>
        </a>
        
        <nav class="main-nav" style="display: flex; align-items: center; gap: 25px;">
            <a href="<?php echo $base_url; ?>index.php" style="font-weight: 600; text-decoration: none; color: #1a1a1a; font-size: 0.9rem;">HOME</a>
            <a href="<?php echo $base_url; ?>index.php#shop" style="font-weight: 600; text-decoration: none; color: #1a1a1a; font-size: 0.9rem;">SHOP</a>
            
            <?php if (isset($_SESSION['user_id'])): ?>
                <div style="display: flex; align-items: center; gap: 15px;">
                    <span style="font-size: 0.9rem; color: #6b7280;">Welcome, <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong></span>
                    <a href="<?php echo $base_url; ?>auth/logout.php" style="background: #f3f4f6; padding: 8px 15px; border-radius: 4px; text-decoration: none; color: #dc2626; font-weight: 600; font-size: 0.85rem;">LOGOUT</a>
                </div>
            <?php else: ?>
                <a href="<?php echo $base_url; ?>auth/login.php" style="font-weight: 600; text-decoration: none; color: #1a1a1a; font-size: 0.9rem;">LOGIN</a>
                <a href="<?php echo $base_url; ?>auth/register.php" style="background: #1a1a1a; color: #fff; padding: 10px 20px; border-radius: 4px; text-decoration: none; font-weight: 600; font-size: 0.85rem;">REGISTER</a>
            <?php endif; ?>
            
            <div style="height: 20px; width: 1px; background: #ddd; margin: 0 5px;"></div>
            
            <a href="<?php echo $base_url; ?>admin/login.php" class="admin-link" style="color: #6b7280; font-weight: 700; font-size: 0.85rem; text-decoration: none; border: 1px solid #ddd; padding: 5px 10px; border-radius: 4px;">
                <i class="fas fa-lock"></i> ADMIN
            </a>
        </nav>
    </div>
</header>

<main style="min-height: 60vh;">