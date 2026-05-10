<?php
require_once '../includes/db.php';
include '../includes/admin_header.php';

$success = '';
$error = '';

// Handle Category Form Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_category'])) {
    $name = trim($_POST['name']);
    $parent_id = !empty($_POST['parent_id']) ? intval($_POST['parent_id']) : NULL;

    if (empty($name)) {
        $error = "Category name is required.";
    } else {
        $stmt = $conn->prepare("INSERT INTO categories (name, parent_id) VALUES (?, ?)");
        $stmt->bind_param("si", $name, $parent_id);
        
        if ($stmt->execute()) {
            $success = "Category added successfully!";
        } else {
            $error = "Failed to add category. It may already exist.";
        }
        $stmt->close();
    }
}

// Fetch Main Categories for the dropdown (parent_id is NULL)
$main_categories = $conn->query("SELECT id, name FROM categories WHERE parent_id IS NULL ORDER BY name ASC");

// Fetch All Categories for the table view (Self-join to get parent names)
$all_categories_query = "
    SELECT c1.id, c1.name, c2.name AS parent_name 
    FROM categories c1 
    LEFT JOIN categories c2 ON c1.parent_id = c2.id 
    ORDER BY COALESCE(c2.name, c1.name) ASC, c1.name ASC
";
$all_categories = $conn->query($all_categories_query);
?>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px;">
    
    <div class="admin-card">
        <h3>Add New Category</h3>
        
        <?php if($error): ?>
            <div style="background: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 15px; border-radius: 4px;"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if($success): ?>
            <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 15px; border-radius: 4px;"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="name" style="font-size: 0.9rem; font-weight: 500;">Category Name</label>
            <input type="text" id="name" name="name" placeholder="e.g., Watches" required>
            
            <label for="parent_id" style="font-size: 0.9rem; font-weight: 500; display: block; margin-top: 10px;">Parent Category (Optional)</label>
            <select id="parent_id" name="parent_id">
                <option value="">None (Make this a Main Category)</option>
                <?php 
                // Reset pointer just in case and loop through main categories
                $main_categories->data_seek(0);
                while($cat = $main_categories->fetch_assoc()): 
                ?>
                    <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                <?php endwhile; ?>
            </select>
            
            <button type="submit" name="add_category" class="btn" style="width: 100%; margin-top: 20px;">Save Category</button>
        </form>
    </div>

    <div class="admin-card">
        <h3>Existing Categories</h3>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category Name</th>
                    <th>Parent Category / Type</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($all_categories && $all_categories->num_rows > 0): ?>
                    <?php while ($row = $all_categories->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td style="font-weight: 500;"><?php echo htmlspecialchars($row['name']); ?></td>
                            <td>
                                <?php if ($row['parent_name']): ?>
                                    <span class="badge" style="background: #e2e8f0; color: #475569;">Subcategory of: <?php echo htmlspecialchars($row['parent_name']); ?></span>
                                <?php else: ?>
                                    <span class="badge badge-success">Main Category</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" style="text-align: center; color: var(--text-muted);">No categories found. Start by adding one!</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<?php include '../includes/admin_footer.php'; ?>