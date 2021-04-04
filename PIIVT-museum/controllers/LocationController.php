<?php
    namespace App\Controllers;
    use App\Core\DatabaseConnection;
   

    class LocationController extends \App\Core\Controller {
        
         public function show($id){ //prikazivanje lokacija po id-u
             $locationModel = new \App\Models\LocationModel($this->getDatabaseConnection());
             $location = $locationModel->getById($id);
          
             if(!$location){
                header('location: /');
                exit;
            } 
            

            $this->set('location', $location);
        
            $exhibitionModel = new \App\Models\ExhibitionModel($this->getDatabaseConnection());  //prikazivanje izlozbi za odredjen muzej
            $exhibitionInLocation = $exhibitionModel ->getAllByLocationId($id);
            $this->set('exhibitionInLocation', $exhibitionInLocation);
        }
         
        public function locations(){ // prikazivanje lokacija
            $locationModel = new \App\Models\LocationModel($this->getDatabaseConnection());
            $locations = $locationModel->getAll();
           
            if(!$locations){
               header('location: /');
               exit;
            } 
           
            $this->set('locations', $locations);

        }
         }