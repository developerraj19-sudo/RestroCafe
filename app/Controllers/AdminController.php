<?php

class AdminController extends BaseController {

    private $adminModel;

    public function __construct() {
        require_once APP_DIR . DS . 'Models' . DS . 'AdminModel.php';
        $this->adminModel = new AdminModel();
        
        // Start session if not started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Custom render for admin to bypass frontend layout
    protected function adminRender($view, $data = []) {
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        extract($data);
        $viewFile = VIEWS_DIR . DS . 'admin' . DS . $view . '.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("Admin View $view not found.");
        }
    }

    private function requireLogin() {
        if (!isset($_SESSION['staff_id'])) {
            $this->redirect('/admin/login');
        }
    }

    public function index() {
        $this->redirect('/admin/login');
    }

    public function login() {
        if (isset($_SESSION['staff_id'])) {
            $this->redirect('/admin/dashboard');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $staff_id = $this->adminModel->adminlogin($username, $password);
            if ($staff_id) {
                $_SESSION['staff_id'] = $staff_id;
                $this->redirect('/admin/dashboard');
            } else {
                $_SESSION['error_message'] = "Invalid Username or Password";
            }
        }
        $this->adminRender('login');
    }

    public function logout() {
        if (isset($_SESSION['staff_id'])) {
            unset($_SESSION['staff_id']);
        }
        $this->redirect('/admin/login');
    }

    public function dashboard() {
        $this->requireLogin();
        $data = [
            'occupiedTables' => $this->adminModel->getOccupiedTables(),
            'finishlist' => $this->adminModel->finishlist(),
            'orderlist' => $this->adminModel->orderlist(),
            'billlist' => $this->adminModel->billlist()
        ];
        $this->adminRender('dashboard', $data);
    }

    public function history() {
        $this->requireLogin();
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 100;
        if ($limit <= 0) $limit = 100;
        
        $data = [
            'historylist' => $this->adminModel->getHistory($limit),
            'limit' => $limit
        ];
        $this->adminRender('history', $data);
    }

    public function kitchen() {
        $this->requireLogin();
        $rawOrders = $this->adminModel->kitchenOrders();
        
        // Group orders by table number for easy kitchen viewing
        $kitchenData = [];
        foreach ($rawOrders as $row) {
            $table = $row['table_no'];
            if (!isset($kitchenData[$table])) {
                $kitchenData[$table] = [
                    'u_id' => $row['u_id'],
                    'time' => $row['dateandtime'],
                    'items' => []
                ];
            }
            $kitchenData[$table]['items'][] = [
                'name' => $row['item_name'],
                'qty' => $row['o_qty'],
                'notes' => $row['notes']
            ];
        }
        
        $this->adminRender('kitchen', ['kitchenData' => $kitchenData]);
    }

    public function items() {
        $this->requireLogin();
        $data = [
            'allitemslist' => $this->adminModel->viewallitems()
        ];
        $this->adminRender('items', $data);
    }

    public function addItem() {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['item_name'];
            $desc = $_POST['item_desc'];
            $cat = $_POST['item_category'];
            $ivn = $_POST['item_veg_non'];
            $price = $_POST['item_price'];
            
            $imgData = null;
            if (isset($_FILES['item_image']) && $_FILES['item_image']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['item_image']['tmp_name'];
                $fileName = time() . '_' . $_FILES['item_image']['name'];
                $uploadPath = ROOT_DIR . DS . 'public' . DS . 'img' . DS . $fileName;
                if (move_uploaded_file($fileTmpPath, $uploadPath)) {
                    $imgData = $fileName;
                }
            } else {
                $imgData = "food_placeholder.png"; // Fallback image
            }

            if ($this->adminModel->insertitems($name, $desc, $cat, $ivn, $price, $imgData)) {
                $_SESSION['success_message'] = "Item Added Successfully!!!";
                $this->redirect('/admin/items');
            } else {
                $_SESSION['error_message'] = "Failed. Try again.";
            }
        }

