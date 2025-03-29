<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Store</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .profile-popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        #profileModal {
            display: none;
            position: fixed;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            width: 100%;
        }

        .profile-content {
            background-color: white;
            width: 90%;
            max-width: 400px;
            border-radius: 10px;
            padding: 30px;
            position: relative;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .close-profile {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 24px;
            cursor: pointer;
            color: #555;
        }

        .user-avatar {
            text-align: center;
            margin-bottom: 20px;
        }

        .user-avatar img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #f0f0f0;
        }

        .user-details {
            text-align: center;
            margin-bottom: 20px;
        }

        .user-name {
            font-size: 22px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .user-email {
            font-size: 14px;
            color: #777;
            margin-bottom: 15px;
        }

        .profile-menu {
            border-top: 1px solid #eee;
            padding-top: 15px;
        }

        .profile-menu a {
            display: block;
            padding: 12px 15px;
            text-decoration: none;
            color: #555;
            border-radius: 5px;
            margin-bottom: 5px;
            transition: all 0.3s ease;
        }

        .profile-menu a:hover {
            background-color: #f7f7f7;
            color: #333;
        }

        .profile-menu a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .logout-btn {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 15px;
        }

        .logout-btn:hover {
            background-color: #d32f2f;
        }

        /* User Profile Icon in Nav */
        .user-profile-icon {
            display: flex;
            align-items: center;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .user-profile-icon:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .user-profile-icon img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 5px;
        }

        .user-profile-icon span {
            font-size: 14px;
            font-weight: 500;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <header>
        <div class="container nav-container">
            <div class="logo-container">
                <a href="index.html" class="logo">
                    <img src="./assets/images/logo.jpg" alt="Famms Logo">
                </a>
                <span class="company-name">Famms</span>
            </div>

            <nav class="nav-menu">
                <a href="#">Home</a>
                <a href="#">Products</a>
                <a href="#">About</a>
                <a href="#">Contact</a>
                <a href="#" class="btn-cart">Cart</a>
                <?php if (isset($_SESSION['username'])) { ?>

                    <!-- This will be shown when user is logged in -->
                    <div class="user-profile-icon" id="profile-icon">
                        <img src="./assets/images/icons.png" alt="User">
                        <span><?= $_SESSION['username'] ?></span>
                    </div>
                <?php } else { ?>
                    <!-- This will be hidden when user is logged in -->
                    <a href="signup.php" class="btn-signup" id="signup-btn">Sign Up</a>
                <?php } ?>
            </nav>
        </div>
    </header>

    <?php if (isset($_SESSION['username'])) { ?>
        <div class="profile-popup" id="profilePopup">
            <div class="profile-content">
                <span class="close-profile" id="closeProfile">&times;</span>
                <div class="user-avatar">
                    <img src="./assets/images/icons.png" alt="User">
                </div>
                <div class="user-details">
                    <p class="user-name"><?= $_SESSION['username'] ?></p>
                </div>
                <div class="profile-menu">
                    <a href="#"><i class="fas fa-user"></i> My Profile</a>
                    <a href="#"><i class="fas fa-shopping-cart"></i> My Orders</a>
                    <a href="#"><i class="fas fa-heart"></i> Wishlist</a>
                    <a href="logout.php" class="logout-btn">Logout</a>
                </div>
            </div>
        </div>
    <?php } ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const profileIcon = document.getElementById('profile-icon');
            const profilePopup = document.getElementById('profilePopup');
            const closeProfile = document.getElementById('closeProfile');

            if (profileIcon && profilePopup) {
                profileIcon.addEventListener('click', () => {
                    profilePopup.style.display = 'flex';
                });

                closeProfile.addEventListener('click', () => {
                    profilePopup.style.display = 'none';
                });

                window.addEventListener('click', (event) => {
                    if (event.target === profilePopup) {
                        profilePopup.style.display = 'none';
                    }
                });
            }
        });
    </script>

    <!-- Hero Banner -->
    <section class="hero-banner">
        <div class="hero-content">
            <h1><span>Sale 20% Off</span><br>On Everything</h1>
            <p>Get the best fashion deals with our exclusive discounts.</p>
            <a href="#" class="btn">Shop Now</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container features">
            <div class="feature-box">
                <h3>Fast Delivery</h3>
                <p>Get your products delivered on time.</p>
            </div>
            <div class="feature-box">
                <h3>Free Shipping</h3>
                <p>Enjoy free shipping on all orders.</p>
            </div>
            <div class="feature-box">
                <h3>Best Quality</h3>
                <p>We provide the best quality products.</p>
            </div>
        </div>
    </section>

    <!-- New Arrivals -->
    <section class="new-arrivals">
        <div class="container arrivals-container">
            <div class="arrivals-image">
                <img src="./assets/images/productShowMan.jpg" alt="Model">
            </div>
            <div class="arrivals-content">
                <h2>#NewArrivals</h2>
                <p>View our latest collection of premium products at unbeatable prices. Stay ahead of the trend with our
                    fresh arrivals every season.</p>
                <a href="#" class="btn">Shop Now</a>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="container">
        <h2 class="products-heading">Our <span>Products</span></h2>
        <div class="products-grid">
            <div class="product-card">
                <img src="./assets/images/men_shirt.jpg" alt="Men's Shirt">
                <div class="product-info">
                    <h3>Men's Shirt</h3>
                    <p class="product-price">$29.99</p>
                    <a href="#" class="btn">Add to Cart</a>
                </div>
            </div>
            <div class="product-card">
                <img src="./assets/images/men_jacket.webp" alt="Men's Jacket">
                <div class="product-info">
                    <h3>Men's Jacket</h3>
                    <p class="product-price">$59.99</p>
                    <a href="#" class="btn">Add to Cart</a>
                </div>
            </div>
            <div class="product-card">
                <img src="./assets/images/women_dress.jpg" alt="Women's Dress">
                <div class="product-info">
                    <h3>Women's Dress</h3>
                    <p class="product-price">$39.99</p>
                    <a href="#" class="btn">Add to Cart</a>
                </div>
            </div>
            <div class="product-card">
                <img src="./assets/images/red_dress.webp" alt="Red Dress">
                <div class="product-info">
                    <h3>Red Dress</h3>
                    <p class="product-price">$45.99</p>
                    <a href="#" class="btn">Add to Cart</a>
                </div>
            </div>
            <div class="product-card">
                <img src="./assets/images/women_tshirt.webp" alt="Men's Shirt">
                <div class="product-info">
                    <h3>Women T-shirt</h3>
                    <p class="product-price">$10.00</p>
                    <a href="#" class="btn">Add to Cart</a>
                </div>
            </div>
            <div class="product-card">
                <img src="./assets/images/womenJeans.webp" alt="Men's Jacket">
                <div class="product-info">
                    <h3>Women's Jeans</h3>
                    <p class="product-price">$60.99</p>
                    <a href="#" class="btn">Add to Cart</a>
                </div>
            </div>
            <div class="product-card">
                <img src="./assets/images/menJeans.webp" alt="Women's Dress">
                <div class="product-info">
                    <h3>Men's Jeans</h3>
                    <p class="product-price">$69.99</p>
                    <a href="#" class="btn">Add to Cart</a>
                </div>
            </div>
            <div class="product-card">
                <img src="./assets/images/womenKurti.webp" alt="Red Dress">
                <div class="product-info">
                    <h3>Women's Kuris</h3>
                    <p class="product-price">$100.99</p>
                    <a href="#" class="btn">Add to Cart</a>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>Shop Categories</h3>
                <ul>
                    <li><a href="#">Men</a></li>
                    <li><a href="#">Women</a></li>
                    <li><a href="#">Kids</a></li>
                    <li><a href="#">Accessories</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Customer Service</h3>
                <ul>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">FAQs</a></li>
                    <li><a href="#">Returns & Refunds</a></li>
                    <li><a href="#">Shipping Info</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>About Us</h3>
                <p>Your go-to destination for fashion, offering the latest trends with top-notch quality and service.
                </p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <div class="footer-section">
                <h3>Newsletter</h3>
                <form action="#" method="POST">
                    <input type="email" placeholder="Enter your email" required>
                    <button type="submit">Subscribe</button>
                </form>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy;
                <?php echo date('Y'); ?> Your E-Commerce. All rights reserved.
            </p>
        </div>
    </footer>

    <!-- JavaScript for User Profile Popup -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Simulate user login
            const isLoggedIn = false; // Set to true to simulate logged in state
            const signupBtn = document.getElementById('signup-btn');
            const profileIcon = document.getElementById('profile-icon');
            const profilePopup = document.getElementById('profilePopup');
            const closeProfile = document.getElementById('closeProfile');
            const logoutBtn = document.getElementById('logoutBtn');

            // Function to check login status
            function checkLoginStatus() {
                if (isLoggedIn) {
                    signupBtn.style.display = 'none';
                    profileIcon.style.display = 'flex';

                    // Show profile popup on page load (first login)
                    // This can be controlled by checking for a session variable
                    // that indicates the user just logged in
                    const justLoggedIn = true; // This would come from your session

                    if (justLoggedIn) {
                        setTimeout(function () {
                            profilePopup.style.display = 'flex';
                        }, 1000); // Show popup 1 second after page load
                    }
                } else {
                    if (signupBtn) signupBtn.style.display = 'block';
                    profileIcon.style.display = 'flex';
                }
            }

            // Show profile popup when user icon is clicked
            profileIcon.addEventListener('click', function () {
                if (profilePopup) profilePopup.style.display = 'flex';
            });

            // Close profile popup
            closeProfile && closeProfile.addEventListener('click', function () {
                profilePopup.style.display = 'none';
            });

            // Close popup when clicking outside
            window.addEventListener('click', function (event) {
                if (event.target == profilePopup) {
                    profilePopup.style.display = 'none';
                }
            });

            // Logout functionality
            logoutBtn && logoutBtn.addEventListener('click', function () {
                // Here you would typically make an AJAX call to logout
                // For this demo, we'll just toggle the login state
                alert('Logged out successfully!');
                profilePopup.style.display = 'none';

                // In a real implementation, you would redirect to login page
                // window.location.href = 'login.php';
            });

            // Run the login check when page loads
            checkLoginStatus();

            // FOR DEMO PURPOSES ONLY: Toggle login status with button
            const demoLoginBtn = document.createElement('button');
            demoLoginBtn.textContent = 'Demo: Toggle Login';
            demoLoginBtn.style.position = 'fixed';
            demoLoginBtn.style.bottom = '20px';
            demoLoginBtn.style.right = '20px';
            demoLoginBtn.style.zIndex = '1000';
            demoLoginBtn.style.padding = '10px';
            demoLoginBtn.style.backgroundColor = '#333';
            demoLoginBtn.style.color = 'white';
            demoLoginBtn.style.border = 'none';
            demoLoginBtn.style.borderRadius = '5px';
            demoLoginBtn.style.cursor = 'pointer';

            demoLoginBtn.addEventListener('click', function () {
                window.isLoggedIn = !window.isLoggedIn;
                if (window.isLoggedIn) {
                    signupBtn.style.display = 'none';
                    profileIcon.style.display = 'flex';
                    profilePopup.style.display = 'flex';
                } else {
                    signupBtn.style.display = 'block';
                    profileIcon.style.display = 'none';
                    profilePopup.style.display = 'none';
                }
            });

            document.body.appendChild(demoLoginBtn);
        });
    </script>

</body>

</html>