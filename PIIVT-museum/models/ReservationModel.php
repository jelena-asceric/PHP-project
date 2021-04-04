<?php
  namespace App\Models;
  use \PDO;
  //use App\Core\DatabaseConnection;

  use App\Core\Model;
  use App\Core\Field;
  use \App\Validators\NumberValidator;
  use \App\Validators\DateTimeValidator;
  use \App\Validators\StringValidator;


class ReservationModel extends Model{
  protected function getFields(): array{
    return [
        'reservation_id'    => new Field((new NumberValidator())->setIntegerLength(11), false),
        
        'visitors'          => new Field((new NumberValidator())->setUnsigned()->setIntegerLength(7)),
        'arrive_at'         => new Field((new DateTimeValidator())->allowDate()->allowTime()), 
        'language_id'       => new Field((new NumberValidator())->setIntegerLength(11)),
        'user_id'           => new Field((new NumberValidator())->setIntegerLength(11)),
        'term_id'           => new Field((new NumberValidator())->setIntegerLength(11)),
        'admin_id'          => new Field((new NumberValidator())->setIntegerLength(11))
    ];
}




public function getAllByTermId(int $termId): array { // upit za uzimanje id termina iz tabele rezervacija
    return $this->getAllByFieldName('term_id', $termId);
}

public function getAllByUserId(int $userId): array { // upit za uzimanje user-id iz tabele rezervacija
  return $this->getAllByFieldName('user_id', $userId);

}

public function getAllByLanguageId(int $languageId): array { // upit za uzimanje language-id iz tabele language
  return $this->getAllByFieldName('language_id', $languageId);

}

public function insertReservation(int $term_id, int $user_id, int $visitors){
  return $this->getAllByFieldName('term_id', $term_id);
  return $this->getAllByFieldName('user_id', $user_id);
  return $this->getAllByFieldName('visitors', $visitors);
  


}

}