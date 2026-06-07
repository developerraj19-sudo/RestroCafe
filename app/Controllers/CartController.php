<?php

class CartController extends BaseController {
    
    public function add() {
        if (!isset($_SESSION['user_id'])) {
            echo "Not logged in";
            return;
        }
        
        $itemid = $_POST['ids'] ?? null;
        $qty = $_POST['qty'] ?? 1;
        $notes = $_POST['notes'] ?? null;
        
        if ($itemid) {
            $admin = new AdminModel();
            $admin->insertorder($itemid, $qty, $_SESSION['user_id'], $notes);
            echo "success";
        }
    }
    
    public function viewcart() {
        if (!isset($_SESSION['user_id'])) {
            echo "Not logged in";
            return;
        }
        
        $admin = new AdminModel();
        $orders = $admin->viewcartpending($_SESSION['user_id']);
        
        $total = 0;
        
        if (empty($orders)) {
            echo "<h4 class='text-center mt-4'>Your cart is empty</h4>";
            return;
        }
        
        echo "<table class='table table-borderless text-light'>";
        echo "<thead><tr><th>Item</th><th>Qty</th><th>Price</th><th>Total</th><th>Action</th></tr></thead>";
        echo "<tbody>";
        foreach ($orders as $row) {
            $sum = $row['o_qty'] * $row['price'];
            $total += $sum;
            echo "<tr>";
            
            $itemDisplay = htmlspecialchars($row['item_name']);
            if (!empty($row['notes'])) {
                $itemDisplay .= "<br><small style='color: #a0aec0; font-style: italic;'>Note: " . htmlspecialchars($row['notes']) . "</small>";
            }
            
            echo "<td>" . $itemDisplay . "</td>";
            echo "<td>" . $row['o_qty'] . "</td>";
            echo "<td>₹" . $row['price'] . "</td>";
            echo "<td>₹" . $sum . "</td>";
            echo "<td><button class='btn btn-sm btn-danger' onclick='delorder(\"" . $row['order_id'] . "\")'>Remove</button></td>";
            echo "</tr>";
        }
        echo "<tr class='border-top border-secondary'>
                <td colspan='3' class='text-right'><strong>Grand Total:</strong></td>
                <td colspan='2'><strong>₹" . $total . "</strong></td>
              </tr>";
        echo "</tbody></table>";
    }
    
    public function updateorder() {
        if (!isset($_SESSION['user_id'])) return;
        $admin = new AdminModel();
        $updated = $admin->updateorderyes($_SESSION['user_id']);
        if ($updated) {
            echo 'true';
        } else {
            echo 'false';
        }
    }
    
    public function check_status() {
        header('Content-Type: application/json');
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['status' => 'logged_out']);
            exit;
        }
        
        // Check if user still exists in database
        require_once APP_DIR . '/Core/Database.php';
        $db = new Database();
        $conn = $db->getConnection();
        
        $stmt = $conn->prepare("SELECT u_id FROM tbl_user WHERE u_id = :uid");
        $stmt->bindParam(":uid", $_SESSION['user_id']);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$user) {
            echo json_encode(['status' => 'cleared']);
            exit;
        }
        
        echo json_encode(['status' => 'active']);
    }
}
