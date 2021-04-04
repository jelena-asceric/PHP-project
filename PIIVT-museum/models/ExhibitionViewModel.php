<?php
    namespace App\Models;
    use \PDO;
    use App\Core\Model;
    use App\Core\Field;
    use \App\Validators\NumberValidator;
    use \App\Validators\DateTimeValidator;
    use \App\Validators\StringValidator;


class ExhibitionViewModel extends Model{
  
   protected function getFields(): array{
    return [
       'exhibition_view_id' => new Field((new NumberValidator())->setIntegerLength(20), false),
       'created_at'         => new Field((new DateTimeValidator())->allowDate()->allowTime() , false), 
        
       'exhibition_id'      => new Field((new NumberValidator())->setIntegerLength(11)),
       'ip_address'         => new Field((new StringValidator(7, 255)) ),
       'user_agent'         => new Field((new \App\Validators\StringValidator(0, 255)) )
    ];
}  

 
  public function getAllByExhibitionId(int $exhibitionId): array {  
    return $this->getAllByFieldName('exhibition_id', $exhibitionId);
    
} 


public function getAllByIpAddress(string $ipAddress): array {  
  return $this->getAllByFieldName('ip_address', $ipAddress);
  
}

}
