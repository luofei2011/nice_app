<?php
Class Nice extends Controller {
    public $uid = null;
    public $isLogin = false;
    public $username = null;
    public $post_data = null;

    
    public function __construct() {
        $this->post_data = isset($_POST['data']) ? $_POST['data'] : '';
        $this->get_data = isset($_GET['data']) ? $_GET['data'] : '';
        $this->main = $this->load_model('main');

        if (Session::get('token')) {
            $this->isLogin = true;
        }
        $this->username = Session::get('username');
        $result = $this->main->get_user_id($this->username);
        if ($result)
            $this->uid = $result['id'];
    }

    public function index() {
        $data = array();
        $data['userInfo'] = array(
            'isLogin' => $this->isLogin,
            'username' => $this->username
        );
        $this->load_view('index', $data);
    }

    public function user_center() {
        $data = array();
        $data['userInfo']['isLogin'] = $this->isLogin;

        if ($this->isLogin) {
            $info = $this->main->get_user_info($this->username);
            $data['userInfo'] = array(
                'isLogin' => $this->isLogin,
                'username' => $this->username,
                'email' => $info['email'],
                'phone' => $info['phone'],
                'sex' => '',
            );
        }

        $this->load_view('user_center', $data);
    }

    public function user_login() {
        $this->load_view('login');
    }

    public function addItem() {
        echo json_encode($this->main->insert_into_item($this->post_data, $this->uid));
    }

    public function query_run() {
        echo json_encode($this->main->query_run_new($this->post_data, $this->uid));
    }

    public function get_items_by_name() {
        if ($this->uid) {
            echo json_encode($this->main->get_items_by_name($this->username, $this->uid));
        } else {
            echo json_encode(array());
        }
    }

    public function save_run() {
        $result = $this->main->save_run($this->post_data, $this->uid);
        echo "success";
    }

    public function remove_line() {
        $result = $this->main->remove_line($this->post_data);
        echo "success";
    }

    public function edit_item() {
        $result = $this->main->update_item($this->post_data, $this->uid);
        echo "success";
    }

    public function login() {
        $uInfo = (array)json_decode($this->post_data);
        $username = strip_tags($uInfo['username']);
        $password = md5($uInfo['password']);

        $result = NULL;
        if ($username && $password) {
            $result = $this->main->is_user_exist($username, $password);
        }

        if ($result) {
            Session::set('username', $username);
            Session::set('token', md5($username . "poised-flw.com"));
            echo "success";
        } else {
            echo "fail";
        }
    }

    public function register() {
        $uInfo = (array)json_decode($this->post_data);
        $username = strip_tags($uInfo['username']);
        $password = md5($uInfo['password']);

        $result = NULL;
        if ($username && $password) {
            $result = $this->main->check_exist($username);
        }

        if (!$result) {
            $this->main->insert_into_user($username, $password);
        } else {
            $result = $this->main->is_user_exist($username, $password);

            if (!$result) {
                echo "fail";
                return false;
            }
        }

        Session::set('username', $username);
        Session::set('token', md5($username . "poised-flw.com"));
        echo "success";
    }

    public function logout() {
        Session::destory();
        header('location: ' . BASE_URL);
    }
}
