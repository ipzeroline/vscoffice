<?php

class cCompile
{

    function __construct($db)
    {
        $this->db = $db;
    }

    function Del()
    {
        $this->db->delete(DB_PREFIX . 'menu', array('menu_id' => $_GET['id']));
        redirect('index.php');
    }

    function json_edit()
    {
        $r = $this->db->record(DB_PREFIX . 'menu', "menu_id='" . $_POST['id'] . "'");
        $r = $this->db->object2array($r);
        $my_json = $this->db->js_thai_encode($r);
        echo json_encode($my_json);
        exit();
    }

    function add_edit()
    {
        if (empty($_POST['menu'])) {
            alert('กรุณาใส่ชื่อกลุ่มเมนู');
            exit();
        }

        $data['menu_name'] = $_POST['menu'];
        $data['ref_menu_id'] = $_POST['menu'];
        $data['menu_sort'] = $_POST['sort'];
        $data['menu_active'] = "Y";
        if (empty($_POST['id'])) {

            $data['menu_sort'] = $this->db->CreateID('slip_menu', 'menu_sort');
            $this->db->insert(DB_PREFIX . 'menu', $data);
        } else {
            $id['menu_id'] = $_POST['id'];
            $this->db->update(DB_PREFIX . 'menu', $data, $id);
        }
        redirect('index.php');
    }

    function add_menu_sub()
    {
        $err = array();
        if (empty($_POST['menu_sub'])) {
            $err[] = 'กรุณาใส่ชื่อเมนู';
        }
        if (empty($_POST['component_sub'])) {
            $err[] = 'กรุณาใส่ Component';
        }
        if (empty($_POST['sort_sub'])) {
            $err[] = 'กรุณากรอกลำดับ';
        }
        if (empty($_POST['link_sub'])) {
            $err[] = 'กรุณากรอกลิงค์';
        }

        if (count($err) > 0) {
            alert($err);
            exit();
        }

        $data['menu_name'] = $_POST['menu_sub'];
        $data['menu_component'] = $_POST['component_sub'];
        $data['menu_sort'] = $_POST['sort_sub'];
        $data['menu_link'] = $_POST['link_sub'];
        $data['menu_active'] = "Y";
        $data['ref_menu_id'] = $_POST['ref_sub'];
        $data['menu_icon'] = $_POST['icon'];

        if (empty($_POST['id_sub'])) {
            $this->db->insert(DB_PREFIX . 'menu', $data);
        } else {
            $this->db->update(DB_PREFIX . 'menu', $data, "menu_id='" . $_POST['id_sub'] . "'");
        }
        redirect('index.php');
    }
}


?>