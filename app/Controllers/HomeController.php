<?php

class HomeController extends BaseController {
    
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/auth');
        }
        
        $admin = new AdminModel();
        $items = $admin->getitemlist();
        
        if (isset($_GET['debug'])) {
            echo "<h1>DEBUG INFO</h1>";
            echo "<pre>";
            echo "Items count: " . count($items) . "\n";
            print_r($items);
            echo "</pre>";
            exit;
        }
        
        $this->render('pages/home', ['items' => $items]);
    }
}
    