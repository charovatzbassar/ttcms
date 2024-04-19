<?php

require_once __DIR__.'/BaseDao.class.php';

class ResultDao extends BaseDao {

    public function __construct() {
        parent::__construct("result");
    }

    public function getAllresults() {
        return $this->query("SELECT r.resultID, r.clubMemberID, m.firstName, m.lastName, r.opponentFirstName, r.opponentLastName, r.resultStatus, r.appUserID, r.tournamentID
        from `result` r join clubMember m on r.clubMemberID = m.clubMemberID;", []);
    }

    public function getresults($offset, $limit, $order) {
        list($order_column, $order_direction) = self::parseOrder($order);

        return $this->query("SELECT r.resultID, r.clubMemberID, m.firstName, m.lastName, r.opponentFirstName, r.opponentLastName, r.resultStatus, r.appUserID, r.tournamentID
        from `result` r join clubMember m on r.clubMemberID = m.clubMemberID ORDER BY {$order_column} {$order_direction}
                           LIMIT {$limit} OFFSET {$offset} ;", []);
    }

    public function getresultByID($id) {
        return $this->query("SELECT r.resultID, r.clubMemberID, m.firstName, m.lastName, r.opponentFirstName, r.opponentLastName, r.resultStatus, r.appUserID, r.tournamentID
        from `result` r join clubMember m on r.clubMemberID = m.clubMemberID having r.resultID = :resultID;", ["resultID" => $id]);
    }

    public function addresult($result) {
        return $this->add($result);
    }

    public function updateresult($id, $result) {
        return $this->update($id, $result, "resultID");
    }

    public function deleteresult($id) {
        return $this->delete($id, "resultID");
    }

    public function getResultsByTournamentID($tournamentID) {
        return $this->query("SELECT r.resultID, r.clubMemberID, m.firstName, m.lastName, r.opponentFirstName, r.opponentLastName, r.resultStatus, r.appUserID, r.tournamentID
        from `result` r join clubMember m on r.clubMemberID = m.clubMemberID having r.tournamentID = :tournamentID;", ["tournamentID" => $tournamentID]);
    }

    public function getResultsByClubMemberID($clubMemberID) {
        return $this->query("SELECT r.resultID, r.clubMemberID, m.firstName, m.lastName, r.opponentFirstName, r.opponentLastName, r.resultStatus, r.appUserID, r.tournamentID
        from `result` r join clubMember m on r.clubMemberID = m.clubMemberID having r.clubMemberID = :clubMemberID;", ["clubMemberID" => $clubMemberID]);    
    }

    public function deleteResultsForTournament($tournamentID) {
        return $this->query("DELETE FROM result WHERE tournamentID = :tournamentID", ["tournamentID" => $tournamentID]);
    }

    public function deleteResultsForMember($clubMemberID) {
        return $this->query("DELETE FROM result WHERE clubMemberID = :clubMemberID", ["clubMemberID" => $clubMemberID]);
    }
}

?>