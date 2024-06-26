<?php
require_once __DIR__.'/../dao/MemberDao.class.php';

class MemberService {
    private $memberDao;

    public function __construct($memberDao) {
        $this->memberDao = $memberDao;
    }

    public function getAllMembers() {
        return $this->memberDao->getAllMembers();
    }

    public function getMembers($page, $offset, $limit, $search, $order_column, $order_direction) {
        return $this->memberDao->getMembers($page, $offset, $limit, $search, $order_column, $order_direction);
    }

    public function getMemberByID($id) {
        return $this->memberDao->getMemberByID($id);
    }

    public function addMember($member) {
        return $this->memberDao->addMember($member);
    }

    public function updateMember($id, $member) {
        return $this->memberDao->updateMember($id, $member);
    }

    public function deleteMember($id) {
        return $this->memberDao->deleteMember($id);
    }

    public function markMembershipAsPaid($id) {
        return $this->memberDao->markMembershipAsPaid($id);
    }

    public function setAllUnpaid() {
        return $this->memberDao->setAllUnpaid();
    }

}

?>