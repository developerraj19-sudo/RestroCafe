<div class="row d-flex justify-content-center">
  <div class="col-md-6 mt-5 mb-5">
    <div class="glass-panel p-5 text-center">
      
      <!-- Success Icon -->
      <div class="mb-4 d-inline-flex justify-content-center align-items-center" style="width: 80px; height: 80px; background-color: rgba(40, 167, 69, 0.2); border-radius: 50%;">
        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="#28a745" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </svg>
      </div>

      <h2 class="text-primary mb-3" style="font-family: 'Playfair Display', serif;">Payment Successful!</h2>
      <p class="text-muted mb-4">Your order has been placed successfully. The kitchen has received your ticket and is preparing your meal.</p>

      <!-- Receipt Box -->
      <div class="receipt-box text-left p-4 mb-4" style="background: rgba(0,0,0,0.2); border: 1px dashed rgba(255,255,255,0.2); border-radius: 10px;">
        
        <h5 class="text-white border-bottom border-secondary pb-2 mb-3">Order Summary</h5>
        <div class="mb-4">
            <table class="table table-sm table-borderless text-light mb-0" style="font-size: 0.9rem;">
                <tbody>
                    <?php if(!empty($orders_list)): ?>
                        <?php foreach($orders_list as $item): ?>
                        <tr>
                            <td class="pl-0 pb-1 pt-1">
                                <?php echo $item['o_qty']; ?>x <?php echo htmlspecialchars($item['item_name']); ?>
                                <?php if (!empty($item['notes'])): ?>
                                    <br><small style="color: #a0aec0; font-style: italic; padding-left: 15px;">Note: <?php echo htmlspecialchars($item['notes']); ?></small>
                                <?php endif; ?>
                            </td>
                            <td class="pr-0 text-right pb-1 pt-1" style="vertical-align: top;">₹<?php echo number_format($item['o_qty'] * $item['price'], 2); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td class="pl-0 text-muted">No items found</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <h5 class="text-white border-bottom border-secondary pb-2 mb-3">Transaction Details</h5>
        
        <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Transaction ID:</span>
            <span class="text-white font-weight-bold" style="font-family: monospace;"><?php echo htmlspecialchars($transaction_id); ?></span>
        </div>
        <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Date & Time:</span>
            <span class="text-white"><?php echo date('d M Y, h:i A'); ?></span>
        </div>
        <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Payment Method:</span>
            <span class="text-white"><?php echo htmlspecialchars($payment_method); ?></span>
        </div>
        <div class="d-flex justify-content-between mt-3 pt-3 border-top border-secondary">
            <span class="text-muted font-weight-bold">Amount Paid:</span>
            <span class="text-white font-weight-bold" style="font-size: 1.1rem;">₹<?php echo number_format($grand_total, 2); ?></span>
        </div>
        <div class="d-flex justify-content-between mt-2 pt-2">
            <span class="text-muted font-weight-bold">Status:</span>
            <span class="text-success font-weight-bold">PAID</span>
        </div>
      </div>

      <div class="d-flex justify-content-center gap-3">
        <button onclick="window.print()" class="btn btn-outline-light px-4 mx-2">Print Receipt</button>
        <a href="<?php echo BASE_URL; ?>/order" class="btn btn-outline-primary px-4 mx-2">View My Orders</a>
        <a href="<?php echo BASE_URL; ?>/home" class="btn btn-primary px-4 mx-2">Back to Menu</a>
      </div>
      
    </div>
  </div>
</div>
<style>
@media print {
    body * { visibility: hidden; }
    .receipt-box, .receipt-box * { visibility: visible; }
    .receipt-box { position: absolute; left: 0; top: 0; width: 100%; border: none !important; background: none !important; }
    .glass-panel { background: none; box-shadow: none; border: none; }
}
</style>
