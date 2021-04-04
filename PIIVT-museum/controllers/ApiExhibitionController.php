<?php 
    namespace App\Controllers;

    class ApiExhibitionController extends \App\Core\ApiController {
       public function show($id){
        $exhibitionModel = new \App\Models\ExhibitionModel($this->getDatabaseConnection());
        $exhibition = $exhibitionModel->getById($id);
        $this->set('exhibition', $exhibition);

        $termModel = new \App\Models\TermModel($this->getDatabaseConnection());  // uzimanje id izlozbe i prikazivanje termina u Izlozbi
        $termInExhibition = $termModel ->getTermsByExhibition($id);
        $this->set('termInExhibition', $termInExhibition);

        $imageModel = new \App\Models\ImageModel($this->getDatabaseConnection());  // uzimanje id izlozbe i prikazivanje slika u Izlozbi
        $imageInExhibition = $imageModel ->getAllByExhibitionId($id);
        $this->set('imageInExhibition', $imageInExhibition);
            
    }
}