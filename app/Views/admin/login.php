<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Login — RestroCafe</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="<?php echo BASE_URL; ?>/public/bootstrap-4.2.1/css/bootstrap.css" rel="stylesheet">
    <!-- Premium Styles -->
    <link href="<?php echo BASE_URL; ?>/public/assets/css/style.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, var(--bg-dark), var(--primary-color));
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-light);
        }
        .login-card {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius-lg);
            padding: 3rem;
            width: 100%;
            max-width: 450px;
            box-shadow: var(--shadow-glow);
            text-align: center;
        }
        .login-logo {
            width: 80px;
            margin-bottom: 1.5rem;
        }
        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            padding: 0.8rem 1rem;
            border-radius: 8px;
        }
        .form-control:focus {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            box-shadow: 0 0 0 3px rgba(230, 57, 70, 0.3);
            border-color: var(--accent-color);
        }
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }
        .btn-login {
            background-color: var(--accent-color);
            color: #fff;
            font-weight: 600;
            padding: 0.8rem;
            border-radius: 8px;
            width: 100%;
            border: none;
            transition: var(--transition-fast);
            margin-top: 1rem;
        }
        .btn-login:hover {
            background-color: #d62828;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

<div class="login-card">
    <img src="<?php echo BASE_URL; ?>/public/img/rest.png" alt="RestroCafe Admin" class="login-logo">
    <h2 class="mb-4 text-white" style="font-family: 'Playfair Display', serif;">Admin Login</h2>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger" style="border-radius: 8px;">
            <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
        </div>
    <?php endif; ?>

    <form action="<?php echo BASE_URL; ?>/admin/login" method="post">
        <div class="form-group text-left">
            <label class="text-light mb-2">Username</label>
            <input type="text" name="username" class="form-control" placeholder="Enter admin username" required>
        </div>
        <div class="form-group text-left mt-3">
            <label class="text-light mb-2">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter password" required>
        </div>
        <button type="submit" name="submit" class="btn btn-login">Login to Dashboard</button>
    </form>
    
    <div class="mt-4">
        <a href="<?php echo BASE_URL; ?>/home" class="text-light" style="opacity: 0.7; font-size: 0.9rem; text-decoration: none;">&larr; Back to Main Site</a>
    </div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/bootstrap-4.2.1/js/bootstrap.js"></script>
</body>
</html>
