<?php
namespace App\Models;
use \PDO;
use App\Core\Model; 
use App\Core\Field;
use \App\Validators\NumberValidator;
use \App\Validators\DateTimeValidator;
use \App\Validators\StringValidator;

class LanguageModel extends Model {
    protected function getFields(): array{
        return [
            'language_id'      => new Field((new NumberValidator())->setIntegerLength(11), false),
            
            'name'             => new Field((new StringValidator())->setMaxLength(60)),
            'admin_id'         => new Field((new NumberValidator())->setIntegerLength(11))
        ];
    }
   

    public function getByName(string $name){ // upit za ime za termin
        return $this->getByFieldName('name', $name);
    }


}