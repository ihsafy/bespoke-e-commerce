<?php
require_once '../includes/db.php';
include '../includes/admin_header.php';

$success = '';
$error = '';

// Automatically create the uploads directory if it doesn't exist
$upload_dir = '../assets/uploads/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $category_id = intval($_POST['category_id']);
    
    // Subcategory is optional
    $subcategory_id = !empty($_POST['subcategory_id']) ? intval($_POST['subcategory_id']) : NULL;
    
    // Handle Image Upload
    $image_name = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/webp'];
        $file_type = $_FILES['image']['type'];
        
        if (in_array($file_type, $allowed_types)) {
            // Generate a unique filename to prevent overwriting
            $file_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $image_name = time() . '_' . uniqid() . '.' . $file_ext;
            $target_file = $upload_dir . $image_name;
            
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $error = "Failed to upload the image.";
            }
        } else {
            $error = "Invalid file type. Only JPG, PNG, and WEBP are allowed.";
        }
    } else {
        $error = "Product image is required.";
    }

    // Insert into Database if no errors
    if (empty($error)) {
        $stmt = $conn->prepare("INSERT INTO products (title, description, price, image, category_id, subcategory_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdssi", $title, $description, $price, $image_name, $category_id, $subcategory_id);
        
        if ($stmt->execute()) {
            $success = "Product added successfully!";
        } else {
            $error = "Database error. Failed to add product.";
        }
        $stmt->close();
    }
}

// Fetch categories for the dropdowns
$main_categories = $conn->query("SELECT id, name FROM categories WHERE parent_id IS NULL ORDER BY name ASC");
$sub_categories = $conn->query("SELECT id, name, parent_id FROM categories WHERE parent_id IS NOT NULL ORDER BY name ASC");
?>

<div class="admin-card" style="max-width: 800px; margin: 0 auto;">
    <h3>Add New Product</h3>
    
    <?php if($error): ?>
        <div style="background: #f8d7da; color: #721c24; padding: 12px; margin-bottom: 20px; border-radius: 4px;"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if($success): ?>
        <div style="background: #d4edda; color: #155724; padding: 12px; margin-bottom: 20px; border-radius: 4px;"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="POST" action="" enctype="multipart/form-data">
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div>
                <label for="title" style="font-size: 0.9rem; font-weight: 500;">Product Title</label>
                <input type="text" id="title" name="title" placeholder="e.g., Classic Leather Watch" required>
            </div>
            <div>
                <label for="price" style="font-size: 0.9rem; font-weight: 500;">Price ($)</label>
                <input type="number" id="price" name="price" step="0.01" min="0" placeholder="0.00" required>
            </div>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 10px;">
            <div>
                <label for="category_id" style="font-size: 0.9rem; font-weight: 500;">Main Category</label>
                <select id="category_id" name="category_id" required>
                    <option value="">Select Main Category</option>
                    <?php while($cat = $main_categories->fetch_assoc()): ?>
                        <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div>
                <label for="subcategory_id" style="font-size: 0.9rem; font-weight: 500;">Subcategory (Optional)</label>
                <select id="subcategory_id" name="subcategory_id">
                    <option value="">Select Subcategory</option>
                    <?php while($sub = $sub_categories->fetch_assoc()): ?>
                        <option value="<?php echo $sub['id']; ?>" data-parent="<?php echo $sub['parent_id']; ?>">
                            <?php echo htmlspecialchars($sub['name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
        
        <div style="margin-top: 10px;">
            <label for="image" style="font-size: 0.9rem; font-weight: 500;">Product Image (JPG, PNG, WEBP)</label>
            <input type="file" id="image" name="image" accept="image/jpeg, image/png, image/webp" required style="background: var(--background-light);">
        </div>
        
        <div style="margin-top: 10px;">
            <label for="description" style="font-size: 0.9rem; font-weight: 500;">Product Description</label>
            <textarea id="description" name="description" rows="6" placeholder="Enter product details, specifications, etc..." required></textarea>
        </div>
        
        <button type="submit" name="add_product" class="btn" style="width: 100%; margin-top: 20px; padding: 12px; font-size: 1.05rem;">Upload Product</button>
    </form>
</div>

<script>
document.getElementById('category_id').addEventListener('change', function() {
    var parentId = this.value;
    var subcategorySelect = document.getElementById('subcategory_id');
    var options = subcategorySelect.querySelectorAll('option');
    
    // Reset subcategory selection
    subcategorySelect.value = '';
    
    options.forEach(function(option) {
        if (option.value === '') {
            option.style.display = 'block'; // Always show the default option
        } else if (option.getAttribute('data-parent') === parentId) {
            option.style.display = 'block'; // Show if it matches the parent
        } else {
            option.style.display = 'none'; // Hide if it doesn't match
        }
    });
});
</script>

<?php include '../includes/admin_footer.php'; ?>