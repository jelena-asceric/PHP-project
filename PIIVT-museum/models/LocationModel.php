<?php
namespace App\Models;
use \PDO;
use App\Core\Model; 
use App\Core\Field;
use \App\Validators\NumberValidator;
use \App\Validators\DateTimeValidator;
use \App\Validators\StringValidator;

class LocationModel extends Model {
    protected function getFields(): array{
        return [
            'location_id'      => new Field((new NumberValidator())->setIntegerLength(11), false),
            
            'name'             => new Field((new StringValidator())->setMaxLength(60)),
            'admin_id'         => new Field((new NumberValidator())->setIntegerLength(11))
            
        ];
    }
   
    public function getByName(string $name){ // upit za uzimanje imena lokacija iz tabele muzej
        return $this->getByFieldName('name', $name);

   


    }
}