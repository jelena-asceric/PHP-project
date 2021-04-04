<?php
    namespace App\Controllers;
        class AdminLocationManagementController extends \App\Core\Role\AdminRoleController {
            public function locations() {
            $locationModel = new \App\Models\LocationModel($this->getDatabaseConnection());
            $locations = $locationModel->getAll();
            $this->set('locations', $locations);
            }
            public function getEdit($locationId){
                $locationModel = new \App\Models\LocationModel($this->getDatabaseConnection());
                $location = $locationModel->getById($locationId);
       

                if(!$location){
                    $this->redirect(\Configuration::BASE . 'admin/locations');
                }


            $this->set('location', $location);

            return $locationModel;
        }
        //44. smimak
    
    public function postEdit($locationId){
            $locationModel = $this->getEdit($locationId);
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);

            $locationModel->editById($locationId, [
                'name' => $name
            ]);
            $this->redirect(\Configuration::BASE . 'admin/locations');

        }

        public function getAdd(){

        } 
     
        public function postAdd(){
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $locationModel = new \App\Models\LocationModel($this->getDatabaseConnection());
            $locationId = $locationModel->add([
                'name'=> $name,
                
            ]);

            if($locationId){
                $this->redirect(\Configuration::BASE . 'admin/locations');
            }

            $this->set('message', "Doslo je do greske: Nije moguce dodati ovu izlozbu");
        }
   }      