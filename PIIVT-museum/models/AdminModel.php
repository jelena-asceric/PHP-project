<?php
namespace App\Models;
use \PDO;
use App\Core\Model;
use App\Core\Field;
use \App\Validators\NumberValidator;
use \App\Validators\DateTimeValidator;
use \App\Validators\StringValidator;


class AdminModel extends Model{
    protected function getFields(): array{
        return [
            'admin_id'          => new Field((new NumberValidator())->setIntegerLength(11), false),
            'created_at'        => new Field((new DateTimeValidator())->allowDate()->allowTime()),
            'name'              => new Field((new StringValidator())->setMaxLength(128)),
            'surname'           => new Field((new StringValidator())->setMaxLength(128)),
            'email'             => new Field((new StringValidator())->setMaxLength(128)),
            'username'          => new Field((new StringValidator())->setMaxLength(45)),
            'password'          => new Field((new StringValidator())->setMaxLength(128))
            
        ];
    }
    
    public function getByName(string $name){ 
        return $this->getByFieldName('name', $name);
    }

}