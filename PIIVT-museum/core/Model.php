<?php

namespace App\Core;
use PDO;

abstract class Model{
    private $dbc;

    final public function __construct(DatabaseConnection &$dbc){
         $this->dbc= $dbc;

    }

    //niz brojeva,stringova..bitno je dabude niz objekata, validna vrednost i indikator da li polje moze da se menja posle setovanja
    protected function getFields(): array{
        return [];
    }

    final protected function getConnection(){
         return $this->dbc->getConnection();

    }
 //static::class -> vratice ime klase unutar koje je metod koji se izvrsava
// i koji poziva metod getTableName
//!
 private function getTableName(): string{
        $fullName;
        $matches = [];
        preg_match('|^.*\\\((?:[A-Z][a-z]+)+)Model$|', static::class, $matches);

        return substr(strtolower(preg_replace('|[A-Z]|', '_$0', $matches[1] ?? '')), 1);
    }

//final->ne sme nista da se menja, moze samo da se nadogradjuje
   
  final public function getById(int $Id){
        $tableName = $this->getTableName();
        $sql= 'SELECT * FROM '. $tableName . ' WHERE  ' . $tableName . '_id= ?;';
        $prep = $this->dbc->getConnection()->prepare($sql);
        $res = $prep->execute([$Id]);
        $item = null;
        if($res){
            $item = $prep->fetch(PDO::FETCH_OBJ);
        }
        return $item;
 
    }
 
   final public function getAll(): array{
     $tableName = $this->getTableName();
     $sql= 'SELECT * FROM ' . $tableName .';';
     $prep = $this->dbc->getConnection()->prepare($sql);
     $res = $prep->execute();
     $items = [];
     if($res){
        $items = $prep->fetchAll(PDO::FETCH_OBJ);
     }
     return $items;
   }

  final private function isFieldValueValid(string $fieldName, $fieldValue): bool{
       $fields = $this->getFields();
       $supportedFieldNames = array_keys($fields);

       if (!in_array($fieldName, $supportedFieldNames)) {
           return false;
       }

       return $fields[$fieldName]->isValid($fieldValue);
   }


  final public function getByFieldName(string $fieldName, $value){
        if (!$this->isFieldValueValid($fieldName, $value)) {
            throw new \Exception('Invalid field name or value: '.$fieldName);
        }

        $tableName = $this->getTableName();
        $sql = 'SELECT * FROM '. $tableName .' WHERE '. $fieldName .'= ?;';
        $prep = $this->dbc->getConnection()->prepare($sql);
        $res = $prep->execute([$value]);
        $item = null;
        if ($res) {
            $item = $prep->fetch(PDO::FETCH_OBJ);
        }

        return $item;
    }
 
    final public function getAllByFieldName(string $fieldName, $value): array{
        if (!$this->isFieldValueValid($fieldName, $value)) {
            throw new \Exception('Invalid field name or value! '.$fieldName);
        } 
        $tableName = $this->getTableName();
        $sql = 'SELECT * FROM '.$tableName.' WHERE '.$fieldName.'= ?;';

        $prep = $this->dbc->getConnection()->prepare($sql);
        $res = $prep->execute([$value]);
        $items = [];
        if ($res) {
            $items = $prep->fetchAll(PDO::FETCH_OBJ);
        }

        return $items;
    }

 private function checkFieldList(array $data) {
        

        $fields = $this->getFields();
        $supportedFieldNames = array_keys($fields);
        $requestedFieldNames = array_keys($data);

        foreach ($requestedFieldNames as $requestedFieldName) {
            if (!in_array($requestedFieldName, $supportedFieldNames)) {
                throw new \Exception('Field'.$requestedFieldName.'is not supported');
            }

            if (!$fields[$requestedFieldName]->isEditable()) {
                throw new \Exception('Field'.$requestedFieldName.'is not editable');
            }

            if (!$fields[$requestedFieldName]->isValid($data[$requestedFieldName])) {
                throw new \Exception('The value for the field'.$requestedFieldName.'is not valid');
            }
        }
    }
    

