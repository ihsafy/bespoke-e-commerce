<?php
require_once '../includes/db.php';
include '../includes/admin_header.php';

$success = '';
$error = '';

// Handle Product Deletion
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    
    // First, fetch the image filename so we can delete the actual file from the server
    $img_stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
    $img_stmt->bind_param("i", $delete_id);
    $img_stmt->execute();
    $img_stmt->bind_result($image_name);
    
    if ($img_stmt->fetch()) {
        // Delete the image file if it exists
        $file_path = '../assets/uploads/' . $image_name;
        if (!empty($image_name) && file_exists($file_path)) {
            unlink($file_path); // Removes the file
        }
    }
    $img_stmt->close();

    // Now, delete the product record from the database
    $del_stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $del_stmt->bind_param("i", $delete_id);
    
    if ($del_stmt->execute()) {
        $success = "Product securely deleted.";
    } else {
        $error = "Failed to delete product.";
    }
    $del_stmt->close();
}

// Fetch all products with their main category names
$query = "
    SELECT p.id, p.title, p.price, p.image, p.created_at, c.name AS category_name 
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    ORDER BY p.created_at DESC
";
$result = $conn->query($query);
?>

<div class="admin-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3 style="margin: 0; border: none; padding: 0;">Manage Inventory</h3>
        <a href="add_product.php" class="btn" style="padding: 8px 15px; font-size: 0.9rem;">+ Add New Product</a>
    </div>
    
    <?php if($error): ?>
        <div style="background: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 15px; border-radius: 4px;"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if($success): ?>
        <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 15px; border-radius: 4px;"><?php echo $success; ?></div>
    <?php endif; ?>

    <table class="admin-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Product Title</th>
                <th>Category</th>
                <th>Price</th>
                <th>Date Added</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($product = $result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <img src="../assets/uploads/<?php echo htmlspecialchars($product['image']); ?>" 
                                 alt="Thumbnail" 
                                 style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;"
                                 onerror="this.src='../assets/images/placeholder.jpg'">
                        </td>
                        <td style="font-weight: 500;"><?php echo htmlspecialchars($product['title']); ?></td>
                        <td><span class="badge" style="background: #e2e8f0; color: #475569;"><?php echo htmlspecialchars($product['category_name']); ?></span></td>
                        <td style="color: var(--secondary-color); font-weight: 600;">$<?php echo number_format($product['price'], 2); ?></td>
                        <td style="color: var(--text-muted); font-size: 0.85rem;">
                            <?php echo date('M d, Y', strtotime($product['created_at'])); ?>
                        </td>
                        <td>
                            <a href="?delete=<?php echo $product['id']; ?>" 
                               class="badge badge-danger" 
                               style="text-decoration: none;"
                               onclick="return confirm('Are you sure you want to delete this product? This action cannot be undone.');">
                               Delete
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 30px;">
                        No products found in the database. 
                        <br><br>
                        <a href="add_product.php" class="btn btn-outline" style="padding: 8px 15px;">Add Your First Product</a>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/admin_footer.php'; ?>