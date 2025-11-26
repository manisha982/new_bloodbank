<?php
session_start();

// 🔐 Hardcoded credentials (you can replace with DB check later)
$ADMIN_USERNAME = 'admin';
$ADMIN_PASSWORD = 'manisha123';

// 🧠 Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username === $ADMIN_USERNAME && $password === $ADMIN_PASSWORD) {
        $_SESSION['username'] = 'admin';
        $_SESSION['role'] = 'Admin';
        header("Location: admin/index.php");
        exit;
    } else {
        echo "<script>alert('❌ Invalid credentials! Try again.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Nepal Blood Bank</title>
    <style>
        /* Reset and center everything */
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form_area {
            width: 100%;
            max-width: 420px;
            padding: 0 15px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form_area form {
            background: white;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 40px 30px;
            text-align: center;
            animation: fadeIn 0.5s ease;
            width: 100%;
        }

        .security-icon {
            font-size: 60px;
            margin-bottom: 20px;
        }

        .input-wrapper {
            position: relative;
            margin-bottom: 15px;
            width: 100%;
            transition: transform 0.2s ease;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 18px;
        }

        .input-wrapper input {
            width: 100%;
            padding: 10px 10px 10px 45px;
            font-size: 17px;
            border: 1px solid #ddd;
            border-radius: 6px;
            transition: border 0.3s;
        }

        .input-wrapper input:focus {
            outline: none;
            border-color: #d32f2f;
            box-shadow: 0 0 0 3px rgba(211, 47, 47, 0.1);
        }

        .login-btn {
            width: 100%;
            background: #d32f2f;
            border: 1px solid #d32f2f;
            color: white;
            font-size: 17px;
            font-weight: bold;
            text-align: center;
            padding: 14px;
            border-radius: 6px;
            transition: 0.3s;
            cursor: pointer;
            margin-top: 10px;
        }

        .login-btn:hover {
            background: #b71c1c;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(211, 47, 47, 0.3);
        }

        .form_area a {
            display: inline-block;
            margin-top: 10px;
            color: #d32f2f;
            text-decoration: none;
        }

        .form_area a:hover {
            text-decoration: underline;
        }

        .motivational {
            margin-top: 25px;
            color: #666;
            font-size: 14px;
            line-height: 1.6;
        }

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

        @media screen and (max-width: 600px) {
            .form_area form {
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>
    <div class="form_area">
        <form method="POST" action="">
            <div class="security-icon">🔐</div>
            <h2>Admin Login</h2>

            <div class="input-wrapper">
                <span class="input-icon">👤</span>
                <input type="text" name="username" placeholder="Username" required>
            </div>

            <div class="input-wrapper">
                <span class="input-icon">🔒</span>
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button type="submit" class="login-btn">Login to Dashboard</button>
            <a href="#forgot-password">Forgot Password?</a>

            <p class="motivational">
                Authorized personnel only. All activities are logged for security.
            </p>
        </form>
    </div>

    <script>
        // Only for input hover animation (no login logic)
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                input.parentElement.style.transform = 'translateY(-2px)';
            });
            input.addEventListener('blur', () => {
                input.parentElement.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>

</html>