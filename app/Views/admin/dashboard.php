<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard — RestroCafe</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="refresh" content="15">
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
            height: 100%;
            box-shadow: var(--shadow-glow);
        }
        .admin-card-title {
            color: var(--accent-color);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        .table {
            color: var(--text-light);
        }
        .table thead th {
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.7);
            font-weight: 500;
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
            cursor: default;
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

      <h2 class="dashboard-header text-center">Live Restaurant Dashboard</h2>

      <!-- Live Table Status -->
      <div class="row mb-2">
        <div class="col-12">
            <h5 class="admin-card-title mb-3" style="color: var(--accent-color); font-family: 'Playfair Display', serif;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-grid-3x3-gap-fill mr-2 pb-1" viewBox="0 0 16 16">
                  <path d="M1 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1zM1 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1zM1 12a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1z"/>
                </svg> Live Table Status
            </h5>
            <div class="row">
                <?php for($i=1; $i<=20; $i++): ?>
                    <?php 
                        $isOccupied = isset($occupiedTables[$i]);
                        $customerName = $isOccupied ? $occupiedTables[$i] : 'Available';
                        $bgStyle = $isOccupied ? 'background: rgba(220, 167, 102, 0.15); border: 1px solid var(--accent-color);' : 'background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);';
                        $textStyle = $isOccupied ? 'color: var(--accent-color); font-weight: 600;' : 'color: rgba(255,255,255,0.3);';
                    ?>
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-3">
                        <div class="card text-center" style="<?php echo $bgStyle; ?> border-radius: 8px; transition: all 0.3s; height: 100%;">
                            <div class="card-body p-2">
                                <h6 class="mb-1" style="<?php echo $textStyle; ?> font-family: 'Playfair Display', serif; font-size: 1.1rem;">T-<?php echo $i; ?></h6>
                                <div style="font-size: 0.8rem; <?php echo $isOccupied ? 'color: #fff;' : 'color: rgba(255,255,255,0.2);'; ?> white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?php echo htmlspecialchars($customerName); ?>">
                                    <?php echo htmlspecialchars($customerName); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
      </div>

      <div class="row">     
        <!-- Pending Bill list -->
        <div class="col-md-4 mb-4">
          <div class="admin-card">
            <h5 class="admin-card-title">Pending Bills</h5>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>Table</th>
                    <th>Amount</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                 <?php
                  foreach ($finishlist as $rowf) {
                    echo '<tr>
                            <td class="font-weight-bold">T-'.$rowf['table_no'].'</td>
                            <td class="text-success font-weight-bold">&#8377;'.$rowf['tot'].'</td>
                            <td><a href="'.BASE_URL.'/admin/updateStatus?st='.base64_encode('CLOSED').'&uds='.base64_encode($rowf['u_id']).'" class="btn btn-sm" style="background-color: var(--accent-color); color: white;" title="Add Bill">ADD BILL</a></td>
                    </tr>';
                  }
                 ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Pending Order list -->
        <div class="col-md-4 mb-4">
          <div class="admin-card">
            <h5 class="admin-card-title">Pending Orders</h5>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>Table</th>
                    <th>Amount</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($orderlist as $rowo) {
                    echo '<tr>
                            <td class="font-weight-bold">T-'.$rowo['table_no'].'</td>
                            <td class="text-warning font-weight-bold">&#8377;'.$rowo['tot'].'</td>
                            <td><a href="'.BASE_URL.'/admin/updateStatus?st='.base64_encode('FINISH').'&uds='.base64_encode($rowo['u_id']).'" class="btn btn-sm btn-info" title="Mark as finished">FINISH</a></td>
                    </tr>';
                  }
                 ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Bill list -->
        <div class="col-md-4 mb-4">
          <div class="admin-card">
            <h5 class="admin-card-title">Closed Bills (Clear Table)</h5>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>Table</th>
                    <th>Amount</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($billlist as $rowb) {
                    echo '<tr>
                            <td class="font-weight-bold">T-'.$rowb['table_no'].'</td>
                            <td class="text-secondary font-weight-bold">&#8377;'.$rowb['tot'].'</td>
                            <td>
                                <a href="'.BASE_URL.'/admin/bill?ids='.$rowb['u_id'].'" target="_blank" class="btn btn-sm btn-secondary mb-1" title="Generate Bill">Print</a>
                                <a href="'.BASE_URL.'/admin/clearTable?table='.$rowb['table_no'].'" class="btn btn-sm btn-danger mb-1" onclick="return confirm(\'Are you sure you want to clear Table '.$rowb['table_no'].'?\')" title="Clear Table">Clear</a>
                            </td>
                    </tr>';
                  }
                 ?>
                </tbody>
              </table>
            </div>
            </div>
        </div>
        
        <!-- Force Unlock Table Form -->
        <div class="col-12">
            <div class="card shadow-sm mt-4" style="border: none; border-radius: 12px; background: var(--bg-dark); border: 1px solid var(--glass-border);">
                <div class="card-header" style="background: rgba(232, 184, 75, 0.1); border-bottom: 1px solid var(--glass-border); border-radius: 12px 12px 0 0;">
                    <h5 class="mb-0" style="color: var(--accent-color); font-weight: 600;">Force Unlock Table</h5>
                </div>
                <div class="card-body">
                    <p class="text-light" style="font-size: 0.9rem;">If a table is permanently stuck because a customer logged in but never ordered, you can forcefully unlock it here.</p>
                    <form action="<?php echo BASE_URL; ?>/admin/forceUnlock" method="POST" class="form-inline">
                        <input type="number" name="table_no" class="form-control mr-3" placeholder="Table No. (1-20)" min="1" max="20" required style="width: 150px; background-color: var(--bg-light); color: var(--text-light); border: 1px solid var(--glass-border);">
                        <button type="submit" class="btn btn-warning" onclick="return confirm('Are you sure you want to force unlock this table? This will clear any active session on it.')">Force Unlock</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
	
</body>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/bootstrap-4.2.1/js/bootstrap.js"></script>
</html>
