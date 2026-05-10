<?php
// Include database connection and header (using ../ to go up one directory level)
require_once '../includes/db.php';
include '../includes/header.php';

$error = '';
$success = '';

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($full_name) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } else {
        // Check if the email is already registered
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Email is already registered. Please login.";
        } else {
            // Hash the password securely and insert the new user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert_stmt = $conn->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
            $insert_stmt->bind_param("sss", $full_name, $email, $hashed_password);

            if ($insert_stmt->execute()) {
                $success = "Registration successful! You can now login.";
            } else {
                $error = "Something went wrong. Please try again.";
            }
            $insert_stmt->close();
        }
        $stmt->close();
    }
}
?>

<style>
    /* Upgraded Authentication Box Styling (Matches Login Page) */
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
    .alert-success {
        background-color: #f0fdf4;
        color: #166534;
        border: 1px solid #bbf7d0;
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
            <h2 class="auth-title">Create Account</h2>
            <p class="auth-subtitle">Join RORA Luxe today</p>
        </div>
        
        <?php if($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <?php if($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label class="auth-label" for="full_name">Full Name</label>
                <input type="text" id="full_name" name="full_name" class="auth-input" placeholder="John Doe" required>
            </div>
            
            <div class="form-group">
                <label class="auth-label" for="email">Email Address</label>
                <input type="email" id="email" name="email" class="auth-input" placeholder="john@example.com" required>
            </div>
            
            <div class="form-group">
                <label class="auth-label" for="password">Password</label>
                <input type="password" id="password" name="password" class="auth-input" placeholder="Create a strong password" required>
            </div>
            
            <button type="submit" class="auth-btn">Register</button>
        </form>
        
        <div class="auth-footer">
            Already have an account? <a href="login.php">Sign in here</a>
        </div>
    </div>
</div>

<?php 
// Include footer
include '../includes/footer.php'; 
?>