<?php

require_once __DIR__.'/BaseDao.class.php';

class TournamentCategoryDao extends BaseDao {

    public function __construct() {
        parent::__construct("tournamentCategory");
    }

    public function getAllTournamentCategories() {
        return $this->get_all();
    }

    public function getTournamentCategories($offset, $limit, $order) {
        return $this->get($offset, $limit, $order);
    }

    public function getTournamentCategoryByID($id) {
        return $this->get_by_id($id, "tournamentCategoryID");
    }

    public function addTournamentCategory($tournamentCategory) {
        return $this->add($tournamentCategory);
    }

    public function updateTournamentCategory($id, $tournamentCategory) {
        return $this->update($id, $tournamentCategory, "tournamentCategoryID");
    }

    public function deleteTournamentCategory($id) {
        return $this->delete($id, "tournamentCategoryID");
    }

    public function deleteTournamentCategoriesForTournament($tournamentID) {
        return $this->query("DELETE FROM tournamentCategory WHERE tournamentID = :tournamentID", ["tournamentID" => $tournamentID]);
    }

}

?>