<?php
require_once __DIR__.'/../dao/TournamentDao.class.php';

class TournamentService {
    private $tournamentDao;

    public function __construct($tournamentDao) {
        $this->tournamentDao = $tournamentDao;
    }

    public function getAllTournaments() {
        return $this->tournamentDao->getAllTournaments();
    }

    public function getTournaments($offset, $limit, $order) {
        return $this->tournamentDao->getTournaments($offset, $limit, $order);
    }

    public function getTournamentByID($id) {
        return $this->tournamentDao->getTournamentByID($id);
    }

    public function addTournament($tournament) {
        return $this->tournamentDao->addTournament($tournament);
    }

    public function updateTournament($id, $tournament) {
        return $this->tournamentDao->updateTournament($id, $tournament);
    }

    public function deleteTournament($id) {
        return $this->tournamentDao->deleteTournament($id);
    }

    public function markTournamentAsCompleted($id) {
        return $this->tournamentDao->markTournamentAsCompleted($id);
    }


}

?>