    final public function add(array $data){
        //samo imena polja koja postoje u spisku polja modela
        //da li je kljuc odgovarajuci
        //priprema INSERT INTO
        //IZVRSAVANJE IZRAZA    
        $this->checkFieldList($data);
        
        $tableName = $this->getTableName();
        $sqlFieldNames = implode(', ', array_keys($data));

        $questionMarks = str_repeat('?,', count($data));
        $questionMarks = substr($questionMarks, 0, -1);

        $sql = "INSERT INTO {$tableName} ({$sqlFieldNames}) VALUES ({$questionMarks});";

        $prep = $this->dbc->getConnection()->prepare($sql);
        $res = $prep->execute(array_values($data));
        if (!$res) {
            return false;
        }

        return $this->dbc->getConnection()->lastInsertId();
   
 }

final public function editById(int $id, array $data){
        $this->checkFieldList($data);

        $tableName = $this->getTableName();

        $editList = [];
        $values = [];
        foreach ($data as $fieldName => $value) {
            $editList[] = "{$fieldName} = ?";
            $values[] = $value;
        }
        $editString = implode(', ', $editList);

        $values[] = $id;

        $sql = "UPDATE {$tableName} SET {$editString} WHERE {$tableName}_id = ?;";
        $prep = $this->dbc->getConnection()->prepare($sql);

        return $prep->execute($values);
    }

final public function deleteById(int $id){

        $tableName = $this->getTableName();
        $sql = 'DELETE FROM '. $tableName .' WHERE '. $tableName .'_id = ?;';
        $prep = $this->dbc->getConnection()->prepare($sql);
        return $prep->execute([$id]);

    }

    public function getAllUserByTermId(int $id): array
    { // upit za spisak svih usera za odrednjeni termin koji su izvrsili rezervaciju
        $sql = 'SELECT `reservation`.* , `user`.*, J.`name` as `jname` FROM `reservation` INNER JOIN `user` ON `reservation`.`user_id`= `user`.`user_id` 
        INNER JOIN `language` J ON `reservation`.`language_id`=`J`.`language_id`
        WHERE `term_id` =  ?';
        $prep = $this->dbc->getConnection()->prepare($sql);
        $res = $prep->execute([$id]);
        $items = [];
        if ($res) {
            $items = $prep->fetchAll(PDO::FETCH_OBJ);
        }

        return $items;
    }

    public function getTermsById(int $id): array
    { // upit za racunanje slobodnih mesta za odredjeni termin
        $sql = 'SELECT `term`.`capacity` - 
        (SELECT SUM(`reservation`.`visitors`) 
        as dfdf FROM `reservation`  WHERE `term_id`  = ?) 
        as free_space FROM `term` WHERE
        `term_id`= ?;';
        $prep = $this->dbc->getConnection()->prepare($sql);
        $res = $prep->execute([$id, $id]);
        $items = [];
        if ($res) {
            $items = $prep->fetchAll(PDO::FETCH_OBJ);
        }

        return $items;
    }

    public function getTermsByExhibition(int $id): array
    { // upit za racunanje slobodnih mesta za odredjeni termin
        $sql = 'select `T`.`starts_at` as start, `T`.`capacity` as cap, `T`.`term_id`, `E`.*, 

    `T`.`capacity` - (SELECT 
    

    CASE
    WHEN SUM(`reservation`.`visitors`) IS NULL THEN 0

    ELSE SUM(`reservation`.`visitors`)
    END
    
    
    
    as visitor FROM `reservation`
        WHERE `term_id`  = `T`.`term_id`) as free_space 
 
    from `exhibition` E LEFT JOIN `term` T ON `E`.`exhibition_id` = `T`.`exhibition_id`
    
 WHERE E.`exhibition_id` = ?;';

        $prep = $this->dbc->getConnection()->prepare($sql);
        $res = $prep->execute([$id]);
        $items = [];
        if ($res) {
            $items = $prep->fetchAll(PDO::FETCH_OBJ);
        }

        return $items;
    } 
}