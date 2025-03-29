<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            echo "<script>alert('Welcome, " . $_SESSION['username'] . "!'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Invalid password. Try again.'); window.location.href='login.html';</script>";
        }
    } else {
        echo "<script>alert('User not found. Please sign up first.'); window.location.href='signup.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #6e8efb, #a777e3);
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 400px;
        }

        .form-wrapper {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            padding: 40px 30px;
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(5px);
        }

        h2 {
            color: #333;
            text-align: center;
            font-size: 32px;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .input-group {
            margin-bottom: 25px;
            position: relative;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
            font-size: 15px;
        }

        .input-group input {
            width: 100%;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f8f8f8;
            transition: all 0.3s ease;
            font-size: 16px;
        }

        .input-group input:focus {
            outline: none;
            border-color: #a777e3;
            box-shadow: 0 0 0 3px rgba(167, 119, 227, 0.2);
            background-color: #fff;
        }

        .btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(45deg, #ff416c, #ff4b2b);
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 10px;
        }

        .btn:hover {
            background: linear-gradient(45deg, #ff4b2b, #ff416c);
            transform: translateY(-3px);
            box-shadow: 0 7px 15px rgba(255, 65, 108, 0.3);
        }

        .btn:active {
            transform: translateY(0);
        }

        .forgot-password {
            text-align: right;
            margin-top: -15px;
            margin-bottom: 20px;
        }

        .forgot-password a {
            color: #777;
            font-size: 14px;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .forgot-password a:hover {
            color: #ff416c;
        }

        .signup-link {
            text-align: center;
            margin-top: 25px;
            color: #666;
            font-size: 15px;
        }

        .signup-link a {
            color: #ff416c;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .signup-link a:hover {
            color: #a777e3;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-wrapper">
            <h2>Welcome Back</h2>
            <form action="login.php" method="POST">
                <div class="input-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>

                <div class="forgot-password">
                    <a href="#">Forgot Password?</a>
                </div>

                <button type="submit" class="btn">LogIn</button>

                <div class="signup-link">
                    Don't have an account? <a href="signup.php">Sign Up</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>