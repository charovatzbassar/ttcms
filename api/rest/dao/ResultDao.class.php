<?php

require_once __DIR__.'/BaseDao.class.php';

class ResultDao extends BaseDao {
    private $userID;

    public function __construct($userID = NULL) {
        parent::__construct("result", $userID);
        $this->userID = $userID;
    }

    public function getAllResults() {
        return $this->query("SELECT r.resultID, r.clubMemberID, m.firstName, m.lastName, r.opponentFirstName, r.opponentLastName, r.resultStatus, r.appUserID, r.tournamentID
        from `result` r join clubMember m on r.clubMemberID = m.clubMemberID where r.appUserID = :appUserID;", ["appUserID" => $this->userID]);
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

    public function getAllResultsByTournamentID($tournamentID) {
        return $this->query("SELECT r.resultID, r.clubMemberID, m.firstName, m.lastName, r.opponentFirstName, r.opponentLastName, r.resultStatus, r.appUserID, r.tournamentID
        from `result` r join clubMember m on r.clubMemberID = m.clubMemberID having r.tournamentID = :tournamentID and r.appUserID = :appUserID;", ["tournamentID" => $tournamentID, "appUserID" => $this->userID]);
    }

    public function getAllResultsByClubMemberID($clubMemberID) {
        return $this->query("SELECT r.resultID, r.clubMemberID, m.firstName, m.lastName, r.opponentFirstName, r.opponentLastName, r.resultStatus, r.appUserID, r.tournamentID
        from `result` r join clubMember m on r.clubMemberID = m.clubMemberID having r.clubMemberID = :clubMemberID and r.appUserID = :appUserID;", ["clubMemberID" => $clubMemberID, "appUserID" => $this->userID]);    
    }

    public function getResultsByTournamentID($tournamentID, $offset, $limit, $search, $order_column, $order_direction) {
        return $this->query("SELECT r.resultID, r.clubMemberID, CONCAT(m.firstName, ' ', m.lastName) as memberName, 
        CONCAT(r.opponentFirstName, ' ', r.opponentLastName) as opponentName, r.resultStatus, r.appUserID
        from result r 
        join clubMember m on r.clubMemberID = m.clubMemberID 
        where r.tournamentID = :tournamentID AND r.appUserID = :appUserID 
        AND (LOWER(CONCAT(m.firstName, ' ', m.lastName)) LIKE CONCAT('%', :search, '%') 
        OR LOWER(CONCAT(r.opponentFirstName, ' ', r.opponentLastName)) LIKE CONCAT('%', :search, '%')
        OR LOWER(r.resultStatus) LIKE CONCAT('%', :search, '%'))
                        ORDER BY {$order_column} {$order_direction} LIMIT {$offset}, {$limit};", ["tournamentID" => $tournamentID, "appUserID" => $this->userID, "search" => strtolower($search)]);
    }

    public function getResultsByClubMemberID($clubMemberID, $offset, $limit, $search, $order_column, $order_direction) {
        return $this->query("SELECT r.resultID, r.clubMemberID,  
        CONCAT(r.opponentFirstName, ' ', r.opponentLastName) as opponentName, r.resultStatus, r.appUserID
        from result r 
        join clubMember m on r.clubMemberID = m.clubMemberID 
        where r.clubMemberID = :clubMemberID AND r.appUserID = :appUserID 
        AND ( 
         LOWER(CONCAT(r.opponentFirstName, ' ', r.opponentLastName)) LIKE CONCAT('%', :search, '%')
        OR LOWER(r.resultStatus) LIKE CONCAT('%', :search, '%'))
                        ORDER BY {$order_column} {$order_direction} LIMIT {$offset}, {$limit};", ["clubMemberID" => $clubMemberID, "appUserID" => $this->userID, "search" => strtolower($search)]);    
    }

    public function deleteResultsForTournament($tournamentID) {
        return $this->query("DELETE FROM result WHERE tournamentID = :tournamentID and appUserID = :appUserID", ["tournamentID" => $tournamentID, "appUserID" => $this->userID]);
    }

    public function deleteResultsForMember($clubMemberID) {
        return $this->query("DELETE FROM result WHERE clubMemberID = :clubMemberID and appUserID = :appUserID", ["clubMemberID" => $clubMemberID, "appUserID" => $this->userID]);
    }
}

?>