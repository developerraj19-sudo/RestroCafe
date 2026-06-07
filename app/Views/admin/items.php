<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Items — RestroCafe Admin</title>
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
            padding: 1.5rem;
            box-shadow: var(--shadow-glow);
        }
        .item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: var(--border-radius-sm);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .table {
            color: var(--text-light);
        }
        .table thead th {
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.7);
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.85rem;
        }
        .table td, .table th {
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            vertical-align: middle;
        }
        .table tbody tr {
            transition: var(--transition-fast);
        }
        .table tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }
        .btn-info {
            background-color: #17a2b8;
            border: none;
        }
        .btn-info:hover {
            background-color: #138496;
        }
        .badge-success { background-color: #28a745; }
        .badge-danger { background-color: #dc3545; }
        .custom-input {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
            height: auto !important;
            padding: 10px 15px !important;
            line-height: 1.5 !important;
        }
        .custom-input:focus {
            background: rgba(255, 255, 255, 0.1) !important;
            border-color: var(--accent-color) !important;
            color: #ffffff !important;
            box-shadow: none;
        }
        .custom-input option {
            background-color: #1a1a1a !important; /* solid dark background for options */
            color: #ffffff !important;
        }
    </style>
</head>
<body>
  
  <div class="">
    <?php require_once 'navbar.php';  ?>
  </div>

	<div class="container-fluid mb-5">
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success mt-3" style="border-radius: 8px;">
                <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger mt-3" style="border-radius: 8px;">
                <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>

      <h2 class="dashboard-header text-center">Manage All Menu Items</h2>

      <div class="row justify-content-center">     
        <!-- Items list -->
        <div class="col-md-10">
          <div class="admin-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0" style="color: var(--accent-color);">Menu Items Database</h5>
                <a href="<?php echo BASE_URL; ?>/admin/additem" class="btn btn-sm btn-success px-3" style="background-color: var(--accent-color); border: none;">+ Add New Item</a>
            </div>

            <!-- Filter Controls -->
            <div class="row mb-4 filter-container">
                <div class="col-md-5 mb-2">
                    <input type="text" id="searchInput" class="form-control custom-input" placeholder="Search by name or description...">
                </div>
                <div class="col-md-4 mb-2">
                    <select id="categoryFilter" class="form-control custom-input">
                        <option value="">All Categories</option>
                        <?php
                            $categories = array_unique(array_column($allitemslist, 'categories'));
                            sort($categories);
                            foreach ($categories as $cat) {
                                echo '<option value="'.htmlspecialchars($cat).'">'.htmlspecialchars($cat).'</option>';
                            }
                        ?>
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <select id="typeFilter" class="form-control custom-input">
                        <option value="">All Types</option>
                        <option value="VEG">Veg</option>
                        <option value="NON-VEG">Non-Veg</option>
                    </select>
                </div>
            </div>
            
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th class="text-right">Actions</th>
                  </tr>
                </thead>
                <tbody>
                 <?php
                  foreach ($allitemslist as $rowi) {
                      $img = !empty($rowi['image']) ? $rowi['image'] : 'food_placeholder.png';
                      $dataType = $rowi['veg'] == 'VEG' ? 'VEG' : 'NON-VEG';
                      echo '<tr class="item-row" data-name="'.strtolower(htmlspecialchars($rowi['item_name'])).'" data-desc="'.strtolower(htmlspecialchars($rowi['item_desc'])).'" data-category="'.htmlspecialchars($rowi['categories']).'" data-type="'.$dataType.'">
                            <td><img src="'.BASE_URL.'/public/img/'.$img.'" class="item-image" alt="'.htmlspecialchars($rowi['item_name']).'"></td>
                            <td class="font-weight-bold">'.htmlspecialchars($rowi['item_name']).'<br><small class="text-muted">'.htmlspecialchars(substr($rowi['item_desc'], 0, 30)).'...</small></td>
                            <td><span class="badge badge-secondary">'.htmlspecialchars($rowi['categories']).'</span></td>
                            <td>';
                            if($rowi['veg'] == 'VEG'){
                                echo '<span class="badge badge-success">VEG</span>';
                            } else {
                                echo '<span class="badge badge-danger">NON-VEG</span>';
                            }
                            echo '</td>
                            <td class="font-weight-bold" style="color: var(--accent-color);">&#8377;'.$rowi['price'].'</td>
                            <td class="text-right">
                                <a href="'.BASE_URL.'/admin/editItem?id='.$rowi['item_id'].'" class="btn btn-sm btn-info mb-1 px-3">Edit</a> 
                                <a href="'.BASE_URL.'/admin/deleteItem?id='.$rowi['item_id'].'" class="btn btn-sm btn-danger mb-1 px-2" onclick="return confirm(\'Are you sure you want to delete '.htmlspecialchars(addslashes($rowi['item_name'])).'?\')">Delete</a>
                            </td>
                          </tr>';
                  }
                 ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
	</div>

</body>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/bootstrap-4.2.1/js/bootstrap.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById("searchInput");
        const categoryFilter = document.getElementById("categoryFilter");
        const typeFilter = document.getElementById("typeFilter");
        const rows = document.querySelectorAll(".item-row");

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const category = categoryFilter.value;
            const type = typeFilter.value;

            rows.forEach(row => {
                const name = row.getAttribute("data-name");
                const desc = row.getAttribute("data-desc");
                const rowCategory = row.getAttribute("data-category");
                const rowType = row.getAttribute("data-type");

                const matchesSearch = name.includes(searchTerm) || desc.includes(searchTerm);
                const matchesCategory = category === "" || rowCategory === category;
                const matchesType = type === "" || rowType === type;

                if (matchesSearch && matchesCategory && matchesType) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }

        searchInput.addEventListener("keyup", filterTable);
        categoryFilter.addEventListener("change", filterTable);
        typeFilter.addEventListener("change", filterTable);
    });
</script>
</html>
