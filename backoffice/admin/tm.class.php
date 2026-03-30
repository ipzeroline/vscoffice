<?php

class cCompile
{

    function __construct($db)
    {
        $this->db = $db;
    }

    function Del()
    {
        $this->db->delete(DB_PREFIX . 'user_admin', array('admin_id' => $_GET['id']));
        redirect('index.php');
    }

    function json_edit()
    {
        $r = $this->db->record(DB_PREFIX . 'user_admin', "admin_id='" . $_POST['id'] . "'");
        $r = $this->db->object2array($r);
        $my_json = $this->db->js_thai_encode($r);

//$r=var_dump($my_json);
        echo json_encode($my_json);
        exit();
    }

    public function Admin()
    {
        $err = array();
        $row = $this->db->record(DB_PREFIX . 'user_admin', array('admin_username' => $_POST['user']));
        if ($row !== FALSE && empty($_POST['admin_id'])) $err[] = 'ชื่อผู้ใช้ ' . $_POST['user'] . ' นี้มีผู้ใช้แล้วค่ะ';
        if (!required($_POST['user'])) $err[] = 'กรุณาระบุชื่อผู้ใช้ค่ะ';
        if (!required($_POST['name'])) $err[] = 'กรุณาระบุชื่อ';
        if (!required($_POST['lname'])) $err[] = 'กรุณาระบุนามสกุลค่ะ';
        if (!validEmail($_POST['mail'])) $err[] = 'กรุณาระบุอีเมล์ให้ถูกต้องค่ะ';
        if (count($err) > 0) {
            alert($err);
            return exit;
        }

        $data = array(
            'admin_username' => $_POST['user'],
            'admin_name' => $_POST['name'],
            'admin_surname' => $_POST['lname'],
            'admin_email' => $_POST['mail'],
            'admin_tel' => $_POST['tel'],
            'admin_username' => $_POST['user'],
            'admin_admin_update' => $_SESSION['LOGIN']['ID'],
            'admin_date_update' => CURRENT_TIME
        );
        if (!empty($_POST['pass']) && !empty($_POST['user'])) {
            $data['admin_pass'] = substr(sha1($_POST['user'] . $_POST['pass']), 0, 30);
        }
        //if(!empty($_POST['admin_id']))	unset($_POST['user']);


        if (empty($_POST['admin_id'])) {
            $this->db->insert(DB_PREFIX . 'user_admin', $data);
            alert('Insert to complete!');
        } else {
            $this->db->update(DB_PREFIX . 'user_admin', $data, array('admin_id' => $_POST['admin_id']));
            alert('Update to complete!');
        }

        redirect('../admin');
    }
}


?>