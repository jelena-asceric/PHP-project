<?php
    namespace App\Controllers;
    use App\Core\DatabaseConnection;
   

    class UserController extends \App\Core\Controller {
        
        public function show($id){ //prikazivanje korisnika
            $userModel = new \App\Models\UserModel($this->getDatabaseConnection());
            $user = $userModel->getById($id);
        
            if(!$user){
                header('location: /');
                exit;
            } 
         
            $this->set('user', $user);
        
            $reservationModel = new \App\Models\ReservationModel($this->getDatabaseConnection());  // prikazivanje korisnika po rezervaciji
            $reservationForUser = $reservationModel ->getAllByTermId();
            $this->set('reservationForUser', $reservationForUser);
         
            
        }

        }