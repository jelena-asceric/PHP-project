<?php
   namespace App\Controllers;

   class TermController extends \App\Core\Controller{
      // private $dbc;

      
 
       public function show($id){
         $termModel = new \App\Models\TermModel($this->getDatabaseConnection());
         $term = $termModel ->getById($id); 
      //ako je term false and null
      //ako nema termina redirektuje na homepage 
         if(!$term){
            header('Location:/');
            exit;

         }
         
         $this->set('term', $term);
       //!
         $reservationModel = new \App\Models\ReservationModel($this->getDatabaseConnection());  //  prikazivanje rezervacija za odredjeni termin
         $reservationInTerm = $ReservationModel->getAllByTermId($id);
         $this->set('reservationInTerm', $reservationInTerm);
         //filter pretraga po exhibition_id
           
        }
      
        public function postSearch()
        {
            $termModel = new \App\Models\TermModel($this->getDatabaseConnection());
    
            $dateTime = \filter_input(INPUT_POST, 'q', FILTER_SANITIZE_STRING);
    
            $dateTime1 = $dateTime.' 00:00';
            $dateTime2 = $dateTime.' 23:59';
    
            $terms = $termModel->getAllBySearch($dateTime1, $dateTime2);
    
            $this->set('terms', $terms);
        }


        }