        $this->adminRender('add_item');
    }

    public function editItem() {
        $this->requireLogin();
        
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->redirect('/admin/items');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['item_name'];
            $desc = $_POST['item_desc'];
            $cat = $_POST['item_category'];
            $ivn = $_POST['item_veg_non'];
            $price = $_POST['item_price'];
            
            $imgData = null;
            if (isset($_FILES['item_image']) && $_FILES['item_image']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['item_image']['tmp_name'];
                $fileName = time() . '_' . $_FILES['item_image']['name'];
                $uploadPath = ROOT_DIR . DS . 'public' . DS . 'img' . DS . $fileName;
                if (move_uploaded_file($fileTmpPath, $uploadPath)) {
                    $imgData = $fileName;
                }
            }

            if ($this->adminModel->updateMenuItem($id, $name, $desc, $cat, $ivn, $price, $imgData)) {
                $_SESSION['success_message'] = "Item Updated Successfully!";
                $this->redirect('/admin/items');
            } else {
                $_SESSION['error_message'] = "Failed to update item.";
            }
        }

        $item = $this->adminModel->getMenuItemById($id);
        if (!$item) {
            $this->redirect('/admin/items');
        }

        $this->adminRender('edit_item', ['item' => $item]);
    }

    public function deleteItem() {
        $this->requireLogin();
        $id = $_GET['id'] ?? null;
        if ($id) {
            if ($this->adminModel->deleteMenuItem($id)) {
                $_SESSION['success_message'] = "Item deleted successfully.";
            } else {
                $_SESSION['error_message'] = "Failed to delete item.";
            }
        }
        $this->redirect('/admin/items');
    }

    public function updateStatus() {
        $this->requireLogin();
        $st = base64_decode($_GET['st'] ?? '');
        $ids = base64_decode($_GET['uds'] ?? '');
        $from = $_GET['from'] ?? 'dashboard';
        
        if ($st && $ids) {
            if ($this->adminModel->updatestatus($st, $ids)) {
                // Success
            } else {
                $_SESSION['error_message'] = 'Failed. Try again';
            }
        }
        
        if ($from === 'kitchen') {
            $this->redirect('/admin/kitchen');
        } else {
            $this->redirect('/admin/dashboard');
        }
    }

    public function clearTable() {
        $this->requireLogin();
        
        if (isset($_GET['table'])) {
            $table = $_GET['table'];
            $result = $this->adminModel->clearTableByNumber($table);
            if ($result) {
                $_SESSION['success_message'] = "Table $table cleared successfully.";
            } else {
                $_SESSION['error_message'] = "Failed to clear table $table.";
            }
        } else {
            // Fallback for old links
            $u_id = $_GET['ids'] ?? null;
            if ($u_id) {
                $result = $this->adminModel->clearTable($u_id);
                if ($result) {
                    $_SESSION['success_message'] = "Table cleared successfully.";
                } else {
                    $_SESSION['error_message'] = "Failed to clear table.";
                }
            }
        }
        $this->redirect('/admin/dashboard');
    }

    public function forceUnlock() {
        $this->requireLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $table = (int)($_POST['table_no'] ?? 0);
            if ($table >= 1 && $table <= 20) {
                if ($this->adminModel->forceUnlockTable($table)) {
                    $_SESSION['success_message'] = "Table $table forcefully unlocked successfully.";
                } else {
                    $_SESSION['error_message'] = "Failed to forcefully unlock Table $table.";
                }
            } else {
                $_SESSION['error_message'] = "Invalid Table Number.";
            }
        }
        $this->redirect('/admin/dashboard');
    }

    public function bill() {
        $this->requireLogin();
        require_once ROOT_DIR . DS . 'libs' . DS . 'fpdf.php';
        
        $ids = $_GET['ids'] ?? null;
        if (!$ids) {
            $this->redirect('/admin/dashboard');
        }

        $rows = $this->adminModel->billlistbyuid($ids);
        if (!$rows || count($rows) == 0) {
            $this->redirect('/admin/dashboard');
        }

        $count = count($rows);

        if($count < 12){
            $pht = 150;
        }else{
            $ct = $count-12;
            $pht = 150+($ct*3.3);
        }
        try {
            $pdf = new FPDF( 'P', 'mm',array(100,$pht) );
            $pdf->SetAutoPagebreak(false);
            $pdf->SetMargins(0,0,0);

            $firstrow = $rows[0];
            $f = 100;
            $tottaxval = 0;
            $totqty = 0;
            $totgrand = 0;

            $pdf->AddPage();
            
            // Add Application Logo
            if (file_exists(ROOT_DIR . DS . 'public' . DS . 'img' . DS . 'logo.png')) {
                // Resize to 24 width to fit nicely above the address
                $pdf->Image(ROOT_DIR . DS . 'public' . DS . 'img' . DS . 'logo.png', 38, 2, 24);
            }

            $pdf->SetXY( 1, 28 ); $pdf->SetFont('Arial','',10);
            $pdf->Cell( $pdf->GetPageWidth(), 5, 'Mangalore Hampankatta', 0, 0, 'C');

            $pdf->SetXY( 1, 32 ); $pdf->SetFont('Arial','',10);
            $pdf->Cell( $pdf->GetPageWidth(), 5, 'Karnataka, India', 0, 0, 'C');

            $pdf->SetXY( 1, 38 ); $pdf->SetFont('Arial','BU',10);
            $pdf->Cell( $pdf->GetPageWidth(), 5, " RECEIPT ", 0, 0, 'C');

            $pdf->SetXY( 5, 44 ); $pdf->SetFont( "Arial", "", 10 ); $pdf->Cell( 160, 8, 'To :  '.$firstrow['user_name'], 0, 0, 'L');

            $pdf->SetXY( 60, 44 ); $pdf->SetFont( "Arial", "", 10 ); $pdf->Cell( 15, 8, 'Table. No : ', 0, 0, 'L');
            $pdf->SetXY( 80, 44 ); $pdf->SetFont( "Arial", "B", 14 ); $pdf->Cell( 15, 8, '#'.$firstrow['table_no'], 0, 0, 'R');

            $pdf->SetXY( 60, 49 ); $pdf->SetFont( "Arial", "", 10 ); $pdf->Cell( 15, 8, 'DATE   : ', 0, 0, 'L');
            $pdf->SetXY( 78, 49 ); $pdf->SetFont( "Arial", "", 8 ); $pdf->Cell( 20, 8, $firstrow['dateandtime'], 0, 0, 'R');

            $pdf->SetLineWidth(0.5); $pdf->Line(5, 57.5, 97, 57.5);
            
            $pdf->SetXY( 5, 56.5 ); $pdf->SetFont( "Arial", "B", 8 ); $pdf->Cell( 45, 8, 'ITEM NAME', 0, 0, 'L');
            $pdf->SetXY( 52, 56.5 ); $pdf->SetFont( "Arial", "B", 8 ); $pdf->Cell( 10, 8, 'QTY', 0, 0, 'C');
            $pdf->SetXY( 65, 56.5 ); $pdf->SetFont( "Arial", "B", 8 ); $pdf->Cell( 12, 8, 'MRP', 0, 0, 'R');
            $pdf->SetXY( 80, 56.5 ); $pdf->SetFont( "Arial", "B", 8 ); $pdf->Cell( 15, 8, 'TOTAL', 0, 0, 'R');

            $pdf->SetLineWidth(0.5); $pdf->Line(5, 63, 97, 63);

            $y = 63;
            $r = 1;

            foreach ($rows as $data)
            {
                $pdf->SetXY( 5, $y ); $pdf->SetFont( "Arial", "", 7 ); $pdf->Cell( 45, 8, $r.' '.$data['item_name'], 0, 0, 'L');
                $pdf->SetXY( 52, $y ); $pdf->SetFont( "Arial", "", 8 ); $pdf->Cell( 10, 8, $data['o_qty'], 0, 0, 'C');
                $pdf->SetXY( 65, $y ); $pdf->SetFont( "Arial", "", 8 ); $pdf->Cell( 12, 8, number_format($data['price'],2), 0, 0, 'R');
                $tot = str_replace(",", "", number_format($data['o_qty']*$data['price'],2));
                $pdf->SetXY( 80, $y ); $pdf->SetFont( "Arial", "", 8 ); $pdf->Cell( 15, 8, $tot, 0, 0, 'R');
                
                $totqty += $data['o_qty'];
                $totgrand += $tot;

                $y += 4;
                $r++;
            }
            
            $pdf->SetLineWidth(0); $pdf->SetDrawColor(80,69,69); $pdf->Line(5, $y+3, 97, $y+3);

            $pdf->SetXY( 52, $y+2 ); $pdf->SetFont( "Arial", "B", 8 ); $pdf->Cell( 10, 8, 'Items: '.$totqty, 0, 0, 'C');
            
            $pdf->SetXY( 80, $y+2 ); $pdf->SetFont( "Arial", "B", 8 ); $pdf->Cell( 15, 8, number_format($totgrand,2), 0, 0, 'R');
            
            $y +=10;
            
            if($y < 100){
                $f =100;
            }else{
                $f = $y;
            }
            $inwords  = $this->getIndianCurrency($totgrand).' Only';
            $pdf->SetLineWidth(0.5); $pdf->Line(5, $f+3, 97, $f+3);
            $pdf->SetXY( 0, $f+5 ); $pdf->SetFont('Arial','',14);
            $pdf->Cell( $pdf->GetPageWidth(), 10, "TOTAL : ".number_format($totgrand,2), 0, 0, 'C');
            $pdf->SetXY( 0, $f+12 ); $pdf->SetFont('Arial','B',8);
            $pdf->Cell( $pdf->GetPageWidth(), 5, "Rs. ".$inwords, 0, 0, 'C');
            
            $pdf->SetXY( 0, $f+19 ); $pdf->SetFont('Arial','B',9);
            $pdf->Cell( $pdf->GetPageWidth(), 10, "THANK YOU, VISIT AGAIN.", 0, 0, 'C');
        
            $nom_file = "bill_" .'-' . str_pad('1091', 2, '0', STR_PAD_LEFT) . ".pdf";
            $pdf->Output("I", $nom_file);
            exit;
        } catch (Exception $e) {
            echo "<h1>FPDF Crash Debug Info</h1>";
            echo "<p><strong>Error Message:</strong> " . $e->getMessage() . "</p>";
            echo "<p>If the error mentions PNG or Alpha channels, the logo.png file format is incompatible with the FPDF library.</p>";
            exit;
        }
    }

    private function getIndianCurrency($number) {
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(0 => '', 1 => 'One', 2 => 'Two',
            3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
            7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
            13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
            16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
            19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
            40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
            70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
        $digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
        while( $i < $digits_length ) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
            } else $str[] = null;
        }
        $Rupees = implode('', array_reverse($str));
        $paise = ($decimal) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
        return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
    }
    }

