<?php
  namespace App\Models;
  use App\Core\Model;
  use App\Core\Field;
use \App\Validators\BitValidator;
use \App\Validators\NumberValidator;
use \App\Validators\DateTimeValidator;

class TermModel  extends Model{
  
  protected function getFields(): array
    {
        return [
            'term_id' => new Field((new NumberValidator())->setIntegerLength(11), false),
            'created_at' => new Field((new DateTimeValidator())->allowDate()->allowTime(), false),

            'starts_at' => new Field((new DateTimeValidator())->allowDate()->allowTime()),
            'ends_at' => new Field((new DateTimeValidator())->allowDate()->allowTime()),

            'capacity' => new Field((new NumberValidator())->setUnsigned()->setIntegerLength(7)),
            'is_active' => new Field(new BitValidator()),
            'exhibition_id' => new Field((new NumberValidator())->setIntegerLength(11)),
            'admin_id' => new Field((new NumberValidator())->setIntegerLength(11))
        ];
    }
  

  public function getAllByExhibitionId(int $exhibitionId): array{
      // upit za uzimanje id izlozbe iz tabele rezervacija
      return $this->getAllByFieldName('exhibition_id', $exhibitionId);
  }

 public function getAllBySearch(string $datum1, string $datum2) {
    
   $sql = 'select `T`.`starts_at` as start, `T`.`capacity` as cap, `T`.`term_id`, `E`.*, 

       `T`.`capacity` - (SELECT SUM(`reservation`.`visitors`) as visitor FROM `reservation`
           WHERE `term_id`  = `T`.`term_id`) as free_space 
     
        from `exhibition` E LEFT JOIN `term` T ON `E`.`exhibition_id` = `T`.`exhibition_id`
        
   where starts_at between ? and ?;';

   $prep = $this->getConnection()->prepare($sql);
    if (!$prep) {
        return[];
    }
   $res = $prep->execute([$datum1, $datum2]);
    if (!$res) {
       return [];
    }

    return $prep->fetchAll(\PDO::FETCH_OBJ);
}

  }
