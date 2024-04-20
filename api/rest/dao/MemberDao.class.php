<?php

require_once __DIR__.'/BaseDao.class.php';

class MemberDao extends BaseDao {
    private $userID;

    public function __construct($userID = NULL) {
        parent::__construct("clubMember", $userID);
        $this->userID = $userID;
    }

    public function getAllMembers() {
        return $this->get_all();
    }

    public function getMembers($offset, $limit, $order) {
        return $this->get($offset, $limit, $order);
    }

    public function getMemberByID($id) {
        return $this->get_by_id($id, "clubMemberID");
    }

    public function addMember($member) {
        return $this->add($member);
    }

    public function updateMember($id, $member) {
        return $this->update($id, $member, "clubMemberID");
    }

    public function deleteMember($id) {
        return $this->delete($id, "clubMemberID");
    }

    public function markMembershipAsPaid($id) {
        return $this->query("UPDATE clubMember SET membershipStatus = 'PAID' WHERE clubMemberID = :clubMemberID AND appUserID = :appUserID", ["appUserID" => $this->userID, "clubMemberID" => $id]);
    }

    public function setAllUnpaid() {
        return $this->query("UPDATE clubMember SET membershipStatus = 'UNPAID' WHERE appUserID = :appUserID", ["appUserID" => $this->userID]);
    }
}

?>