<?php
   namespace App\Controllers;

   /* snimak 41 */

   class MainController extends \App\Core\Controller {
       public function home(){
          $exhibitionModel = new \App\Models\ExhibitionModel($this->getDatabaseConnection());

          $exhibitions = $exhibitionModel->getAll();


           $this->set('exhibitions', $exhibitions);

           $locationModel = new \App\Models\LocationModel($this->getDatabaseConnection());
           $locations = $locationModel->getAll();
           $this->set('locations', $locations);
          
         $termModel = new \App\Models\TermModel($this->getDatabaseConnection());
          $terms = $termModel->getAll();
          $this->set('terms', $terms);

         $reservationModel = new \App\Models\ReservationModel($this->getDatabaseConnection());
           $reservations = $reservationModel->getAll();
          $this->set('reservations', $reservations);
        


         //$this->getSession()->put('neki_klj', 'nek vred');
          
          //$this->getSession()->clear();

           $staraVrednost = $this->getSession()->get('brojac', 0);
           $novaVrednost = $staraVrednost + 1;
           $this->getSession()->put('brojac', $novaVrednost);

           $this->set('podatak', $staraVrednost);
       }
          //$this->getSession()->put('neki_klj', 'nek vred');
          
          //$this->getSession()->clear();

       // $staraVrednost = $this->getSession()->get('brojac', 0);
       // $novaVrednost = $staraVrednost + 1;
       // $this->getSession()->put('brojac', $novaVrednost);

       // $this->set('podatak', $staraVrednost);
    
  

 
           
        

      public function getLogin(){
      }
    

      public function postLogin(){
        $username = \filter_input(INPUT_POST, 'login_username', FILTER_SANITIZE_STRING);
        $password = \filter_input(INPUT_POST, 'login_password', FILTER_SANITIZE_STRING);
      
        $validanPassword = (new \App\Validators\StringValidator())
                    ->setMinLength(7)
                    ->setMaxLength(120)
                    ->isValid($password);

        if (!$validanPassword) {
            $this->set('message', 'Došlo je do greške: Lozinka nije ispravnog formata.');

            return;
        }

        $adminModel = new \App\Models\AdminModel($this->getDatabaseConnection());

        $admin = $adminModel->getByFieldName('username', $username);
        if (!$admin) {
            $this->set('message', 'Doslo je do greške: Ne postoji korisnik sa tim korisničkim imenom.');

            return;
        }

        if (!password_verify($password, $admin->password)) {
         sleep(1);
         $this->set('message', 'Došlo je do greške: Lozinka nije ispravna.');


         return;
     }
       
        $this->getSession()->put('admin_id', $admin->admin_id);
        $this->getSession()->save();

        $this->redirect(\Configuration::BASE . 'admin/profile');


      }
      
  

public function getReservation()
    {
        //$term_id = $_GET['term_id'];
        $term_id = \filter_input(INPUT_GET, 'term_id', FILTER_SANITIZE_NUMBER_INT);
        $this->set('term_id', $term_id);
    }

    public function postReservation()
    {
        $term_id = \filter_input(INPUT_POST, 'term_id', FILTER_SANITIZE_NUMBER_INT);
        // $term_id = $_POST['term_id'];
        $term_id = (int) $term_id;
        $termModel = new \App\Models\TermModel($this->getDatabaseConnection());
        $languageModel = new \App\Models\LanguageModel($this->getDatabaseConnection());
        $term = $termModel->getById($term_id);
        $languages = $languageModel->getAll();

        $this->set('term', $term);
        $this->set('languages', $languages);
    }

    public function postReservationTermUser()
    {
        $name = \filter_input(INPUT_POST, 'res_name', FILTER_SANITIZE_STRING);
        $surname = \filter_input(INPUT_POST, 'res_surname', FILTER_SANITIZE_STRING);
        $email = \filter_input(INPUT_POST, 'res_email', FILTER_SANITIZE_EMAIL);
        $phone = \filter_input(INPUT_POST, 'res_phone', FILTER_SANITIZE_STRING);
        $address = \filter_input(INPUT_POST, 'res_address', FILTER_SANITIZE_STRING);
        $term_id = \filter_input(INPUT_POST, 'term_id', FILTER_SANITIZE_NUMBER_INT);
        $user_id = \filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
        $visitors = \filter_input(INPUT_POST, 'res_visitors', FILTER_SANITIZE_NUMBER_INT);
        $language_id = \filter_input(INPUT_POST, 'language_id', FILTER_SANITIZE_NUMBER_INT);

        $term_id = (int) $term_id;
        $visitors = (int) $visitors;
        $userModel = new \App\Models\UserModel($this->getDatabaseConnection());
        $user = $userModel->getByEmail($email);

        if (!$user) {
            $user_id = $userModel->add([
                    'name' => $name,
                    'surname' => $surname,
                    'email' => $email,
                    'phone' => $phone,
                    'address' => $address,
                    ]);

            $reservationModel = new \App\Models\ReservationModel($this->getDatabaseConnection());
            $reservationModel->insertReservation($term_id, $user_id, $visitors, $language_id);

            $reservationId = $reservationModel->add([
                            'term_id' => $term_id,
                            'user_id' => $user_id,
                            'visitors' => $visitors,
                            'language_id' => $language_id,
                         ]);
            $this->set('message', 'Uspesno ste izvrsili rezervaciju');
        } else {
            $user_id = (int) $user->user_id;

            $this->set('message', 'Postoji korisnik sa tim emajlom');
        }
    }

    public function getLogout()
    {
        $this->getSession()->remove('admin_id');
        $this->getSession()->save();

        $this->redirect(\Configuration::BASE);
    } 
   }