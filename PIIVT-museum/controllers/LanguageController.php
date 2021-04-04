<?php
    namespace App\Controllers;
    use App\Core\DatabaseConnection;
   

    class LanguageController extends \App\Core\Controller {
        
        public function show($id){ //prikazivanje jezika
            $languageModel = new \App\Models\LanguageModel($this->getDatabaseConnection());
            $language = $languageModel->getById($id);
         
            $this->set('language', $language);
         

         
            $reservationModel = new \App\Models\ReservationModel($this->getDatabaseConnection());  // prikazivanje korisnika po rezervaciji
            $reservationLanguage = $reservationModel ->getAllBTermId();
            $this->set('reservationLanguage', $reservationLanguage);
         
        }

        }