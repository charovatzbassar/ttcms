<?php

require_once __DIR__.'/BaseDao.class.php';

class TournamentDao extends BaseDao {

    public function __construct() {
        parent::__construct("tournament");
    }

    public function getAllTournaments() {
        return $this->query("SELECT t.tournamentID, t.tournamentName, t.tournamentDate, t.tournamentLocation, t.tournamentStatus, t.appUserID, GROUP_CONCAT(tc.category SEPARATOR ', ') AS categories 
        from tournament t 
        join tournamentCategory tc on t.tournamentID = tc.tournamentID
        group by t.tournamentID;
        ", []);
    }

    public function getTournaments($offset, $limit, $order) {
        list($order_column, $order_direction) = parent::parseOrder($order);

        return $this->query("SELECT t.tournamentID, t.tournamentName, t.tournamentDate, t.tournamentLocation, t.tournamentStatus, t.appUserID, GROUP_CONCAT(tc.category SEPARATOR ', ') AS categories 
        from tournament t 
        join tournamentCategory tc on t.tournamentID = tc.tournamentID
        group by t.tournamentID ORDER BY {$order_column} {$order_direction}
                           LIMIT {$limit} OFFSET {$offset};", []);
    }

    public function getTournamentByID($id) {
        return $this->queryUnique("SELECT t.tournamentID, t.tournamentName, t.tournamentDate, t.tournamentLocation, t.tournamentStatus, t.appUserID, GROUP_CONCAT(tc.category SEPARATOR ', ') AS categories 
        from tournament t 
        join tournamentCategory tc on t.tournamentID = tc.tournamentID
        group by t.tournamentID having t.tournamentID = :tournamentID;", ["tournamentID" => $id]);
    }

    public function addTournament($tournament) {
        $this->add($tournament);
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