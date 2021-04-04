<?php
  namespace App\Models;
  use \PDO;
  use App\Core\Model;
  use App\Core\Field;
  use \App\Validators\NumberValidator;
  use \App\Validators\DateTimeValidator;
  use \App\Validators\StringValidator;

class UserModel extends Model {
  protected function getFields(): array{
    return [
        'user_id'        => new Field((new NumberValidator())->setIntegerLength(11), false),
        
        'name'           => new Field((new StringValidator())->setMaxLength(128)),
        'surname'        => new Field((new StringValidator())->setMaxLength(128)),
        'email'          => new Field((new StringValidator())->setMaxLength(128)),
        'phone'          => new Field((new StringValidator())->setMaxLength(24)),
        'address'        => new Field((new StringValidator())->setMaxLength(128))
    ];
}

    public function getByName(string $name){
    return $this->getByFieldName('name', $name);
  } 
 
  public function getByEmail(string $email){ // upit za uzimanje imena iz tabele user
  
    return $this->getByFieldName('email', $email);
}

}