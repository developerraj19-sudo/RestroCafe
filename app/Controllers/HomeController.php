<?php

class HomeController extends BaseController {
    
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/auth');
        }
        
        $admin = new AdminModel();
        $items = $admin->getitemlist();
        
        $this->render('pages/home', ['items' => $items]);
    }
}
    