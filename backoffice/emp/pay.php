<?php
define('DS', DIRECTORY_SEPARATOR);
require '../tm.define.php';
require 'tm.class.php';

include('../phpmailer_helper.php');
//require '..' . DS . '..' . DS . 'init.php';
include("MPDF/mpdf.php");

class Tm_mPDF extends mPDF
{

    public function ch_none($num)
    {
        if ($num == 0) {
            return "-";
        } else {
            return number_format($num, 2, '.', ',');
        }
    }

}

//==============================================================
//==============================================================
//==============================================================


$mpdf = new Tm_mPDF('th', 'A4', '', '', 5, 5, 5, 5, 6, 3);
$mpdf->SetWatermarkImage('logo-orange.jpg');
$mpdf->showWatermarkImage = true;

$mpdf->SetDisplayMode('fullpage');

$mpdf->list_indent_first_level = 0;    // 1 or 0 - whether to indent the first level of a list

// LOAD a stylesheet
/* $stylesheet = file_get_contents('mpdfstyletables.css'); */
$mpdf->WriteHTML($stylesheet, 1);    // The parameter 1 tells that this is css/style only and no body/html/text

if (is_array($_REQUEST['id'])) {
    $j = 1;
    foreach ($_REQUEST['id'] as $key => $value) {
        $data[$j] = $value;
        $j++;
    }

} else {
    $data[1] = $_REQUEST['id'];
}


