<?php
// Include database connection and header
require_once '../includes/db.php';
include '../includes/header.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

$error = '';

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Please enter both email and password.";
    } else {
        // Fetch user data based on email
        $stmt = $conn->prepare("SELECT id, full_name, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $full_name, $hashed_password);
            $stmt->fetch();

            // Verify the entered password against the stored hash
            if (password_verify($password, $hashed_password)) {
                // Set session variables
                $_SESSION['user_id'] = $id;
                $_SESSION['user_name'] = $full_name;
                
                // Redirect to homepage after successful login
                header("Location: ../index.php");
                exit();
            } else {
                $error = "Invalid email or password.";
            }
        } else {
            $error = "Invalid email or password.";
        }
        $stmt->close();
    }
}
?>

<style>
    /* Upgraded Authentication Box Styling */
    .auth-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 70vh;
        padding: 40px 20px;
    }
    .auth-container {
        width: 100%;
        max-width: 420px;
        background: var(--white, #ffffff);
        padding: 50px 40px;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    .auth-header {
        text-align: center;
        margin-bottom: 30px;
    }
    .auth-title {
        margin-bottom: 8px;
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary-color, #1a1a1a);
        letter-spacing: -0.5px;
    }
    .auth-subtitle {
        color: var(--text-muted, #6b7280);
        font-size: 0.95rem;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .auth-label {
        display: block;
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--text-main, #374151);
        margin-bottom: 8px;
    }
    .auth-input {
        width: 100%;
        padding: 12px 16px;
        font-size: 1rem;
        border: 1px solid var(--border-color, #d1d5db);
        border-radius: 6px;
        background-color: #f9fafb;
        color: #111827;
        transition: border-color 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
        box-sizing: border-box;
    }
    .auth-input:focus {
        outline: none;
        background-color: #ffffff;
        border-color: var(--primary-color, #1a1a1a);
        box-shadow: 0 0 0 3px rgba(26, 26, 26, 0.1);
    }
    .auth-btn {
        width: 100%;
        padding: 14px;
        margin-top: 10px;
        background-color: var(--primary-color, #1a1a1a);
        color: #ffffff;
        border: none;
        border-radius: 6px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }
    .auth-btn:hover {
        background-color: #333333;
        transform: translateY(-2px);
    }
    .auth-btn:active {
        transform: translateY(0);
    }
    .alert {
        padding: 14px;
        margin-bottom: 25px;
        border-radius: 6px;
        text-align: center;
        font-size: 0.95rem;
        font-weight: 500;
    }
    .alert-error {
        background-color: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }
    .auth-footer {
        text-align: center;
        margin-top: 25px;
        font-size: 0.95rem;
        color: var(--text-muted, #6b7280);
    }
    .auth-footer a {
        color: var(--primary-color, #1a1a1a);
        font-weight: 600;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    .auth-footer a:hover {
        text-decoration: underline;
    }
</style>

<div class="container auth-wrapper">
    <div class="auth-container fade-in">
        
        <div class="auth-header">
            <h2 class="auth-title">Welcome Back</h2>
            <p class="auth-subtitle">Sign in to access your account</p>
        </div>
        
        <?php if($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label class="auth-label" for="email">Email Address</label>
                <input type="email" id="email" name="email" class="auth-input" placeholder="john@example.com" required>
            </div>
            
            <div class="form-group">
                <label class="auth-label" for="password">Password</label>
                <input type="password" id="password" name="password" class="auth-input" placeholder="Enter your password" required>
            </div>
            
            <button type="submit" class="auth-btn">Sign In</button>
        </form>
        
        <div class="auth-footer">
            Don't have an account? <a href="register.php">Create one here</a>
        </div>
    </div>
</div>

<?php 
// Include footer
include '../includes/footer.php'; 
?>