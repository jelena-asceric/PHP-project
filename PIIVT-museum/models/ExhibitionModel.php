<?php
  namespace App\Models;
  use \PDO;
  use App\Core\Model;
  use App\Core\Field;
  use \App\Validators\NumberValidator;
  use \App\Validators\DateTimeValidator;
  use \App\Validators\StringValidator;

class ExhibitionModel extends Model{
  protected function getFields(): array{
    return [
        'exhibition_id' => new Field((new NumberValidator())->setIntegerLength(10), false),
        'created_at'    => new Field((new DateTimeValidator())->allowDate()->allowTime(), false),       
        
        'name'          => new Field((new StringValidator())->setMaxLength(128)),
        'location_id'   => new Field((new NumberValidator())->setIntegerLength(11)),
        'admin_id'      => new Field((new NumberValidator())->setIntegerLength(10)),
        'term_id'      => new Field((new NumberValidator())->setIntegerLength(10))
        ];
    
}
 
  public function getByName(string $name){ 
    return $this->getByFieldName('name', $name);
}
//getall location
public function getAllByLocationId(int $locationId): array{ 
  return $this->getAllByFieldName('location_id', $locationId);
  
}
}
