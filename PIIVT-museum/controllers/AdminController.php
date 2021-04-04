<?php
    namespace App\Controllers;
    use App\Core\DatabaseConnection;
   

    class AdminController extends \App\Core\Controller {
        
        public function show($id){ //prikazivanje admina
            $adminModel = new \App\Models\AdminModel($this->getDatabaseConnection());
            $admin = $adminModel->getById($id);
            $this->set('admin', $admin);
         

        }

        }