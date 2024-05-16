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

    public function getTournaments($page, $offset, $limit, $search, $order_column, $order_direction) {
        return $this->query("SELECT 
        t.tournamentID,
        t.tournamentName, 
        t.tournamentDate, 
        t.tournamentLocation, 
        t.tournamentStatus, 
        GROUP_CONCAT(tc.category SEPARATOR ', ') AS categories 
    FROM 
        tournament t 
        JOIN tournamentCategory tc ON t.tournamentID = tc.tournamentID
    WHERE 
        t.appUserID = :appUserID
    GROUP BY 
        t.tournamentID
    HAVING 
        LOWER(t.tournamentName) LIKE CONCAT('%', :search, '%')
        OR t.tournamentDate LIKE CONCAT('%', :search, '%')
        OR LOWER(t.tournamentLocation) LIKE CONCAT('%', :search, '%')
        OR LOWER(t.tournamentStatus) LIKE CONCAT('%', :search, '%')
        OR LOWER(GROUP_CONCAT(tc.category SEPARATOR ', ')) LIKE CONCAT('%', :search, '%')
    ORDER BY 
        {$order_column} {$order_direction}
    LIMIT 
        {$offset}, {$limit};", ["appUserID" => $this->userID, "search" => strtolower($search)]);
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