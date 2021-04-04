<?php
    namespace App\Controllers;
    use App\Core\DatabaseConnection;
   

    class ImageController extends \App\Core\Controller {
        
        public function show($id){ //prikazivanje slika po id-u
            $imageModel = new \App\Models\ImageModel($this->getDatabaseConnection());
            $image = $imageModel->getById($id);
            $this->set('image', $image);
        

       
            $exhibitionModel = new \App\Models\ExhibitionModel($this->getDatabaseConnection()); // prikazivanje slike po izlozbi
            $exhibition = $exhibitionModel->getById($image->exhibitionId);
            $this->set('exhibitionId', $exhibition);
       
            $imageModel = new \App\Models\ImageModel($this->getDatabaseConnection());  // uzimanje id izlozbe i prikazivanje termina u Izlozbi
            $imageInExhibition = $imageModel ->getAllByExhibitionId($id);
            $this->set('imageInExhibition', $imageInExhibition);
        }
    }