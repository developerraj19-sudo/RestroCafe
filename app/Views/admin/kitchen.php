<!DOCTYPE html>
<html lang="en">
<head>
    <title>Kitchen View — RestroCafe</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="refresh" content="30">
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
        }
        .admin-card {
            background: var(--glass-bg);
            border-radius: var(--border-radius-lg);
            padding: 1.5rem;
        }
    </style>
</head>
<body>
    <?php require_once 'navbar.php'; ?>

    <h2 class="dashboard-header text-center mt-4">Kitchen View: Active Orders</h2>
    <p class="text-center text-muted mb-5">Below are all the active orders that need to be prepared by the kitchen.</p>

    <?php if (empty($kitchenData)): ?>
        <div class="text-center mt-5">
            <h4 class="text-muted">No active orders for the kitchen right now.</h4>
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($kitchenData as $table => $data): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="admin-card d-flex flex-column h-100" style="border: 1px solid var(--accent-color); box-shadow: 0 0 15px rgba(232, 184, 75, 0.1);">
                        <div class="d-flex justify-content-between align-items-center border-bottom border-secondary pb-2 mb-3">
                            <h4 class="text-white m-0" style="font-family: 'Playfair Display', serif;">Table <?php echo htmlspecialchars($table); ?></h4>
                            <span class="badge" style="background-color: rgba(232, 184, 75, 0.2); color: var(--accent-color); border: 1px solid var(--accent-color); padding: 5px 10px;">Cooking...</span>
                        </div>
                        <ul class="list-unstyled mb-4 flex-grow-1">
                            <?php foreach ($data['items'] as $item): ?>
                                <li class="mb-3 pb-2 border-bottom" style="border-color: rgba(255,255,255,0.05) !important;">
                                    <div class="d-flex">
                                        <span class="font-weight-bold text-white mr-2" style="font-size: 1.1rem; min-width: 25px;"><?php echo $item['qty']; ?>x</span>
                                        <div>
                                            <span class="text-light" style="font-size: 1.1rem;"><?php echo htmlspecialchars($item['name']); ?></span>
                                            <?php if (!empty($item['notes'])): ?>
                                                <div class="mt-1" style="color: #f87171; font-size: 0.9rem; font-style: italic;">
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mr-1"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                                    <?php echo htmlspecialchars($item['notes']); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="text-center mt-auto pt-3">
                            <a href="<?php echo BASE_URL; ?>/admin/updateStatus?st=<?php echo base64_encode('FINISH'); ?>&uds=<?php echo base64_encode($data['u_id']); ?>&from=kitchen" class="btn btn-block" style="background-color: var(--veg-green); color: #fff; font-weight: bold; border-radius: 8px;">
                                MARK AS FINISHED
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

</body>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="<?php echo BASE_URL; ?>/public/bootstrap-4.2.1/js/bootstrap.js"></script>
</html>
