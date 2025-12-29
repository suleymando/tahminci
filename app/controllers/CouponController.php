<?php
class CouponController extends Controller {
    public function show($id) {
        $couponModel = $this->model('Coupon');
        $coupon = $couponModel->get($id);

        if (!$coupon) {
            // Simple 404
            echo "Kupon bulunamadı.";
            return;
        }

        $matches = $couponModel->getMatches($id);
        $coupon['matches'] = $matches;

        $this->view('home/detail', ['coupon' => $coupon]);
    }
}
