<?php

namespace App\Controllers;

class ApiBookmarkController extends \App\Core\ApiController{
    public function getBookmarks() {
       $bookmarks = $this->getSession()->get('bookmarks', []);
        $this->set('bookmarks', $bookmarks);
    }

public function addBookmark($exhibitionId){
    $exhibitionModel = new \App\Models\ExhibitionModel($this->getDatabaseConnection());
    $exhibition = $exhibitionModel->getById($exhibitionId);

    if(!$exhibition) {
        $this->set('error', -1);
        return;
    } 

    $bookmarks = $this->getSession()->get('bookmarks', []);

    foreach ($bookmarks as $bookmark){
       if($bookmark->exhibition_id == $exhibitionId){
            $this->set('error', -2);
            return;

       }
    } 
    
    $bookmarks[] = $exhibition;
    $this->getSession()->put('bookmarks', $bookmarks);

   if(!$exhibition) {
        $this->set('error', 0);
       
   }

}


public function clear() {
   $this->getSession()->put('bookmarks', []);
    $this->set('error', 0);



    }
}