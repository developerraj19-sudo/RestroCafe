<div class="row d-flex justify-content-center">
  <div class="col-md-7 mt-5 mb-5">
    <div class="glass-panel p-5 position-relative overflow-hidden" id="paymentPanel">
      
      <!-- Processing Overlay -->
      <div id="processingOverlay" class="position-absolute d-none flex-column justify-content-center align-items-center" style="top:0; left:0; right:0; bottom:0; background: rgba(0,0,0,0.85); z-index: 10; border-radius: var(--border-radius-lg); backdrop-filter: blur(10px);">
        <div class="spinner-border text-primary mb-3" style="width: 4rem; height: 4rem; border-width: 0.4rem;" role="status">
          <span class="sr-only">Processing...</span>
        </div>
        <h4 class="text-white mt-4 font-weight-bold" id="processingText">Connecting to Secure Gateway...</h4>
        <p class="text-muted small mt-2">Please do not refresh or close this page.</p>
      </div>

      <div class="d-flex justify-content-between align-items-center mb-4 border-bottom border-secondary pb-3">
        <h2 class="text-primary m-0" style="font-family: 'Playfair Display', serif;">Secure Checkout</h2>
        <div class="text-right">
            <span class="d-block text-muted" style="font-size: 0.9rem;">Amount Payable</span>
            <span class="lead text-gold font-weight-bold" style="font-size: 1.5rem;">₹<?php echo number_format($grand_total, 2); ?></span>
        </div>
      </div>
      
      <!-- Payment Method Selector -->
      <ul class="nav nav-pills nav-fill mb-4" id="paymentTabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="card-tab" data-toggle="pill" href="#card-payment" role="tab" style="border-radius: 8px;">Credit / Debit Card</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="upi-tab" data-toggle="pill" href="#upi-payment" role="tab" style="border-radius: 8px;">UPI / QR Code</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="netbanking-tab" data-toggle="pill" href="#netbanking-payment" role="tab" style="border-radius: 8px;">Net Banking</a>
        </li>
      </ul>

      <form action="<?php echo BASE_URL; ?>/payment/process" method="POST" id="paymentForm">
        
        <div class="tab-content" id="paymentTabsContent">
          
          <!-- CARD PAYMENT TAB -->
          <div class="tab-pane fade show active" id="card-payment" role="tabpanel">
            <div class="credit-card-preview mb-4" style="background: linear-gradient(135deg, #2b4162 0%, #fa9c7a 100%); border-radius: 15px; padding: 20px; color: white; box-shadow: 0 10px 20px rgba(0,0,0,0.3); height: 200px; position: relative;">
              <div class="d-flex justify-content-between align-items-start">
                  <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="rgba(255,255,255,0.8)" viewBox="0 0 16 16">
                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1H2zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7z"/>
                  </svg>
                  <span style="font-family: monospace; font-size: 1.2rem; font-weight: bold; letter-spacing: 2px;">VISA</span>
              </div>
              <div class="mt-4 pt-2">
                  <div id="card-number-display" style="font-family: monospace; font-size: 1.5rem; letter-spacing: 3px; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">•••• •••• •••• ••••</div>
              </div>
              <div class="d-flex justify-content-between mt-4">
                  <div>
                      <small class="d-block text-uppercase" style="font-size: 0.6rem; opacity: 0.8;">Card Holder</small>
                      <div id="card-name-display" style="font-family: 'Inter', sans-serif; text-transform: uppercase; font-weight: 500;">YOUR NAME</div>
                  </div>
                  <div>
                      <small class="d-block text-uppercase" style="font-size: 0.6rem; opacity: 0.8;">Expires</small>
                      <div id="card-expiry-display" style="font-family: monospace;">MM/YY</div>
                  </div>
              </div>
            </div>

            <div class="form-group mb-3">
                <label class="text-light small">Cardholder Name</label>
                <input type="text" class="form-control bg-dark text-white border-secondary card-input" id="cardName" placeholder="John Doe">
            </div>
            <div class="form-group mb-3">
                <label class="text-light small">Card Number</label>
                <input type="text" class="form-control bg-dark text-white border-secondary card-input" id="cardNumber" placeholder="0000 0000 0000 0000" maxlength="19">
            </div>
            <div class="form-row mb-4">
                <div class="col-6">
                    <label class="text-light small">Expiry Date</label>
                    <input type="text" class="form-control bg-dark text-white border-secondary card-input" id="cardExpiry" placeholder="MM/YY" maxlength="5">
                </div>
                <div class="col-6">
                    <label class="text-light small">CVV</label>
                    <input type="password" class="form-control bg-dark text-white border-secondary card-input" id="cardCvv" placeholder="•••" maxlength="3">
                </div>
            </div>
          </div>

          <!-- UPI PAYMENT TAB -->
          <div class="tab-pane fade" id="upi-payment" role="tabpanel">
            <div class="text-center mb-4">
                <div class="d-inline-block p-2 bg-white rounded mb-3" style="width: 150px; height: 150px;">
                    <!-- Placeholder QR code -->
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=upi://pay?pa=restrocafe@okbiz&pn=RestroCafe&am=<?php echo $grand_total; ?>" alt="UPI QR" width="100%">
                </div>
                <p class="text-muted small">Scan with any UPI app (GPay, PhonePe, Paytm)</p>
                <div class="d-flex align-items-center justify-content-center my-3">
                    <hr class="border-secondary flex-grow-1">
                    <span class="mx-2 text-muted small">OR ENTER UPI ID</span>
                    <hr class="border-secondary flex-grow-1">
                </div>
                <div class="form-group text-left">
                    <label class="text-light small">Virtual Payment Address (UPI ID)</label>
                    <input type="text" class="form-control bg-dark text-white border-secondary upi-input" placeholder="e.g. username@okbank">
                </div>
            </div>
          </div>

          <!-- NET BANKING TAB -->
          <div class="tab-pane fade" id="netbanking-payment" role="tabpanel">
            <div class="form-group mb-4">
                <label class="text-light small">Select your Bank</label>
                <select class="form-control bg-dark text-white border-secondary nb-input">
                    <option value="" disabled selected>Choose Bank...</option>
                    <option value="sbi">State Bank of India</option>
                    <option value="hdfc">HDFC Bank</option>
                    <option value="icici">ICICI Bank</option>
                    <option value="axis">Axis Bank</option>
                    <option value="kotak">Kotak Mahindra Bank</option>
                </select>
            </div>
            <div class="alert alert-dark border-secondary text-muted small mt-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle mr-2" viewBox="0 0 16 16">
                  <path d="8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                </svg>
                You will be securely redirected to your bank's portal to authorize this payment.
            </div>
          </div>

        </div> <!-- End Tab Content -->

        <input type="hidden" name="payment_method" id="paymentMethodValue" value="card">

        <button type="submit" class="btn btn-primary btn-block btn-lg mt-2" id="payBtn" style="border-radius: 8px; font-weight: 600; letter-spacing: 1px;">
          Pay ₹<?php echo number_format($grand_total, 2); ?>
        </button>
        <div class="text-center mt-3">
            <small class="text-muted"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-shield-lock-fill mr-1" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.777 11.777 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7.159 7.159 0 0 0 1.048-.625 11.775 11.775 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.541 1.541 0 0 0-1.044-1.263 62.467 62.467 0 0 0-2.887-.87C9.843.266 8.69 0 8 0zm0 5a1.5 1.5 0 0 1 .5 2.915l.385 1.99a.5.5 0 0 1-.491.595h-.788a.5.5 0 0 1-.49-.595l.384-1.99A1.5 1.5 0 0 1 8 5z"/></svg> 100% Secure Transaction</small>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var cartBtn = document.getElementById('viewcartbutton');
        if(cartBtn) cartBtn.style.display = 'none';

        // Payment Method Tab Tracking
        const methodInput = document.getElementById('paymentMethodValue');
        
        $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
            let activeTab = e.target.id;
            if(activeTab === 'card-tab') methodInput.value = 'card';
            if(activeTab === 'upi-tab') methodInput.value = 'upi';
            if(activeTab === 'netbanking-tab') methodInput.value = 'netbanking';
        });

        // Form Submission Handling
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            e.preventDefault(); 
            
            var overlay = document.getElementById('processingOverlay');
            var text = document.getElementById('processingText');
            
            overlay.classList.remove('d-none');
            overlay.classList.add('d-flex');
            
            // Different animations based on method
            if(methodInput.value === 'card') {
                setTimeout(() => { text.textContent = "Authenticating with Bank..."; }, 1500);
                setTimeout(() => { text.textContent = "Processing Transaction..."; }, 3000);
            } else if(methodInput.value === 'upi') {
                setTimeout(() => { text.textContent = "Waiting for UPI PIN Approval..."; }, 1500);
                setTimeout(() => { text.textContent = "Verifying UPI Signature..."; }, 3000);
            } else {
                setTimeout(() => { text.textContent = "Redirecting to Bank Portal..."; }, 1000);
                setTimeout(() => { text.textContent = "Verifying Net Banking Credentials..."; }, 2500);
            }

            setTimeout(() => { 
                text.textContent = "Payment Successful!"; 
                text.classList.remove('text-white');
                text.classList.add('text-success');
                setTimeout(() => {
                    this.submit();
                }, 1000);
            }, 4500);
        });

        // Card UI Updaters
        const nameInput = document.getElementById('cardName');
        const numInput = document.getElementById('cardNumber');
        const expInput = document.getElementById('cardExpiry');
        
        const nameDisp = document.getElementById('card-name-display');
        const numDisp = document.getElementById('card-number-display');
        const expDisp = document.getElementById('card-expiry-display');

        nameInput.addEventListener('input', function() {
            nameDisp.textContent = this.value || 'YOUR NAME';
        });

        numInput.addEventListener('input', function(e) {
            let val = this.value.replace(/\D/g, '');
            let formatted = val.match(/.{1,4}/g)?.join(' ') || '';
            this.value = formatted;
            numDisp.textContent = formatted || '•••• •••• •••• ••••';
        });

        expInput.addEventListener('input', function(e) {
            let val = this.value.replace(/\D/g, '');
            if(val.length > 2) {
                val = val.substring(0, 2) + '/' + val.substring(2);
            }
            this.value = val;
            expDisp.textContent = val || 'MM/YY';
        });
    });
</script>
