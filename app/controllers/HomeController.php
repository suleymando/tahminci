<?php
class HomeController extends Controller {
    public function index() {
        $couponModel = $this->model('Coupon');

        $filter = isset($_GET['filter']) ? $_GET['filter'] : null;
        if($filter == 'all') $filter = null;

        $coupons = $couponModel->getAll($filter);

        // Fetch matches for each coupon to display on card
        foreach ($coupons as &$coupon) {
            $coupon['matches'] = $couponModel->getMatches($coupon['id']);
        }

        $this->view('home/index', ['coupons' => $coupons]);
    }
}
