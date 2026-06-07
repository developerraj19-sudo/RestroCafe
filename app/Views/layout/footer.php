    <!-- PROFESSIONAL FOOTER -->
    <footer class="customer-footer mt-5" style="background-color: #0b0c16; border-top: 1px solid rgba(255,255,255,0.05); padding: 5rem 2rem 2rem; color: #fff;">
        <div class="container" style="max-width: 1400px;">
            <div class="row">
                <!-- Brand Column -->
                <div class="col-lg-4 col-md-6 mb-5">
                    <img src="<?php echo BASE_URL; ?>/public/img/logo.png" style="height: 55px; width: auto; margin-bottom: 1.5rem; filter: drop-shadow(0px 2px 4px rgba(0,0,0,0.5));" alt="RestroCafe">
                    <p style="color: rgba(255,255,255,0.6); font-size: 0.95rem; line-height: 1.7; padding-right: 1.5rem;">Experience the authentic taste of tradition mixed with modern culinary excellence. Fresh ingredients, masterful chefs, and an unforgettable dining experience.</p>
                </div>
                
                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6 mb-5">
                    <h5 style="color: #e8b84b; font-family: 'Playfair Display', serif; font-weight: 700; margin-bottom: 1.5rem;">Quick Links</h5>
                    <ul class="list-unstyled" style="line-height: 2.2;">
                        <li><a href="<?php echo BASE_URL; ?>/home" style="color: rgba(255,255,255,0.8); text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='#e8b84b'" onmouseout="this.style.color='rgba(255,255,255,0.8)'">Our Menu</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/order" style="color: rgba(255,255,255,0.8); text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='#e8b84b'" onmouseout="this.style.color='rgba(255,255,255,0.8)'">My Orders</a></li>
                        <li><a href="#" style="color: rgba(255,255,255,0.8); text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='#e8b84b'" onmouseout="this.style.color='rgba(255,255,255,0.8)'">About Us</a></li>
                        <li><a href="#" style="color: rgba(255,255,255,0.8); text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='#e8b84b'" onmouseout="this.style.color='rgba(255,255,255,0.8)'">Contact</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="col-lg-3 col-md-6 mb-5">
                    <h5 style="color: #e8b84b; font-family: 'Playfair Display', serif; font-weight: 700; margin-bottom: 1.5rem;">Contact Us</h5>
                    <ul class="list-unstyled" style="color: rgba(255,255,255,0.6); font-size: 0.95rem; line-height: 2;">
                        <li class="mb-2"><span style="display:inline-block; width:24px;">📍</span> 123 Culinary Boulevard,<br> <span style="padding-left:24px; display:inline-block;">Food District, FC 90210</span></li>
                        <li class="mb-2"><span style="display:inline-block; width:24px;">📞</span> +1 (555) 123-4567</li>
                        <li class="mb-2"><span style="display:inline-block; width:24px;">✉️</span> hello@restrocafe.com</li>
                    </ul>
                </div>

                <!-- Opening Hours -->
                <div class="col-lg-3 col-md-6 mb-5">
                    <h5 style="color: #e8b84b; font-family: 'Playfair Display', serif; font-weight: 700; margin-bottom: 1.5rem;">Opening Hours</h5>
                    <ul class="list-unstyled" style="color: rgba(255,255,255,0.6); font-size: 0.95rem; line-height: 2.2;">
                        <li class="d-flex justify-content-between border-bottom pb-2 mb-2" style="border-color: rgba(255,255,255,0.05)!important;"><span>Mon - Fri:</span> <span style="color:#fff;">10:00 AM - 10:00 PM</span></li>
                        <li class="d-flex justify-content-between border-bottom pb-2 mb-2" style="border-color: rgba(255,255,255,0.05)!important;"><span>Saturday:</span> <span style="color:#fff;">11:00 AM - 11:30 PM</span></li>
                        <li class="d-flex justify-content-between"><span>Sunday:</span> <span style="color:#e8b84b;">Closed</span></li>
                    </ul>
                </div>
            </div>
            
            <div class="row mt-2 pt-4" style="border-top: 1px solid rgba(255,255,255,0.05);">
                <div class="col-md-6 text-center text-md-left mb-3 mb-md-0">
                    <p style="color: rgba(255,255,255,0.4); font-size: 0.85rem; margin: 0;">&copy; <?php echo date('Y'); ?> RestroCafe (Powered by Gojek). All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-right">
                    <a href="#" class="mr-4" style="color: rgba(255,255,255,0.4); font-size: 0.85rem; text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='#e8b84b'" onmouseout="this.style.color='rgba(255,255,255,0.4)'">Privacy Policy</a>
                    <a href="#" style="color: rgba(255,255,255,0.4); font-size: 0.85rem; text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='#e8b84b'" onmouseout="this.style.color='rgba(255,255,255,0.4)'">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>
    </div><!-- /page-wrapper -->
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/public/bootstrap-4.2.1/js/bootstrap.js"></script>
    
    <!-- viewcart modal -->
    <div class="modal fade" id="viewcartModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-primary" id="exampleModalLabel">Your Cart</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="viewcartmodalbody" style="color: #fff;">
            <!-- Cart contents load here -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="ordergen">Place Order</button>
          </div>
        </div>
      </div>
    </div>
    <!-- end view cart modal -->

    <script>
      $('#viewcartbutton').click(function () {
        $.ajax({
            url      : "<?php echo BASE_URL; ?>/cart/viewcart",
            method   : "POST",
            dataType : "text",        
            async    : false,
            success  : function(response) {
                $('#viewcartmodalbody').html(response);
                $('#viewcartModal').modal({
                    show: true
                });
            },
            error    : function(e) {
                alert('Error loading cart');
            }
        });
      });

      $('#ordergen').click(function () {
        $.ajax({
            url      : "<?php echo BASE_URL; ?>/cart/updateorder",
            method   : "POST",
            dataType : "text",        
            async    : false,
            success  : function(response) {
                if(response ==='true'){
                    $('#viewcartModal').modal('hide');
                }
                window.location.reload();
            },
            error    : function(e) {
                alert('Error placing order');
            }
        });
      });

      function delorder(e) {
        $.ajax({
            url      : "<?php echo BASE_URL; ?>/order/delete",
            method   : "POST",
            dataType : "text",  
            data     : {ids:e},      
            async    : false,
            success  : function(response) {
                window.location.reload();
            },
            error    : function(e) {
                alert('Error deleting order');
            }
        });
      }

      <?php if(isset($_SESSION['user_id']) && !isset($_SESSION['staff_id'])): ?>
      // Poll for table clear using our new endpoint
      setInterval(function() {
          $.ajax({
              url: "<?php echo BASE_URL; ?>/auth/checkStatus",
              type: "POST",
              dataType: "json",
              cache: false,
              success: function(res) {
                  if (res.cleared) {
                      window.location.href = "<?php echo BASE_URL; ?>/auth/logout";
                  }
              }
          });
      }, 5000);
      <?php endif; ?>
    </script>
</body>
</html>
