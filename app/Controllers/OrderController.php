<?php

class OrderController extends BaseController {
    
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/');
        }
        
        $admin = new AdminModel();
        $orders = $admin->vieworders($_SESSION['user_id']);
        
        $this->render('pages/orders', ['orders' => $orders]);
    }
    
    public function delete() {
        if (!isset($_SESSION['user_id'])) return;
        $orderid = $_POST['ids'] ?? null;
        if ($orderid) {
            $admin = new AdminModel();
            $admin->deleteorder($orderid);
            echo "success";
        }
    }
}
