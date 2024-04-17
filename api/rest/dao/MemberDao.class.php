<?php

require_once __DIR__.'/BaseDao.class.php';

class MemberDao extends BaseDao {

    public function __construct() {
        parent::__construct("clubMember");
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
        $this->add($member);
    }

    public function updateMember($id, $member) {
        $this->update($id, $member, "clubMemberID");
    }

    public function deleteMember($id) {
        $this->delete($id, "clubMemberID");
    }

    public function markMembershipAsPaid($id) {
        $this->query("UPDATE clubMember SET membershipStatus = 'PAID' WHERE clubMemberID = :clubMemberID", ["clubMemberID" => $id]);
    }

    public function setAllUnpaid() {
        $this->query("UPDATE clubMember SET membershipStatus = 'UNPAID'", []);
    }
}

?>