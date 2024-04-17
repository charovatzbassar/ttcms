<?php
require_once __DIR__.'/../dao/TournamentCategoryDao.class.php';

class TournamentCategoryService {
    private $tournamentCategoryDao;

    public function __construct($tournamentCategoryDao) {
        $this->tournamentCategoryDao = $tournamentCategoryDao;
    }

    public function getAllTournamentCategories() {
        return $this->tournamentCategoryDao->getAllTournamentCategories();
    }

    public function getTournamentCategories($offset, $limit, $order) {
        return $this->tournamentCategoryDao->getTournamentCategories($offset, $limit, $order);
    }

    public function getTournamentCategoryByID($id) {
        return $this->tournamentCategoryDao->getTournamentCategoryByID($id);
    }

    public function addTournamentCategory($tournamentCategory) {
        return $this->tournamentCategoryDao->addTournamentCategory($tournamentCategory);
    }

    public function updateTournamentCategory($id, $tournamentCategory) {
        return $this->tournamentCategoryDao->updateTournamentCategory($id, $tournamentCategory);
    }

    public function deleteTournamentCategory($id) {
        return $this->tournamentCategoryDao->deleteTournamentCategory($id);
    }


}

?>