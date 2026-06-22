<?php

class AuthController extends BaseController {
    
    public function index() {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/home');
        }
        $this->render('pages/login');
    }
    
    public function login() {
        if (isset($_POST['submit'])) {
            $username = trim($_POST['username']);
            $tableno = (int)trim($_POST['tableno']);
            
            if ($tableno < 1 || $tableno > 20) {
                $_SESSION['error_message'] = "Invalid Table Number. Please enter a table between 1 and 20.";
                $this->redirect('/');
                return;
            }

            $admin = new AdminModel();
            
            // Check if same user is at table
            $exists = $admin->checkusersame($username, $tableno);
            
            if ($exists) {
                $_SESSION['user_id'] = $exists['user_id'];
                $_SESSION['table'] = $exists['table'];
                $_SESSION['success_message'] = "Welcome back, $username!";
                $this->redirect('/home');
            } else {
                $occupant = $admin->checkTableOccupied($tableno);
                if ($occupant && strtolower($occupant) !== strtolower($username)) {
                    $_SESSION['error_message'] = "Table $tableno is currently occupied. Please choose another table or wait for it to be cleared.";
                    $this->redirect('/');
                } else {
                    $inserted = $admin->insertuser($username, $tableno);
                    if ($inserted) {
                        $_SESSION['user_id'] = $inserted['user_id'];
                        $_SESSION['table'] = $inserted['table'];
                        $_SESSION['success_message'] = "Welcome, $username!";
                        $this->redirect('/home');
                    } else {
                        $_SESSION['error_message'] = "Failed to login. Please try again.";
                        $this->redirect('/');
                    }
                }
            }
        } else {
            $this->redirect('/');
        }
    }
    
    public function logout() {
        if (isset($_SESSION['user_id'])) {
            $admin = new AdminModel();
            $admin->deleteIfNoOrders($_SESSION['user_id']); // Free table if they just browsed and left
            
            unset($_SESSION['user_id']);
            unset($_SESSION['table']);
        }
        $this->redirect('/');
    }

    public function checkStatus() {
        header('Content-Type: application/json');
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['cleared' => true]);
            exit;
        }
        $admin = new AdminModel();
        if ($admin->isUserCleared($_SESSION['user_id'])) {
            echo json_encode(['cleared' => true]);
        } else {
            echo json_encode(['cleared' => false]);
        }
        exit;
    }
}