for ($i = 1; $i <= count($data); $i++) {
    $tbll = DB_PREFIX . 'salary' . ' INNER JOIN ' . DB_PREFIX . 'employee' . ' ON  slip_salary.emp_id = slip_employee.emp_id INNER JOIN ' . DB_PREFIX . 'jobs' . ' ON  slip_employee.emp_jobs = slip_jobs.jobs_id';
    $r = $db->record($tbll, "salary_id='" . $data[$i] . "'");

    if ($i % 2 == 0) {
        $sty = 'style="margin-top:15px;"';
    } else {
        $sty = "";
    }
    $html = '
<style>
.bort{border-bottom:0.1mm solid #000; }
.right{text-align:right;}
td{ width:50px;}
th{ text-align:left;}
</style>
';
    for ($h = 1; $h <= 2; $h++) {
        if ($h == 2) {
            $float = "float:right;";
            $head = "สำเนา";
            $line = '<hr style="border:0px;border-bottom:1px dotted #000; margin-top:50px; margin-bottom:5px;" />';
        } else {
            $float = "float:left;";
            $head = "ต้นฉบับ";
            $line = "";
        }
        $html = $html . $line . '
<table width="781" align="center" style="margin-top:15px;">
    	<tr>
        	<th><img src="logo-orange.jpg" width="130" height="130" /></th>
          	<th>
			<table width="620">
				<tr><th align="right" height="40"><p>(' . $head . ')</p></th></tr>
				<tr>
					<th height="90">
                        VESSUWAN CONSTRUCTION (1984) COMPANY LIMITED<br>
289 หมู่ 4 ตำบลจำป่าหวาย อำเภอเมือง จังหวัดพะเยา 56000<br>
เลขประจำตัวผู้เสียภาษี 0565563000465 (สำนักงานใหญ่)<br>
<br />
					</th>
				</tr>
			</table>					
          	</th>
        </tr>
    </table>
	<table width="781" style="border-collapse:collapse; border:#000; margin-bottom:10px;" border="1" align="center"> 
    	<tr>
        	<td align="center" colspan="13">ใบแจ้งเงินเดือน<b>(PAY SLIP)<b></td>
        </tr>
        <tr style="text-align:center;">
        	<td colspan="2" align="center">ชื่อ-นามสกุล</td>
            <td bgcolor="#FFFFFF" colspan="3" align="center">' . $r->emp_name . '</td>
            <td colspan="2" align="center">ประจำเดือน</td>
            <td bgcolor="#FFFFFF" colspan="2" align="center">' . $r->salary_mont . '</td>
            <td align="center">ตำแหน่ง</td>
            <td bgcolor="#FFFFFF" colspan="3" align="center">' . $r->jobs_name . '</td>
        </tr>
        <tr style="text-align:center;">
        	<td colspan="2" align="center">บัญชีธนาคาร</td>
            <td colspan="5" bgcolor="#FFFFFF" align="center">' . $r->emp_bank . '</td>
			<td colspan="2" align="center">เลขที่บัญชี</td>
            <td colspan="4" bgcolor="#FFFFFF" align="center">' . $r->emp_account . '</td>
        </tr>
        <tr style="text-align:center;">
        	<td colspan="7" align="center">รายการรับ</td>
            <td colspan="6" align="center">รายการหัก</td>
        </tr>
        <tr>
        	<td style="text-align:center;" colspan="2">เงินเดือน</td>
            <td colspan="4" bgcolor="#FFFFFF" style="text-align:right;">' . ch_none($r->salary_salary) . '</td>
            <td style="text-align:center;">บาท</td>
            <td style="text-align:center;" colspan="6"></td>
        </tr>
        <tr>
        	<td style="text-align:center;" colspan="2">รวมโอที<b>(OT)</b></td>
            <td colspan="4" bgcolor="#FFFFFF" style="text-align:right;">' . ch_none($r->salary_ots) . '</td>
            <td style="text-align:center;">บาท</td>
            <td style="text-align:center;" colspan="6"></td>
        </tr>
        <tr>
        	<td style="text-align:center;" colspan="2">ค่าอาหาร</td>
            <td colspan="4" bgcolor="#FFFFFF" style="text-align:right;">' . ch_none($r->salary_works) . '</td>
            <td style="text-align:center;">บาท</td>
            <td style="text-align:center;">ขาดงาน</td>
            <td style="text-align:right;" bgcolor="#FFFFFF">' . $r->salary_dis . '</td>
            <td style="text-align:center;">วัน</td>
            <td style="text-align:right;" bgcolor="#FFFFFF" colspan="2">' . ch_none($r->salary_diss) . '</td>
            <td style="text-align:center;">บาท</td>
        </tr>
        <tr>
        	<td style="text-align:center;" colspan="2">ค่าห้อง+ค่าไฟ</td>
            <td colspan="4" bgcolor="#FFFFFF" style="text-align:right;">' . ch_none($r->salary_coms) . '</td>
            <td style="text-align:center;">บาท</td>
            <td style="text-align:center;">เงินค้างชำระบริษัท</td>
            <td style="text-align:right;" bgcolor="#FFFFFF" colspan="4">' . ch_none($r->salary_kuu) . '</td>
            <td style="text-align:center;">บาท</td>
        </tr>
        <tr>
        	<td style="text-align:center;" colspan="2">เงินต่อ ชม.</td>
            <td colspan="4" bgcolor="#FFFFFF" style="text-align:right;">' . ch_none($r->salary_money_hour) . '</td>
            <td style="text-align:center;">บาท</td>
            <td style="text-align:center;" colspan="2">ประกันสังคม</td>
            <td style="text-align:right;" bgcolor="#FFFFFF" colspan="3">' . ch_none($r->salary_artt) . '</td>
            <td style="text-align:center;">บาท</td>
        </tr>
        <tr>
        	<td style="text-align:center;" colspan="2">จำนวน ชม. โอที</td>
            <td colspan="2" bgcolor="#FFFFFF" style="text-align:right;">' . $r->salary_ot_hour . '</td>
            <td style="text-align:center;">ชม.</td>
            <td bgcolor="#FFFFFF" style="text-align:right;">' . ch_none($r->salary_ot) . '</td>
            <td style="text-align:center;">บาท</td>
             <td style="text-align:center;" colspan="2">ภาษี</td>
            <td style="text-align:right;" bgcolor="#FFFFFF" colspan="3">' . $r->salary_vat . '</td>
            <td style="text-align:center;">บาท</td>
        </tr>
        <tr>
        	<td style="text-align:center;" colspan="2">จำนวนวัน โอที</td>
            <td colspan="2" bgcolor="#FFFFFF" style="text-align:right;">' . $r->salary_ot_day . '</td>
            <td style="text-align:center;">วัน</td>
            <td bgcolor="#FFFFFF" style="text-align:right;">' . ch_none($r->salary_otd) . '</td>
            <td style="text-align:center;">บาท</td>
            <td style="text-align:center;" colspan="2">เบิกล่วงหน้า</td>
            <td style="text-align:right;" bgcolor="#FFFFFF" colspan="3">' . ch_none($r->salary_disnn) . '</td>
            <td style="text-align:center;">บาท</td>
        </tr>
		<tr>
        	<td style="text-align:center;" colspan="2"><b>รวมสุทธิ</b></td>
            <td colspan="4" bgcolor="#FFFFFF" style="text-align:right;">' . ch_none($r->salary_sums) . '</td>
            <td style="text-align:center;">บาท</td>
            <td style="text-align:center;" colspan="2"><b>รวมหัก</b></td>
            <td style="text-align:right;" bgcolor="#FFFFFF" colspan="3">' . ch_none($r->salary_sumdd) . '</td>
            <td style="text-align:center;">บาท</td>
        </tr>
		<tr>
			<td style="text-align:center;" colspan="2"><u><b>ยอดรับจริง</b></u></td>
			<td colspan="10" bgcolor="#FFFFFF" style="text-align:right;"><u>' . ch_none($r->salary_yodd) . '</u></td>
			<td style="text-align:center;">บาท</td>
		</tr>
        <tr style="border:none;">
        	<td style="border:none;" colspan ="13"></td>

		</tr>	
    </table>
	<div align="right">ผู้จ่ายเงิน______________________</div>
	<div style="margin-top:7px;" align="right">ผู้รับเงิน______________________</div>
	';
    }
    $mpdf->WriteHTML($html);
    /* $mpdf->Output('srara.pdf', 'D'); */
//    $mpdf->Output();
//    $mpdf->Output('../pdf/srara.pdf', 'F');
//    send_email($sender = array(0 => $r->emp_mail), $r->salary_list, 'Salary', $file_attachment = '../pdf/srara.pdf', $type = 'upload', $from_email = 'cdxooopz@gmail.com', $from_name = 'pttac');
}
$mpdf->Output();

?>
<!--    <script>-->
<!--        window.close();-->
<!--    </script>-->
<?php
exit;
//==============================================================
//==============================================================
//==============================================================
/*<td style="text-align:center;"></td>
            <td style="text-align:right;" bgcolor="#FFFFFF">-</td>
            <td style="text-align:center;"></td>
            <td style="text-align:right;" bgcolor="#FFFFFF" colspan="2">-</td>
            <td style="text-align:center;" bgcolor="#CFCFCF"></td>
*/
?>