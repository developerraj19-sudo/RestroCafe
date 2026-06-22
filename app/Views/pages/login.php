<div class="row d-flex justify-content-center mt-5">
  <div class="col-md-6 col-lg-4">
    <div class="glass-panel text-center">
        <h2 class="text-primary mb-4">Welcome to RestroCafe</h2>
        <form action="<?php echo BASE_URL; ?>/auth/login" method="post">
            <div class="form-group text-left">
                <label>Enter Name</label>
                <input type="text" name="username" class="form-control" placeholder="Your Name" required>
            </div>
            <div class="form-group text-left mt-3">
                <label>Enter Table Number</label>
                <input type="number" name="tableno" class="form-control" placeholder="Table No. (1-20)" min="1" max="20" required>
            </div>
            <div class="mt-4">
                <button type="submit" name="submit" class="btn btn-primary btn-block w-100">Login to Order</button>
            </div>
        </form>
    </div>
  </div>
</div>
<script>
    // Hide cart button on login page
    document.addEventListener("DOMContentLoaded", function() {
        var cartBtn = document.getElementById('viewcartbutton');
        if(cartBtn) cartBtn.style.display = 'none';
    });
</script>
