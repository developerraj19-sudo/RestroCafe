<div class="row">
  <div class="col-12">
    <div class="glass-panel p-4 mt-4">
        <h2 class="text-primary mb-4">Your Orders</h2>
        
        <?php if (empty($orders)): ?>
            <div class="text-center mt-4 mb-4">
                <h4 class="text-light">You have no pending orders.</h4>
                <p class="text-muted">Once you place an order from the cart, it will appear here.</p>
                <a href="<?php echo BASE_URL; ?>/home" class="btn btn-primary mt-2">Go to Menu</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-borderless text-light text-center">
                    <thead class="border-bottom border-secondary">
                        <tr>
                            <th>Item Name</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $grand_total = 0;
                        foreach ($orders as $row): 
                            $sum = $row['o_qty'] * $row['price'];
                            $grand_total += $sum;
                        ?>
                            <tr>
                                <td style="vertical-align: middle;">
                                    <?php echo htmlspecialchars($row['item_name']); ?>
                                    <?php if (!empty($row['notes'])): ?>
                                        <br><small style="color: #a0aec0; font-style: italic;">Note: <?php echo htmlspecialchars($row['notes']); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $row['o_qty']; ?></td>
                                <td>₹<?php echo $row['price']; ?></td>
                                <td>₹<?php echo $sum; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="border-top border-secondary">
                            <td colspan="3" class="text-right"><strong class="text-primary">Grand Total:</strong></td>
                            <td><strong class="text-primary">₹<?php echo $grand_total; ?></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4 text-center">
                <p class="text-success font-weight-bold">✓ Your order has been placed and is being prepared.</p>
                <form action="<?php echo BASE_URL; ?>/payment" method="GET">
                    <button type="submit" class="btn btn-success btn-lg mt-3">Pay Now (₹<?php echo $grand_total; ?>)</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
  </div>
</div>

<script>
    // Hide cart button on orders page
    document.addEventListener("DOMContentLoaded", function() {
        var cartBtn = document.getElementById('viewcartbutton');
        if(cartBtn) cartBtn.style.display = 'none';
    });
</script>
