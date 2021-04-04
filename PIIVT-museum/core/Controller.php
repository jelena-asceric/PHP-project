<?php
  namespace App\Core;

  class Controller {
    private $dbc;
    private $session;
    private $data = [];
    
    //da se ne koristi kao sastavni deo rute, __ izvrsava se pre izvrsavanja trazenja metode
    public function __pre() {

    }

    final function __construct(DatabaseConnection &$dbc){
        $this->dbc = $dbc;
    }

    final public function &getSession(): \App\Core\Session\Session {
        return $this->session;
    }

    final public function setSession(\App\Core\Session\Session &$session) {
        $this->session = $session;
    }

    final public function &getDatabaseConnection(): \App\Core\DatabaseConnection {
        return $this->dbc;
    }
    
    final protected function set(string $name, $value): bool{
        $result = false;

        if(preg_match('/^[a-z][a-z0-9]+(?:[A-Z][a-z0-9]+)*$/', $name)){
            $this->data[$name] = $value;
            $result = true;
        }

       return $result;
    }
    
    final public function getData(): array{
        return $this->data;
    }

    final protected function redirect(string $path, int $code = 303){
        ob_clean();
        header('Location: ' . $path, true,  $code);
        exit;
    }
  }
 