<?php

class BaseController {
    
    // Renders a view and passes data to it
    public function render($view, $data = []) {
        // Extract variables to be used in the view
        extract($data);
        
        $viewFile = VIEWS_DIR . DS . $view . '.php';
        
        if (file_exists($viewFile)) {
            // Load layout
            require_once VIEWS_DIR . DS . 'layout' . DS . 'header.php';
            // Load view content
            require_once $viewFile;
            // Load footer
            require_once VIEWS_DIR . DS . 'layout' . DS . 'footer.php';
        } else {
            die("View $view not found.");
        }
    }

    public function redirect($url) {
        header("Location: " . BASE_URL . $url);
        exit;
    }
}
