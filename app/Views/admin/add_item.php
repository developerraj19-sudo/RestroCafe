<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Item — RestroCafe Admin</title>
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
            background-color: var(--bg-dark);
            color: var(--text-light);
            font-family: 'Inter', sans-serif;
        }
        .dashboard-header {
            font-family: 'Playfair Display', serif;
            color: var(--accent-color);
            margin-top: 2rem;
            margin-bottom: 2rem;
        }
        .admin-card {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius-lg);
            padding: 2.5rem;
            box-shadow: var(--shadow-glow);
            width: 100%;
        }
        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            border-radius: 8px;
        }
        .form-control:focus {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            box-shadow: 0 0 0 3px rgba(230, 57, 70, 0.3);
            border-color: var(--accent-color);
        }
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        .btn-submit {
            background-color: var(--accent-color);
            color: #fff;
            font-weight: 600;
            padding: 0.8rem 2rem;
            border-radius: 8px;
            border: none;
            transition: var(--transition-fast);
        }
        .btn-submit:hover {
            background-color: #d62828;
            transform: translateY(-2px);
            color: #fff;
        }
        label {
            font-weight: 500;
            color: rgba(255, 255, 255, 0.9);
            margin-top: 1rem;
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body>
  
  <div class="">
    <?php require_once 'navbar.php';  ?>
  </div>

	<div class="container mb-5">
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger mt-3" style="border-radius: 8px;">
                <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>

      <h2 class="dashboard-header text-center">Add New Menu Item</h2>

      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="admin-card">
            <form action="<?php echo BASE_URL; ?>/admin/additem" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Item Name</label>
                    <input type="text" name="item_name" class="form-control" placeholder="e.g. Garlic Naan" required>
                </div>
                
                <div class="form-group">
                    <label>Item Description</label>
                    <textarea name="item_desc" class="form-control" rows="3" placeholder="Enter a mouth-watering description..." required></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Category</label>
                        <input type="text" name="item_category" class="form-control" placeholder="e.g. Starters, Main Course, Breads" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Price (&#8377;)</label>
                        <input type="number" name="item_price" class="form-control" placeholder="0.00" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Dietary Type</label>
                    <div class="mt-2">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="vegRadio" name="item_veg_non" class="custom-control-input" value="VEG" checked>
                            <label class="custom-control-label text-light" for="vegRadio">Vegetarian (VEG)</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="nonVegRadio" name="item_veg_non" class="custom-control-input" value="NON-VEG">
                            <label class="custom-control-label text-light" for="nonVegRadio">Non-Vegetarian (NON-VEG)</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Upload Image</label>
                    <div class="custom-file mt-1">
                        <input type="file" name="item_image" class="custom-file-input" id="customFile" required>
                        <label class="custom-file-label" for="customFile" style="background: rgba(255,255,255,0.05); color: #fff; border-color: rgba(255,255,255,0.2);">Choose image file...</label>
                    </div>
                </div>

                <div class="form-group text-center mt-4 mb-0">
                    <button type="submit" name="submit" class="btn btn-submit btn-lg w-100">Add Item</button>
                </div>
            </form>
          </div>
        </div>
      </div>
	</div>

<script>
document.querySelector('.custom-file-input').addEventListener('change', function(e) {
    var fileName = document.getElementById("customFile").files[0].name;
    var nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
});
</script>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/bootstrap-4.2.1/js/bootstrap.js"></script>
</body>
</html>
