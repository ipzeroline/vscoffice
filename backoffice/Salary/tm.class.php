<?php

class cCompile
{

    function __construct($db)
    {
        $this->db = $db;
    }

    function json_autocom()
    {
        $r = $this->db->result(DB_PREFIX . 'employee', NULL, NULL, NULL, "emp_name as lable");
        /*$r=$this->db->object2array($r);
        $my_json = $this->db->js_thai_encode($r);
        echo json_encode($my_json);*/
        $str = '[';
        $i = 1;
        foreach ($r as $key => $rr) {
            if ($i != 1) {
                $str = $str . '",';
            }
            $str = $str . '"';
            $str = $str . $rr->lable;
            $i++;
        }
        $str = $str . '"]';
        echo $str;
        exit();
    }

    function json_edit_emp()
    {
        $r = $this->db->record(DB_PREFIX . 'salary', "salary_id='" . $_POST['id'] . "'");
        $r = $this->db->object2array($r);
        $my_json = $this->db->js_thai_encode($r);
        echo json_encode($my_json);
        exit();
    }

    function Add_salary()
    {
        if (!required($_POST['list'])) {
            $er = 1;
        }
        if (!required($_POST['date'])) {
            $er = 1;
        }
        if (!required($_POST['sale-name'])) {
            $er = 1;
        }
        if (!required($_POST['money'])) {
            $er = 1;
        }
        if (!required($_POST['money_hour'])) {
            $er = 1;
        }
        if (!required($_POST['ot_hour'])) {
            $er = 1;
        }
        if (!required($_POST['ot'])) {
            $er = 1;
        }
        if (!required($_POST['ot_day'])) {
            $er = 1;
        }
        if (!required($_POST['otd'])) {
            $er = 1;
        }
        if (!required($_POST['ots'])) {
            $er = 1;
        }
        if (!required($_POST['works'])) {
            $er = 1;
        }
        if (!required($_POST['coms'])) {
            $er = 1;
        }
        if (!required($_POST['sums'])) {
            $er = 1;
        }
        if (!required($_POST['dis'])) {
            $er = 1;
        }
        if (!required($_POST['diss'])) {
            $er = 1;
        }
        if (!required($_POST['disn'])) {
            $er = 1;
        }
        if (!required($_POST['disnn'])) {
            $er = 1;
        }
        if (!required($_POST['kuu'])) {
            $er = 1;
        }
        if (!required($_POST['artt'])) {
            $er = 1;
        }
        if (!required($_POST['sumdd'])) {
            $er = 1;
        }
        if (!required($_POST['yodd'])) {
            $er = 1;
        }
        if ($er == 1) {
            alert_dialog('กรุณากรอกข้อมูลให้ครบถ้วน ', 'alert_dialog2');
            exit();
        }

        $data['emp_id'] = $_POST['emp_id'];
        $data['salary_date'] = $_POST['date'];
        $data['salary_mont'] = thai_date($_POST['date']);
        $data['salary_name'] = $_POST['sale-name'];
        $data['salary_salary'] = $_POST['money'];
        $data['salary_list'] = $_POST['list'];
        $data['salary_money_hour'] = $_POST['money_hour'];
        $data['salary_ot_hour'] = $_POST['ot_hour'];
        $data['salary_ot'] = $_POST['ot'];
        $data['salary_ot_day'] = $_POST['ot_day'];
        $data['salary_otd'] = $_POST['otd'];
        $data['salary_ots'] = $_POST['ots'];
        $data['salary_works'] = $_POST['works'];
        $data['salary_coms'] = $_POST['coms'];
        $data['salary_sums'] = $_POST['sums'];
        $data['salary_dis'] = $_POST['dis'];
        $data['salary_diss'] = $_POST['diss'];
        // $data['salary_disn'] = $_POST['disn'];
        $data['salary_disnn'] = $_POST['disnn'];
        $data['salary_kuu'] = $_POST['kuu'];
        $data['salary_artt'] = $_POST['artt'];
        $data['salary_sumdd'] = $_POST['sumdd'];
        $data['salary_yodd'] = $_POST['yodd'];
        $this->db->update('slip_salary', $data, "salary_id='" . $_POST['salary_id'] . "'");
        alert("บันทึกข้อมูลเรียบร้อย");
        redirect($_SERVER['HTTP_REFERER']);
    }

    function Del()
    {
        $this->db->delete(DB_PREFIX . 'salary', array('salary_id' => $_GET['id']));
        redirect('index.php');
    }

    /*function Sorting(){

        parse_str($_POST['listItem'], $pageOrder);

        foreach ($pageOrder['listItem'] as $IDkey => $IDvalue) {
            echo $IDkey.' : '.$IDvalue.'<br/>';
            $sortID = $IDkey+1;
            $this->db->update(DB_PREFIX.'slide',"slide_sort = '$sortID'","slide_id = '$IDvalue'");
        }

    }*/

}


?>