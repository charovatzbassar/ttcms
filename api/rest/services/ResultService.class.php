<?php
require_once __DIR__.'/../dao/ResultDao.class.php';

class ResultService {
    private $resultDao;

    public function __construct($resultDao) {
        $this->resultDao = $resultDao;
    }

    public function getAllResults() {
        return $this->resultDao->getAllResults();
    }

    public function getResults($offset, $limit, $order) {
        return $this->resultDao->getResults($offset, $limit, $order);
    }

    public function getResultByID($id) {
        return $this->resultDao->getResultByID($id);
    }

    public function addResult($result) {
        return $this->resultDao->addResult($result);
    }

    public function updateResult($id, $result) {
        return $this->resultDao->updateResult($id, $result);
    }

    public function deleteResult($id) {
        return $this->resultDao->deleteResult($id);
    }

    public function getResultsByTournamentID($tournamentID) {
        return $this->resultDao->getResultsByTournamentID($tournamentID);
    }

    public function getResultsByClubMemberID($clubMemberID) {
        return $this->resultDao->getResultsByClubMemberID($clubMemberID);
    }

    public function deleteResultsForTournament($tournamentID) {
        return $this->resultDao->deleteResultsForTournament($tournamentID);
    }

    public function deleteResultsForMember($clubMemberID) {
        return $this->resultDao->deleteResultsForMember($clubMemberID);
    }

}

?>