<?php
// Start session and include database connection
session_start();
require_once '../includes/db.php';

// Redirect if Admin is already logged in
if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Please enter both email and password.";
    } else {
        // Check credentials against the admins table
        $stmt = $conn->prepare("SELECT id, username, password FROM admins WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $username, $hashed_password);
            $stmt->fetch();

            // Verify password
            if (password_verify($password, $hashed_password)) {
                // Set Admin session variables
                $_SESSION['admin_id'] = $id;
                $_SESSION['admin_username'] = $username;
                
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Invalid admin credentials.";
            }
        } else {
            $error = "Invalid admin credentials.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | RORA Luxe</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            background-color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .admin-login-box {
            background: var(--white);
            padding: 40px 30px;
            border-radius: 8px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 400px;
        }
        .admin-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .admin-header h2 {
            color: var(--primary-color);
            margin-bottom: 5px;
        }
        .admin-header p {
            color: var(--text-muted);
            font-size: 0.9rem;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 0.9rem;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 0.85rem;
            color: var(--text-muted);
        }
    </style>
</head>
<body>

<div class="admin-login-box fade-in">
    <div class="admin-header">
        <h2>Admin Portal</h2>
        <p>RORA Luxe Management</p>
    </div>

    <?php if($error): ?>
        <div class="alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="email" style="font-size: 0.9rem; font-weight: 500;">Admin Email</label>
        <input type="email" id="email" name="email" placeholder="admin@roraluxe.com" required>
        
        <label for="password" style="font-size: 0.9rem; font-weight: 500;">Password</label>
        <input type="password" id="password" name="password" placeholder="••••••••" required>
        
        <button type="submit" class="btn" style="width: 100%; margin-top: 20px;">Access Dashboard</button>
    </form>
    
    <a href="../index.php" class="back-link">&larr; Return to Main Website</a>
</div>

</body>
</html>