<?php
namespace App\Models;
use \PDO;
use App\Core\Model;
use App\Core\Field;
use \App\Validators\NumberValidator;
use \App\Validators\DateTimeValidator;
use \App\Validators\StringValidator;

class ImageModel extends Model{
    protected function getFields(): array{
        return [
            'image_id'         => new Field((new NumberValidator())->setIntegerLength(11), false),
            
            'name'             => new Field((new StringValidator())->setMaxLength(60)),
            'url'              => new Field((new StringValidator())->setMaxLength(255)),
            'description'      => new Field((new StringValidator())->setMaxLength(60)),
            'exhibition_id'    => new Field((new NumberValidator())->setIntegerLength(11)),
            'admin_id'         => new Field((new NumberValidator())->setIntegerLength(11)),
        ];
    }





    public function getByUrl(string $url){
        return $this->getByFieldName('url', $url);
    
   }

   public function getByName(string $name){
    return $this->getByFieldName('name', $name);

}

   public function getAllByExhibitionId(int $exhibitionId): array{ 
    return $this->getAllByFieldName('exhibition_id', $exhibitionId);
    
}
}