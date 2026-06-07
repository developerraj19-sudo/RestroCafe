<?php

class PaymentController extends BaseController {
    
    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }
    }

    public function index() {
        // Active orders that are YES (waiting for payment)
        $u_id = $_SESSION['user_id'];
        
        $orders = [];
        $grand_total = 0;
        // Wait, the order list query gets orders where status is YES. Let's get them.
        try {
            $db = new Database();
            $conn = $db->getConnection();
            $query = $conn->prepare("SELECT tu.table_no, ti.item_name, tto.o_qty, ti.price, tu.u_id, tto.dateandtime 
                                     FROM tbl_orders tto 
                                     INNER JOIN tbl_user tu ON tto.u_id = tu.u_id 
                                     INNER JOIN tbl_items ti ON ti.item_id = tto.item_id 
                                     WHERE tto.ostatus IN ('YES', 'FINISH') AND tto.u_id = :ids");
            $query->bindParam(":ids", $u_id);
            $query->execute();
            $orders = $query->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($orders as $row) {
                $grand_total += $row['o_qty'] * $row['price'];
            }
        } catch (PDOException $e) {
            // Error
        }

        if (empty($orders)) {
            header('Location: ' . BASE_URL . '/order');
            exit;
        }

        $this->render('pages/payment', [
            'orders' => $orders,
            'grand_total' => $grand_total
        ]);
    }

    public function process() {
        // Simulated payment gateway process
        $u_id = $_SESSION['user_id'];
        
        $payment_method = $_POST['payment_method'] ?? 'card';
        $method_str = "Credit / Debit Card";
        if ($payment_method == 'upi') $method_str = "UPI / QR Code";
        if ($payment_method == 'netbanking') $method_str = "Net Banking";
        
        try {
            $db = new Database();
            $conn = $db->getConnection();
            
            // Calculate grand total before marking closed
            $query = $conn->prepare("SELECT tto.o_qty, ti.price, ti.item_name, tto.notes FROM tbl_orders tto INNER JOIN tbl_items ti ON ti.item_id = tto.item_id WHERE tto.ostatus IN ('YES', 'FINISH') AND tto.u_id = :uid");
            $query->bindParam(":uid", $u_id);
            $query->execute();
            $orders = $query->fetchAll(PDO::FETCH_ASSOC);
            $grand_total = 0;
            foreach ($orders as $row) {
                $grand_total += $row['o_qty'] * $row['price'];
            }
            
            // Mark orders as CLOSED (Paid)
            $dates = date('d-m-Y H:i');
            $stmt = $conn->prepare("UPDATE tbl_orders SET ostatus = 'CLOSED', dateandtime = :dates WHERE u_id = :uid AND ostatus IN ('YES', 'FINISH')");
            $stmt->bindParam(":dates", $dates);
            $stmt->bindParam(":uid", $u_id);
            $stmt->execute();
            
            // Generate a random transaction ID
            $_SESSION['last_transaction_id'] = "TXN-" . strtoupper(substr(md5(uniqid()), 0, 10));
            $_SESSION['last_grand_total'] = $grand_total;
            $_SESSION['last_payment_method'] = $method_str;
            $_SESSION['last_orders_list'] = $orders;
            
            header('Location: ' . BASE_URL . '/payment/receipt');
            exit;
        } catch (PDOException $e) {
            $_SESSION['error_message'] = "Payment failed. Please try again.";
            header('Location: ' . BASE_URL . '/payment');
            exit;
        }
    }

    public function receipt() {
        if (!isset($_SESSION['last_transaction_id'])) {
            header('Location: ' . BASE_URL . '/home');
            exit;
        }
        
        $transaction_id = $_SESSION['last_transaction_id'];
        $grand_total = $_SESSION['last_grand_total'] ?? 0;
        $payment_method = $_SESSION['last_payment_method'] ?? 'Credit / Debit Card';
        $orders_list = $_SESSION['last_orders_list'] ?? [];
        
        $this->render('pages/receipt', [
            'transaction_id' => $transaction_id,
            'grand_total' => $grand_total,
            'payment_method' => $payment_method,
            'orders_list' => $orders_list
        ]);
    }
}
