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
        $tbll = DB_PREFIX . 'employee' . ' INNER JOIN ' . DB_PREFIX . 'jobs' . ' ON  slip_employee.emp_jobs = slip_jobs.jobs_id';
        $r = $this->db->record($tbll, "emp_id='" . $_POST['id'] . "'");
        $r = $this->db->object2array($r);
        $my_json = $this->db->js_thai_encode($r);
        echo json_encode($my_json);
        exit();
    }

    function Add_emp()
    {
        if (empty($_POST['po'])) {
            $er = 1;
        }
        if (empty($_POST['first'])) {
            $er = 1;
        }
        if (empty($_POST['name'])) {
            $er = 1;
        }
        if (empty($_POST['nickname'])) {
            $er = 1;
        }
        if (empty($_POST['account'])) {
            $er = 1;
        }
        if (empty($_POST['bank'])) {
            $er = 1;
        }
        if (empty($_POST['salary'])) {
            $er = 1;
        }
        if (empty($_POST['sso'])) {
            $er = 1;
        }
        if (empty($_POST['born'])) {
            $er = 1;
        }
        if (empty($_POST['start'])) {
            $er = 1;
        }
        if (empty($_POST['mail'])) {
            $er = 1;
        }
        if (empty($_POST['tel'])) {
            $er = 1;
        }
        if (empty($_POST['status'])) {
            $er = 1;
        }
        if ($er == 1) {
            alert_dialog('กรุณากรอกข้อมูลให้ครบถ้วน', 'alert_dialog');
            exit();
        }
        $data['emp_jobs'] = $_POST['po'];
        $data['emp_first'] = $_POST['first'];
        $data['emp_name'] = $_POST['name'];
        $data['emp_nickname'] = $_POST['nickname'];
        $data['emp_account'] = $_POST['account'];
        $data['emp_bank'] = $_POST['bank'];
        $data['emp_salary'] = $_POST['salary'];
        $data['emp_sso'] = $_POST['sso'];
        $data['emp_born'] = $_POST['born'];
        $data['emp_start'] = $_POST['start'];
        $data['emp_mail'] = $_POST['mail'];
        $data['emp_tel'] = $_POST['tel'];
        $data['emp_status'] = $_POST['status'];

        if (empty($_POST['id'])) {
            $this->db->insert('slip_employee', $data);
            alert_dialog('บันทึกสมบูรณ์', 'alert_dialog');
        } else {
            $this->db->update('slip_employee', $data, "emp_id='" . $_POST['id'] . "'");
            alert_dialog('แก้ไขเสร็จสิ้น', 'alert_dialog');
        }
        redirect('index.php');
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
        if (!required($_POST['vat'])) {
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
        $data['salary_date'] = date_to($_POST['date']);
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
        $data['salary_vat'] = $_POST['vat'];
        $data['salary_artt'] = $_POST['artt'];
        $data['salary_sumdd'] = $_POST['sumdd'];
        $data['salary_yodd'] = $_POST['yodd'];

        $this->db->insert('slip_salary', $data);
        alert("บันทึกข้อมูลเรียบร้อย");
        $id = mysql_insert_id();
        if ($_POST['submit'] == 'บันทึก') {
            redirect('index.php');
        }
        if ($_POST['submit'] == 'บันทึกและปริ้น') {
            alert('aaaaa');
            $rrr = $this->db->record(DB_PREFIX . 'employee', array('emp_id' => $_POST['emp_id']));
            /* 			echo '<pre>'; */
            /* 			print_r($rrr); */
            echo '<script>parent.window.location.reload(true);</script>';
            redirect('pay.php?id=' . $id . '&list=' . $_POST['list'] . '&mail=' . $rrr->emp_mail, 'blank');
        }
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