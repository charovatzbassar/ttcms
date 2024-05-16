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

    public function getMembers($page, $offset, $limit, $search, $order_column, $order_direction) {
        $query = "";

        switch ($page) {
            case 'dashboard':
                $query = "SELECT CONCAT(firstName, ' ', lastName) as name, membershipStatus
                from clubMember where appUserID = :appUserID AND (LOWER(CONCAT(firstName, ' ', lastName)) LIKE CONCAT('%', :search, '%') OR LOWER(membershipStatus) LIKE CONCAT('%', :search, '%')) 
                ORDER BY {$order_column} {$order_direction} LIMIT {$offset}, {$limit}";
                break;
            case 'stats':
                $query = "SELECT CONCAT(firstName, ' ', lastName) as name, category, score
                from clubMember where appUserID = :appUserID AND (LOWER(CONCAT(firstName, ' ', lastName)) LIKE CONCAT('%', :search, '%') OR LOWER(category) LIKE CONCAT('%', :search, '%')) OR score = :search 
                ORDER BY {$order_column} {$order_direction} LIMIT {$offset}, {$limit}";
                break;
            case 'members':
                $query = "SELECT CONCAT(firstName, ' ', lastName) as name, dateOfBirth, gender, birthplace, category, membershipStatus, clubMemberID
                from clubMember where appUserID = :appUserID AND (LOWER(CONCAT(firstName, ' ', lastName)) LIKE CONCAT('%', :search, '%') 
                OR LOWER(membershipStatus) LIKE CONCAT('%', :search, '%') OR LOWER(category) LIKE CONCAT('%', :search, '%') 
                OR LOWER(birthplace) LIKE CONCAT('%', :search, '%') OR LOWER(gender) LIKE CONCAT('%', :search, '%') OR dateOfBirth LIKE CONCAT('%', :search, '%'))  
                ORDER BY {$order_column} {$order_direction} LIMIT {$offset}, {$limit}";
                break;
        }
        
        return $this->query($query, ["appUserID" => $this->userID, "search" => strtolower($search)]);


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