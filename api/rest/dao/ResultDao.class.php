<?php

require_once __DIR__.'/BaseDao.class.php';

class ResultDao extends BaseDao {
    private $userID;

    public function __construct($userID = NULL) {
        parent::__construct("result", $userID);
        $this->userID = $userID;
    }

    public function getAllresults() {
        return $this->query("SELECT r.resultID, r.clubMemberID, m.firstName, m.lastName, r.opponentFirstName, r.opponentLastName, r.resultStatus, r.appUserID, r.tournamentID
        from `result` r join clubMember m on r.clubMemberID = m.clubMemberID having r.appUserID = :appUserID;", ["appUserID" => $this->userID]);
    }

    public function getResults($offset, $limit, $order) {
        list($order_column, $order_direction) = self::parseOrder($order);

        return $this->query("SELECT r.resultID, r.clubMemberID, m.firstName, m.lastName, r.opponentFirstName, r.opponentLastName, r.resultStatus, r.appUserID, r.tournamentID
        from `result` r join clubMember m on r.clubMemberID = m.clubMemberID having appUserID = :appUserID ORDER BY {$order_column} {$order_direction}
                           LIMIT {$limit} OFFSET {$offset} ;", ["appUserID" => $this->userID]);
    }

    public function getResultByID($id) {
        return $this->query("SELECT r.resultID, r.clubMemberID, m.firstName, m.lastName, r.opponentFirstName, r.opponentLastName, r.resultStatus, r.appUserID, r.tournamentID
        from `result` r join clubMember m on r.clubMemberID = m.clubMemberID having r.resultID = :resultID and r.appUserID = :appUserID;", ["resultID" => $id, "appUserID" => $this->userID]);
    }

    public function addResult($result) { 
        return $this->add($result);
    }

    public function updateResult($id, $result) {
        return $this->update($id, $result, "resultID");
    }

    public function deleteResult($id) {
        return $this->delete($id, "resultID");
    }

    public function getResultsByTournamentID($tournamentID) {
        return $this->query("SELECT r.resultID, r.clubMemberID, m.firstName, m.lastName, r.opponentFirstName, r.opponentLastName, r.resultStatus, r.appUserID, r.tournamentID
        from `result` r join clubMember m on r.clubMemberID = m.clubMemberID having r.tournamentID = :tournamentID and r.appUserID = :appUserID;", ["tournamentID" => $tournamentID, "appUserID" => $this->userID]);
    }

    public function getResultsByClubMemberID($clubMemberID) {
        return $this->query("SELECT r.resultID, r.clubMemberID, m.firstName, m.lastName, r.opponentFirstName, r.opponentLastName, r.resultStatus, r.appUserID, r.tournamentID
        from `result` r join clubMember m on r.clubMemberID = m.clubMemberID having r.clubMemberID = :clubMemberID and r.appUserID = :appUserID;", ["clubMemberID" => $clubMemberID, "appUserID" => $this->userID]);    
    }

    public function deleteResultsForTournament($tournamentID) {
        return $this->query("DELETE FROM result WHERE tournamentID = :tournamentID and appUserID = :appUserID", ["tournamentID" => $tournamentID, "appUserID" => $this->userID]);
    }

    public function deleteResultsForMember($clubMemberID) {
        return $this->query("DELETE FROM result WHERE clubMemberID = :clubMemberID and appUserID = :appUserID", ["clubMemberID" => $clubMemberID, "appUserID" => $this->userID]);
    }
}

?>