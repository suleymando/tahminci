<?php
class Coupon {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAll($filter = null) {
        if ($filter) {
            $stmt = $this->db->query("SELECT * FROM coupons WHERE type LIKE ? ORDER BY created_at DESC", ["%{$filter}%"]);
        } else {
            $stmt = $this->db->query("SELECT * FROM coupons ORDER BY created_at DESC");
        }
        return $stmt->fetchAll();
    }

    public function get($id) {
        $stmt = $this->db->query("SELECT * FROM coupons WHERE id = :id", ['id' => $id]);
        return $stmt->fetch();
    }

    public function getMatches($couponId) {
        $stmt = $this->db->query("SELECT * FROM matches WHERE coupon_id = :id", ['id' => $couponId]);
        return $stmt->fetchAll();
    }

    public function add($data) {
        $this->db->query("INSERT INTO coupons (title, type, total_odds, status) VALUES (:title, :type, :total_odds, :status)", [
            'title' => $data['title'],
            'type' => $data['type'],
            'total_odds' => $data['total_odds'],
            'status' => $data['status']
        ]);
        return $this->db->lastInsertId();
    }

    public function addMatch($data) {
        $this->db->query("INSERT INTO matches (coupon_id, home_team, away_team, match_time, league, prediction, odds) VALUES (:cid, :home, :away, :time, :league, :pred, :odds)", [
            'cid' => $data['coupon_id'],
            'home' => $data['home'],
            'away' => $data['away'],
            'time' => $data['time'],
            'league' => 'General', // Default for now
            'pred' => $data['prediction'],
            'odds' => $data['odds']
        ]);
    }

    public function updateStatus($id, $status) {
        $this->db->query("UPDATE coupons SET status = :status WHERE id = :id", ['status' => $status, 'id' => $id]);
    }

    public function delete($id) {
        $this->db->query("DELETE FROM coupons WHERE id = :id", ['id' => $id]);
    }

    public function countTotal() {
        return $this->db->query("SELECT COUNT(*) as c FROM coupons")->fetch()['c'];
    }

    public function countByStatus($status) {
        return $this->db->query("SELECT COUNT(*) as c FROM coupons WHERE status = :status", ['status' => $status])->fetch()['c'];
    }
}
