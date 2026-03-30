<?php

class cCompile
{

    function __construct($db)
    {
        $this->db = $db;
    }

    function Del()
    {
        $this->db->delete(DB_PREFIX . 'jobs', array('jobs_id' => $_GET['id']));
        redirect('index.php');
    }

    function json_edit()
    {
        $r = $this->db->record(DB_PREFIX . 'jobs', "jobs_id='" . $_POST['id'] . "'");
        $r = $this->db->object2array($r);
        $my_json = $this->db->js_thai_encode($r);

//$r=var_dump($my_json);
        echo json_encode($my_json);
        exit();
    }

    public function Admin()
    {
        $err = array();
        if (!required($_POST['jobs_name'])) $err[] = 'กรุณาระบุตำแหน่งค่ะ';
        if (count($err) > 0) {
            alert($err);
            return exit;
        }

        $data = array(
            'jobs_name' => $_POST['jobs_name'],
        );
        if (empty($_POST['jobs_id'])) {
            $this->db->insert(DB_PREFIX . 'jobs', $data);
            alert('Insert to complete!');
        } else {
            $this->db->update(DB_PREFIX . 'jobs', $data, array('jobs_id' => $_POST['jobs_id']));
            alert('Update to complete!');
        }

        redirect('../jobs');
    }
}


?>