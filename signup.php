<?php
session_start();
include "db.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlentities($_POST['username']);
    $email = htmlentities($_POST['email']);
    $password = $_POST['password'];

    if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
        $error_message = "Username must be 3-20 characters long and contain only letters, numbers, and underscores.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    } elseif (strlen($password) < 8 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
        $error_message = "Password must be at least 8 characters and include both letters and numbers.";
    } else {

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error_message = "Email already exists. <a href='login.html'>Log in</a>.";
        } else {
            // Hash password and insert into the database
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            if ($stmt->execute()) {
                $success_message = "Signup successful! <a href='login.html'>Log in</a>.";
            } else {
                $error_message = "Error: " . $stmt->error;
            }
        }
        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join FashionHub - Create Your Account</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* General Styles */
        :root {
            --primary-color: #ff3f6c;
            --secondary-color: #535766;
            --light-color: #f5f5f6;
            --dark-color: #282c3f;
            --success-color: #14958f;
            --warning-color: #ff9f00;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #fdfdfd;
            color: var(--dark-color);
            line-height: 1.6;
        }

        .page-container {
            display: flex;
            min-height: 100vh;
        }

        .image-section {
            display: none;
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('./assets/images/signup_bg.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 40px;
            position: relative;
        }

        @media (min-width: 992px) {
            .image-section {
                display: block;
                width: 40%;
            }
        }

        .image-content {
            position: absolute;
            bottom: 40px;
            left: 40px;
        }

        .image-content h3 {
            font-size: 1.8rem;
            margin-bottom: 15px;
        }

        .image-content p {
            font-size: 1rem;
            margin-bottom: 20px;
            max-width: 80%;
        }

        .form-section {
            width: 100%;
            padding: 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            max-width: 500px;
            margin: 0 auto;
        }

        @media (min-width: 992px) {
            .form-section {
                width: 60%;
            }
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo img {
            height: 40px;
        }

        .logo h1 {
            color: var(--primary-color);
            font-size: 2rem;
            font-weight: 700;
            margin-top: 10px;
        }

        .tagline {
            text-align: center;
            color: var(--secondary-color);
            margin-bottom: 30px;
            font-size: 1.1rem;
        }

        .form-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 30px;
        }

        h2 {
            font-size: 1.5rem;
            margin-bottom: 25px;
            color: var(--dark-color);
            text-align: center;
        }

        .form-group {
            margin-bottom: 22px;
            position: relative;
        }

        label {
            display: block;
            font-size: 0.9rem;
            margin-bottom: 8px;
            color: var(--secondary-color);
            font-weight: 600;
        }

        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
        }

        input {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border: 1px solid #d4d5d9;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s;
        }

        input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(255, 63, 108, 0.2);
        }

        input::placeholder {
            color: #b8b9bf;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #888;
        }

        .password-strength {
            font-size: 0.8rem;
            margin-top: 8px;
            color: #888;
        }

        .btn {
            width: 100%;
            padding: 14px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .btn:hover {
            background: #e6305c;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 63, 108, 0.3);
        }

        .social-signup {
            margin-top: 25px;
            text-align: center;
        }

        .social-signup p {
            color: var(--secondary-color);
            margin-bottom: 15px;
            position: relative;
        }

        .social-signup p::before,
        .social-signup p::after {
            content: "";
            display: inline-block;
            width: 30%;
            height: 1px;
            background: #d4d5d9;
            position: absolute;
            top: 50%;
        }

        .social-signup p::before {
            left: 0;
        }

        .social-signup p::after {
            right: 0;
        }

        .social-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .social-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: white;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
        }

        .social-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .social-btn i {
            font-size: 1.2rem;
        }

        .social-btn.facebook i {
            color: #3b5998;
        }

        .social-btn.google i {
            color: #db4437;
        }

        .social-btn.apple i {
            color: #000;
        }

        .login-link {
            text-align: center;
            margin-top: 25px;
            color: var(--secondary-color);
        }

        .login-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .terms {
            text-align: center;
            font-size: 0.8rem;
            color: #888;
            margin-top: 25px;
        }

        .terms a {
            color: var(--secondary-color);
            text-decoration: none;
        }

        .terms a:hover {
            text-decoration: underline;
        }

        .message {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
            text-align: center;
            font-weight: 500;
        }

        .error {
            background-color: #fff0f0;
            color: #e53935;
            border: 1px solid #ffcccb;
        }

        .success {
            background-color: #e8f5e9;
            color: var(--success-color);
            border: 1px solid #c8e6c9;
        }

        /* Simple animation for form elements */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-group {
            animation: fadeIn 0.4s ease-out forwards;
        }

        .form-group:nth-child(1) {
            animation-delay: 0.1s;
        }

        .form-group:nth-child(2) {
            animation-delay: 0.2s;
        }

        .form-group:nth-child(3) {
            animation-delay: 0.3s;
        }

        .btn {
            animation: fadeIn 0.4s ease-out 0.4s both;
        }
    </style>
