<?php

require_once __DIR__.'/BaseDao.class.php';

class MemberDao extends BaseDao {

    public function __construct() {
        parent::__construct("clubMember");
    }

    public function getAllMembers() {
        return $this->query("SELECT * FROM clubMember", []);
    }

    public function getMembers($offset, $limit, $order) {
        list($order_column, $order_direction) = parent::parseOrder($order);

        return $this->query("SELECT * FROM clubMember
                             ORDER BY $order_column $order_direction
                             LIMIT $limit OFFSET $offset", []);
    }

    public function getMemberByID($id) {
        return $this->queryUnique("SELECT * FROM clubMember WHERE clubMemberID = :clubMemberID", ["clubMemberID" => $id]);
    }

    public function addMember($member) {
        $this->insert("clubMember", $member);
    }

    public function updateMember($id, $member) {
        $this->update($id, $member, "clubMemberID");
    }

    public function deleteMember($id) {
        $this->query("DELETE FROM clubMember WHERE clubMemberID = :clubMemberID", ["clubMemberID" => $id]);
    }

    public function markMembershipAsPaid($id) {
        $this->query("UPDATE clubMember SET membershipStatus = 'PAID' WHERE clubMemberID = :clubMemberID", ["clubMemberID" => $id]);
    }
}

?>