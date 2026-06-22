<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: var(--bg-dark); border-bottom: 1px solid var(--glass-border);">
    <a class="navbar-brand d-flex align-items-center" href="<?php echo BASE_URL; ?>/admin" title="Go to Main Site">
        <img src="<?php echo BASE_URL; ?>/public/img/logo.png" style="height: 55px; width: auto; filter: drop-shadow(0px 2px 5px rgba(0,0,0,0.5));" class="d-inline-block align-middle mr-3" alt="Logo">
        <span style="font-family: 'Playfair Display', serif; font-weight: 700; font-size: 1.45rem; color: var(--accent-color); letter-spacing: 0.5px;">AdminPanel</span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="adminNavbar">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item">
                <a class="nav-link text-light font-weight-bold" href="<?php echo BASE_URL; ?>/admin/dashboard">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light font-weight-bold" style="color: var(--accent-color) !important;" href="<?php echo BASE_URL; ?>/admin/kitchen">Kitchen View</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light font-weight-bold" href="<?php echo BASE_URL; ?>/admin/history">Order History</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-light" href="#" id="itemsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Manage Items
                </a>
                <div class="dropdown-menu" aria-labelledby="itemsDropdown" style="background-color: var(--bg-dark); border: 1px solid var(--glass-border);">
                    <a class="dropdown-item text-light" href="<?php echo BASE_URL; ?>/admin/additem">Add New Item</a>
                    <a class="dropdown-item text-light" href="<?php echo BASE_URL; ?>/admin/items">All Items List</a>
                </div>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0" action="<?php echo BASE_URL; ?>/admin/logout" method="POST">
            <button class="btn btn-outline-danger my-2 my-sm-0 d-flex align-items-center" type="submit" title="Logout">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right mr-2" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                  <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                </svg>
                Logout
            </button>
        </form>
    </div>
</nav>

<style>
    /* Admin specific dropdown hover fixes */
    .dropdown-item:hover {
        background-color: var(--accent-color) !important;
        color: white !important;
    }
</style>