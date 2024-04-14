<?php

require_once __DIR__.'/BaseDao.class.php';

class TournamentDao extends BaseDao {

    public function __construct() {
        parent::__construct("tournament");
    }

    public function getAllTournaments() {
        return $this->get_all();
    }

    public function getTournaments($offset, $limit, $order) {
        return $this->get($offset, $limit, $order);
    }

    public function getTournamentByID($id) {
        return $this->get_by_id($id, "tournamentID");
    }

    public function addTournament($tournament) {
        $this->insert("tournament", $tournament);
    }

    public function updateTournament($id, $tournament) {
        $this->update($id, $tournament, "tournamentID");
    }

    public function deleteTournament($id) {
        $this->delete($id, "tournamentID");
    }

    public function markTournamentAsCompleted($id) {
        $this->query("UPDATE tournament SET tournamentStatus = 'COMPLETED' WHERE tournamentID = :tournamentID", ["tournamentID" => $id]);
    }
}

?>