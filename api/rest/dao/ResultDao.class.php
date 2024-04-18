<?php

require_once __DIR__.'/BaseDao.class.php';

class ResultDao extends BaseDao {

    public function __construct() {
        parent::__construct("result");
    }

    public function getAllresults() {
        return $this->get_all();
    }

    public function getresults($offset, $limit, $order) {
        return $this->get($offset, $limit, $order);
    }

    public function getresultByID($id) {
        return $this->get_by_id($id, "resultID");
    }

    public function addresult($result) {
        $this->add($result);
    }

    public function updateresult($id, $result) {
        $this->update($id, $result, "resultID");
    }

    public function deleteresult($id) {
        $this->delete($id, "resultID");
    }

    public function getResultsByTournamentID($tournamentID) {
        return $this->query("SELECT * FROM result WHERE tournamentID = :tournamentID", ["tournamentID" => $tournamentID]);
    }

    public function getResultsByClubMemberID($clubMemberID) {
        return $this->query("SELECT * FROM result WHERE clubMemberID = :clubMemberID", ["clubMemberID" => $clubMemberID]);
    }

    public function deleteResultsForTournament($tournamentID) {
        $this->query("DELETE FROM result WHERE tournamentID = :tournamentID", ["tournamentID" => $tournamentID]);
    }

    public function deleteResultsForMember($clubMemberID) {
        $this->query("DELETE FROM result WHERE clubMemberID = :clubMemberID", ["clubMemberID" => $clubMemberID]);
    }
}

?>