</head>

<body>
    <div class="page-container">
        <!-- Image Section (Shown only on larger screens) -->
        <div class="image-section">
            <div class="image-content">
                <h3>Fashion That Speaks</h3>
                <p>Join our fashion community and discover personalized styles that match your unique personality.</p>
            </div>
        </div>

        <!-- Form Section -->
        <div class="form-section">
            <div class="logo">
                <img src="./assets/images/logo.jpg" alt="Logo">
                <span>
                    <h1>Famms</h1>
                </span>
            </div>


            <div class="form-container">
                <h2>Create Your Account</h2>

                <!-- Display error and success messages -->
                <?php if (!empty($error_message)): ?>
                    <div class="message error"><?= $error_message; ?></div>
                <?php endif; ?>

                <?php if (!empty($success_message)): ?>
                    <div class="message success"><?= $success_message; ?></div>
                <?php endif; ?>

                <!-- Signup Form -->
                <form action="signup.php" method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <div class="input-icon">
                            <i class="fas fa-user"></i>
                            <input type="text" id="username" name="username" placeholder="Choose a username" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <div class="input-icon">
                            <i class="fas fa-envelope"></i>
                            <input type="email" id="email" name="email" placeholder="Your email address" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-icon">
                            <i class="fas fa-lock"></i>
                            <input type="password" id="password" name="password" placeholder="Create a secure password"
                                required>
                            <span class="password-toggle" onclick="togglePasswordVisibility()">
                                <i class="fas fa-eye" id="togglePassword"></i>
                            </span>
                        </div>
                        <div class="password-strength">
                            Password must be at least 8 characters with letters and numbers
                        </div>
                    </div>

                    <button type="submit" class="btn">CREATE ACCOUNT</button>
                </form>

                <div class="social-signup">
                    <p>Or join with</p>
                    <div class="social-buttons">
                        <a href="#" class="social-btn facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-btn google">
                            <i class="fab fa-google"></i>
                        </a>
                        <a href="#" class="social-btn apple">
                            <i class="fab fa-apple"></i>
                        </a>
                    </div>
                </div>

                <div class="login-link">
                    Already have an account? <a href="login.html">Login</a>
                </div>

                <div class="terms">
                    By creating an account, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy
                        Policy</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('togglePassword');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Add visual feedback when checking password strength
        document.getElementById('password').addEventListener('input', function () {
            const password = this.value;
            const strengthIndicator = document.querySelector('.password-strength');

            if (password.length < 8) {
                strengthIndicator.style.color = '#e53935';
            } else if (password.length >= 8 && /[A-Za-z]/.test(password) && /[0-9]/.test(password)) {
                strengthIndicator.style.color = '#14958f';
                strengthIndicator.textContent = 'Password strength: Good';
            } else {
                strengthIndicator.style.color = '#ff9f00';
                strengthIndicator.textContent = 'Add numbers and letters for a stronger password';
            }
        });
    </script>
</body>

</html>