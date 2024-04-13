<?php

require_once __DIR__.'/BaseDao.class.php';

class MemberDao extends BaseDao {

    public function __construct() {
        parent::__construct("clubMember");
    }

    public function get_members($offset, $limit, $order) {
        list($order_column, $order_direction) = parent::parse_order($order);

        return $this->query("SELECT * FROM clubMember
                             ORDER BY $order_column $order_direction
                             LIMIT $limit OFFSET $offset", []);
    }

    public function get_member_by_id($id) {
        return $this->query_unique("SELECT * FROM clubMember WHERE clubMemberID = :clubMemberID", ["clubMemberID" => $id]);
    }

    public function add_member($member) {
        $this->insert("members", $member);
    }

    public function update_member($id, $member) {
        $this->update("members", $id, $member);
    }

    public function delete_member($id) {
        $this->query("DELETE FROM clubMember WHERE clubMemberID = :clubMemberID", ["clubMemberID" => $id]);
    }

}

?>