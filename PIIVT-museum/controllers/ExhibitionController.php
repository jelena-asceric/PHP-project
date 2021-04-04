<?php
   namespace App\Controllers;

   class ExhibitionController extends \App\Core\Controller{
      // private $dbc;

      

       public function show($id){
          $exhibitionModel = new \App\Models\ExhibitionModel($this->getDatabaseConnection());
          $exhibition = $exhibitionModel->getById($id);
         
          //kontrola prikaza, da se ne prikazu nepotpune informacije
          if (!$exhibition) {
            header('Location:   /');
            exit;
        }

          $this->set('exhibition', $exhibition);
          
         $termModel = new \App\Models\TermModel($this->getDatabaseConnection());
         $termInExhibition = $termModel->getTermsByExhibition($id); 
         $this->set('termInExhibition', $termInExhibition);
         
         $imageModel = new \App\Models\ImageModel($this->getDatabaseConnection());  // uzimanje id izlozbe i prikazivanje slika u Izlozbi
         $imageInExhibition = $imageModel->getAllByExhibitionId($id);
         $this->set('imageInExhibition', $imageInExhibition);

         $exhibitionViewModel = new \App\Models\ExhibitionViewModel($this->getDatabaseConnection());
         $ipAddress = filter_input(INPUT_SERVER, 'REMOTE_ADDR');
         $userAgent = filter_input(INPUT_SERVER, 'HTTP_USER_AGENT');
        

        $exhibitionViewModel->add(
          [

          'exhibition_id' => $id,
          'ip_address' => $ipAddress,
          'user_agent' => $userAgent,
          
          ]
       );
       

       $imageModel = new \App\Models\ImageModel($this->getDatabaseConnection());
       $image = $imageModel->getById($id);
       $this->set('image', $image);
        
      }


        

       public function exhibitions()
    { // uzimanje svih podataka iz baze i prikazivanje izlozbi 'exhibitions' metod
        $exhibitionsModel = new \App\Models\ExhibitionModel($this->getDatabaseConnection());
        $exhibitions = $exhibitionsModel->getAll();

        if (!$exhibitions) {
            header('location:  /');
            exit;
        }

        $this->set('exhibitions', $exhibitions);
        
    }
   

  }
   