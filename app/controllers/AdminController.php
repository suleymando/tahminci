<?php
class AdminController extends Controller {
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index() {
        if (!isset($_SESSION['admin_logged_in'])) {
            header('Location: /admin/login');
            exit;
        }

        $couponModel = $this->model('Coupon');
        $stats = [
            'total' => $couponModel->countTotal(),
            'won' => $couponModel->countByStatus('won'),
            'lost' => $couponModel->countByStatus('lost'),
            'pending' => $couponModel->countByStatus('pending'),
        ];

        $this->view('admin/dashboard', ['stats' => $stats]);
    }

    public function login() {
        if (isset($_SESSION['admin_logged_in'])) {
            header('Location: /admin');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $userModel = $this->model('User');
            $user = $userModel->login($username, $password);

            if ($user) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['user_id'] = $user['id'];
                header('Location: /admin');
                exit;
            } else {
                $error = "Hatalı kullanıcı adı veya şifre.";
                $this->view('admin/login', ['error' => $error]);
                return;
            }
        }

        $this->view('admin/login');
    }

    public function logout() {
        session_destroy();
        header('Location: /admin/login');
    }

    public function coupons() {
        if (!isset($_SESSION['admin_logged_in'])) { header('Location: /admin/login'); exit; }

        $couponModel = $this->model('Coupon');
        $coupons = $couponModel->getAll();

        $this->view('admin/coupons', ['coupons' => $coupons]);
    }

    public function add_coupon() {
        if (!isset($_SESSION['admin_logged_in'])) { header('Location: /admin/login'); exit; }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $couponModel = $this->model('Coupon');
            $couponData = [
                'title' => $_POST['title'],
                'type' => $_POST['type'],
                'total_odds' => $_POST['total_odds'],
                'status' => 'pending'
            ];

            $couponId = $couponModel->add($couponData);

            if ($couponId && isset($_POST['matches'])) {
                foreach ($_POST['matches'] as $match) {
                    $match['coupon_id'] = $couponId;
                    $couponModel->addMatch($match);
                }
            }
            header('Location: /admin/coupons');
            exit;
        }

        $this->view('admin/add_coupon');
    }

    public function update_status($id, $status) {
        if (!isset($_SESSION['admin_logged_in'])) { header('Location: /admin/login'); exit; }

        $couponModel = $this->model('Coupon');
        $couponModel->updateStatus($id, $status);
        header('Location: /admin/coupons');
    }

    public function delete_coupon($id) {
        if (!isset($_SESSION['admin_logged_in'])) { header('Location: /admin/login'); exit; }

        $couponModel = $this->model('Coupon');
        $couponModel->delete($id);
        header('Location: /admin/coupons');
    }
}
