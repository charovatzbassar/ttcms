<?php

require_once __DIR__.'/BaseDao.class.php';

class TournamentDao extends BaseDao {
    private $userID;

    public function __construct($userID = NULL) {
        parent::__construct("tournament", $userID);
        $this->userID = $userID;
    }

    public function getAllTournaments() {
        return $this->query("SELECT t.tournamentID, t.tournamentName, t.tournamentDate, t.tournamentLocation, t.tournamentStatus, t.appUserID, GROUP_CONCAT(tc.category SEPARATOR ', ') AS categories 
        from tournament t 
        join tournamentCategory tc on t.tournamentID = tc.tournamentID
        group by t.tournamentID having t.appUserID = :appUserID;", ["appUserID" => $this->userID]);
    }

    public function getTournaments($offset, $limit, $order) {
        list($order_column, $order_direction) = parent::parseOrder($order);

        return $this->query("SELECT t.tournamentID, t.tournamentName, t.tournamentDate, t.tournamentLocation, t.tournamentStatus, t.appUserID, GROUP_CONCAT(tc.category SEPARATOR ', ') AS categories 
        from tournament t 
        join tournamentCategory tc on t.tournamentID = tc.tournamentID
        group by t.tournamentID having t.appUserID = :appUserID ORDER BY {$order_column} {$order_direction}
                           LIMIT {$limit} OFFSET {$offset};", ["appUserID" => $this->userID]);
    }

    public function getTournamentByID($id) {
        return $this->queryUnique("SELECT t.tournamentID, t.tournamentName, t.tournamentDate, t.tournamentLocation, t.tournamentStatus, t.appUserID, GROUP_CONCAT(tc.category SEPARATOR ', ') AS categories 
        from tournament t 
        join tournamentCategory tc on t.tournamentID = tc.tournamentID
        group by t.tournamentID having t.tournamentID = :tournamentID and t.appUserID = :appUserID;", ["tournamentID" => $id, "appUserID" => $this->userID]);
    }

    public function addTournament($tournament) {
        return $this->add($tournament);
    }

    public function updateTournament($id, $tournament) {
        return $this->update($id, $tournament, "tournamentID");
    }

    public function deleteTournament($id) {
        return $this->delete($id, "tournamentID");
    }

    public function markTournamentAsCompleted($id) {
        return $this->query("UPDATE tournament SET tournamentStatus = 'COMPLETED' WHERE tournamentID = :tournamentID and appUserID = :appUserID", ["tournamentID" => $id, "appUserID" => $this->userID]);
    }
}

?>