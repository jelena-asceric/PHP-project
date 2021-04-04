<?php

namespace App\Controllers;

class ReservationController extends \App\Core\Role\AdminRoleController
{
    public function show($id)
    { //prikazivanje rezervacija po id-u
        $reservationModel = new \App\Models\ReservationModel($this->getDatabaseConnection());
        $reservation = $reservationModel->getAllByFieldName('term_id', $id);

        if (!$reservation) {
            header('location: /');
            exit;
        }
        $this->set('reservation', $reservation);

        $reservationModel = new \App\Models\ReservationModel($this->getDatabaseConnection());  // uzimanje id izlozbe i prikazivanje termina u Izlozbi
        $usersInReservation = $reservationModel->getAllUserByTermId($id);
        $this->set('usersInReservation', $usersInReservation);

        $freeSpaceTerm = $reservationModel->getTermsById($id); // prikaz slobodnih mesta za izlozbu

        $this->set('freeSpaceTerm', $freeSpaceTerm[0]->free_space);
    }

    public function reservations()
    { //prikazivanje izlozbi
        $reservationsModel = new \App\Models\ReservationModel($this->getDatabaseConnection());
        $reservations = $reservationsModel->getAll();

        if (!$reservations) {
            header('location: /');
            exit;
        }

        $this->set('reservations', $reservations);

        $termModel = new \App\Models\TermModel($this->getDatabaseConnection());  // prikazivanje termina
        $terms = $termModel->getAll();
        $this->set('terms', $terms);
    }

}