<!DOCTYPE html>
<html lang="en">
<head>
    <title>RestroCafe — Restaurant Menu</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="RestroCafe — Order fresh, authentic food from our restaurant menu.">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="<?php echo BASE_URL; ?>/public/bootstrap-4.2.1/css/bootstrap.css" rel="stylesheet">
    <!-- App CSS -->
    <link href="<?php echo BASE_URL; ?>/public/assets/css/style.css?v=<?php echo time(); ?>" rel="stylesheet">
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="<?php echo BASE_URL; ?>/">
            <img src="<?php echo BASE_URL; ?>/public/img/logo.png" style="height: 65px; width: auto; object-fit: contain; filter: drop-shadow(0px 4px 8px rgba(0,0,0,0.4)); transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'" class="d-inline-block align-middle" alt="RestroCafe Logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/home">Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/order">My Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="<?php echo BASE_URL; ?>/auth/logout">Logout</a>
                </li>
            </ul>
            <div class="d-flex align-items-center mt-3 mt-lg-0 mb-2 mb-lg-0">
                <?php if(isset($_SESSION['table'])): ?>
                    <span class="navbar-text mr-3 font-weight-bold" style="color: var(--accent-color); font-size: 1.1rem; border: 1px solid var(--accent-color); padding: 4px 12px; border-radius: 20px; background-color: rgba(232, 184, 75, 0.1);">
                        Table #<?php echo htmlspecialchars($_SESSION['table']); ?>
                    </span>
                <?php endif; ?>
                <button type="button" id="viewcartbutton" title="View Cart">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M10 19.5c0 .829-.672 1.5-1.5 1.5s-1.5-.671-1.5-1.5c0-.828.672-1.5 1.5-1.5s1.5.672 1.5 1.5zm3.5-1.5c-.828 0-1.5.671-1.5 1.5s.672 1.5 1.5 1.5 1.5-.671 1.5-1.5c0-.828-.672-1.5-1.5-1.5zm1.336-5l1.977-7h-16.813l2.938 7h11.898zm4.969-10l-3.432 12h-12.597l.839 2h13.239l3.474-12h1.929l.743-2h-4.195z"/></svg>
                    View Cart
                </button>
            </div>
        </div>
    </nav>

    <!-- Page content wrapper -->
    <div id="page-wrapper" style="width:100%;">
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger alert-dismissible" style="margin:1rem 1.5rem;border-radius:10px;" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Error:</strong> <?php echo htmlspecialchars($_SESSION['error_message']); unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>
