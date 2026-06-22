<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order History — RestroCafe Admin</title>
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
        .admin-card {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            box-shadow: var(--shadow);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-5 mb-5">
  <div class="row">
    <div class="col-12 text-center mb-4">
        <h2 class="admin-title" style="font-family: 'Playfair Display', serif; color: var(--accent-color);">Order History</h2>
        <p class="text-light" style="opacity: 0.8;">Showing the last <?php echo $limit; ?> closed orders</p>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="admin-card" style="padding: 2rem;">
        <div class="table-responsive">
          <table class="table text-light mb-0" style="border-collapse: separate; border-spacing: 0 10px;">
            <thead>
              <tr style="border-bottom: 2px solid rgba(220, 167, 102, 0.3);">
                <th style="border: none; padding-bottom: 15px; color: var(--accent-color);">Date & Time</th>
                <th style="border: none; padding-bottom: 15px; color: var(--accent-color);">Table No.</th>
                <th style="border: none; padding-bottom: 15px; color: var(--accent-color);">Customer Name</th>
                <th style="border: none; padding-bottom: 15px; color: var(--accent-color);">Total Amount</th>
                <th style="border: none; padding-bottom: 15px; color: var(--accent-color);">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($historylist)): ?>
                <tr>
                    <td colspan="5" class="text-center py-4" style="border: none; opacity: 0.6;">No order history found.</td>
                </tr>
              <?php else: ?>
                  <?php foreach ($historylist as $row): ?>
                  <tr style="background: rgba(0,0,0,0.2); transition: all 0.3s ease;">
                    <td style="border: none; padding: 15px; border-radius: 8px 0 0 8px;"><?php echo date('M j, Y g:i A', strtotime($row['dateandtime'])); ?></td>
                    <td class="font-weight-bold" style="border: none; padding: 15px; color: var(--accent-color);">T-<?php echo htmlspecialchars($row['table_no']); ?></td>
                    <td style="border: none; padding: 15px;"><?php echo htmlspecialchars($row['user_name']); ?></td>
                    <td class="font-weight-bold" style="border: none; padding: 15px; color: #a8e6cf;">&#8377;<?php echo number_format($row['tot'], 2); ?></td>
                    <td style="border: none; padding: 15px; border-radius: 0 8px 8px 0;">
                        <a href="<?php echo BASE_URL; ?>/admin/bill?ids=<?php echo urlencode($row['u_id']); ?>" target="_blank" class="btn btn-sm" style="background-color: transparent; border: 1px solid var(--accent-color); color: var(--accent-color); transition: all 0.3s;" onmouseover="this.style.backgroundColor='var(--accent-color)'; this.style.color='white';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='var(--accent-color)';">
                            Print Receipt
                        </a>
                    </td>
                  </tr>
                  <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
