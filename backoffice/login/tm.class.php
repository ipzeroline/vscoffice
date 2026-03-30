<?php

class cCompile
{
    function __construct($db)
    {
        $this->db = $db;
    }

    public function Login()
    {
        $result = array('status' => 'FAIL');

        $where = array(
            'admin_username' => $_POST['username'],
            'admin_pass' => substr(sha1($_POST['username'] . $_POST['password']), 0, 30),
            //'admin_active'		=> 'Y'
        );

        $row = $this->db->record(DB_PREFIX . 'user_admin', $where);

        if ($row === FALSE) {
            $result['status'] = 'FAIL';
        } else {
            $result['status'] = 'COMPLETE';
            $this->db->update(DB_PREFIX . 'user_admin', array('admin_date_login' => time(), 'admin_ip_login' => user_ip()), array('admin_id' => $row->admin_id));
            $_SESSION['LOGIN']['ID'] = $row->admin_id;
            $_SESSION['LOGIN']['LAST'] = $row->admin_date_login;
            $_SESSION['LOGIN']['USER'] = $row->admin_username;
            $_SESSION['LOGIN']['ONLINE'] = time();
            $_SESSION['LOGIN']['MENU'] = $row->admin_menu;
            $_SESSION['LOGIN']['status'] = $row->admin_status;

        }

        echo json_encode($result);

    }
}

?>