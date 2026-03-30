<?php
function ch_none($num)
{
    if ($num == 0) {
        return "-";
    } else {
        return number_format($num, 2, '.', ',');
    }
}

function thai_date($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    $strSeconds = date("s", strtotime($strDate));
    $strMonthCut = array(
        "0" => "",
        "1" => "มกราคม",
        "2" => "กุมภาพันธ์",
        "3" => "มีนาคม",
        "4" => "เมษายน",
        "5" => "พฤษภาคม",
        "6" => "มิถุนายน",
        "7" => "กรกฎาคม",
        "8" => "สิงหาคม",
        "9" => "กันยายน",
        "10" => "ตุลาคม",
        "11" => "พฤศจิกายน",
        "12" => "ธันวาคม"
    );
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strMonthThai $strYear";
}


function required($field)
{
    return ($field == '') ? FALSE : TRUE;
}

function matches($str, $field)
{
    return ($str !== $field) ? FALSE : TRUE;
}

function minLength($str, $val)
{
    if (preg_match("/[^0-9]/", $val)) return FALSE;

    return (strlen($str) < $val) ? FALSE : TRUE;
}

function maxLength($str, $val)
{
    if (preg_match("/[^0-9]/", $val)) return FALSE;

    return (strlen($str) > $val) ? FALSE : TRUE;
}

function exactLength($str, $val)
{
    if (preg_match("/[^0-9]/", $val)) return FALSE;

    return (strlen($str) != $val) ? FALSE : TRUE;
}

function validEmail($str)
{
    if (empty($str)) return TRUE;
    return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
}

function alpha($str)
{
    return (!preg_match("/^([a-z])+$/i", $str)) ? FALSE : TRUE;
}

function alphaNumeric($str)
{
    return (!preg_match("/^([a-z0-9])+$/i", $str)) ? FALSE : TRUE;
}

function alphaDash($str)
{
    return (!preg_match("/^([-a-z0-9_-])+$/i", $str)) ? FALSE : TRUE;
}

function numeric($str)
{
    if ((bool)preg_match('/^[\-+]?[0-9]*\.?[0-9]+$/', $str))
        return $str;
    else
        return '';
}

function isNumeric($str)
{
    return (!is_numeric($str)) ? FALSE : TRUE;
}

function integer($str)
{
    return (bool)preg_match('/^[\-+]?[0-9]+$/', $str);
}

function setSelected($field = '', $value = '')
{
    if (is_array($value))
        return (in_array($field, $value)) ? ' selected="selected"' : '';
    else
        return ($field == $value) ? ' selected="selected"' : '';
}

function setChecked($field = '', $value = '')
{
    if (is_array($value))
        return (in_array($field, $value)) ? ' checked="checked"' : '';
    else
        return ($field == $value) ? ' checked="checked"' : '';
}

function redirect($uri = '', $method = 'parent')
{
    switch ($method) {
        case 'refresh'    :
            echo '<script language="javascript">window.parent.location.reload("' . $uri . '");</script>';
            break;
        case 'window'    :
            echo '<script language="javascript">window.location.replace("' . $uri . '");</script>';
            break;
        case 'blank'    :
            echo '<script language="javascript">window.parent.open("' . $uri . '");</script>';
            break;
        default    :
            echo '<script language="javascript">window.parent.location.replace("' . $uri . '");</script>';
            break;
    }
    exit;
}

function reload()
{
    echo '<script language="javascript">window.parent.location.reload();</script>';
}

function alert_dialog($text, $id)
{
    echo '<script language="javascript">
			window.parent.document.getElementById("' . $id . '").innerHTML="' . $text . '";
			window.parent.document.getElementById("' . $id . '").style.display="";
		  </script>';
}

function alert($msg)
{
    if ($msg != '') {
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        if (is_array($msg)) {
            $t = '';
            foreach ($msg as $msg) {
                $t .= $msg . '\n';
            }
            echo "<script language=\"javascript\">alert('" . $t . "');</script>";

        } else {
            echo "<script language=\"javascript\">alert('" . $msg . "');</script>";
        }
    }
}

function backpage()
{
    echo "<script language=\"javascript\">";
    echo "	location.href=\"javascript:history.back()\";";
    echo "</script>";
}

function delDir($path)
{
    $dir = dir($path);
    while ($file = $dir->read()) {
        if (($file != '.') && ($file != '..')) {
            unlink($dir->path . DS . $file);
        }
    }
    $dir->close();
    rmdir($dir->path);
}

function sql_in($val)
{
    if (is_array($val))
        if ($val)
            return "IN (" . implode(',', $val) . ")";
        else
            return 'false';
    else
        return $val;
}

function sql_b2v($val1, $val2)
{
    return "BETWEEN {$val1} AND {$val2}";
}

function sql_like($val1, $type = '2')
{
    if ($type == '0') return "LIKE '{$val1}'";
    if ($type == '1') return "LIKE '{$val1}%%'";
    if ($type == '2') return "LIKE '%{$val1}%'";
    if ($type == '3') return "LIKE '%%{$val1}'";
}

function user_ip()
{
    //find user ip
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $output = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $output = $_SERVER['HTTP_CLIENT_IP'];
    } else {
        $output = $_SERVER['REMOTE_ADDR'];
    }
    return $output;
}// user_ip

function datethai_shot($date)
{
    $month_name = array("01" => "ม.ค.", "02" => "ก.พ.", "03" => "มี.ค.", "04" => "เม.ย.", "05" => "พ.ค.", "06" => "มิ.ย.", "07" => "ก.ค.", "08" => "ส.ค.", "09" => "ก.ย.", "10" => "ต.ค.", "11" => "พ.ย.", "12" => "ธ.ค.");
    $dg = explode("-", $date);
    $y = $dg[0] + 543;
    $m = $dg[1];
    $monthnow = $month_name[$m];
    if ($dg[2] < 10) {
        $dg[2] = substr($dg[2], 1, 1);
    }
    $date = $dg[2] . " " . $monthnow . " " . $y;
    return $date;
}

function datethai($date)
{
    $month_name = array("01" => "มกราคม", "02" => "กุมภาพันธ์", "03" => "มีนาคม", "04" => "เมษายน", "05" => "พฤษภาคม", "06" => "มิถุนายน", "07" => "กรกฎาคม", "08" => "สิงหาคม", "09" => "กันยายน", "10" => "ตุลาคม", "11" => "พฤศจิกายน", "12" => "ธันวาคม");
    $dg = explode("-", $date);
    $y = $dg[0] + 543;
    $m = $dg[1];
    $monthnow = $month_name[$m];
    if ($dg[2] < 10) {
        $dg[2] = substr($dg[2], 1, 1);
    }
    $date = $dg[2] . " " . $monthnow . " " . $y;
    return $date;
}

function sql_to_date($date_sql)
{
    if (!empty($date_sql)) {
        $date = explode("-", $date_sql);
        return $date = $date[2] . "/" . $date[1] . "/" . $date[0];
    }
}

function date_to_sql($date_sql)
{
    if (!empty($date_sql)) {
        $date = explode("/", $date_sql);
        return $date = $date[2] . "-" . $date[1] . "-" . $date[0];
    }
}

function date_to($date_sql)
{
    if (!empty($date_sql)) {
        $date = explode("/", $date_sql);
        return $date = $date[0] . "-" . $date[1] . "-" . $date[2];
    }
}

function date_to_show($date_sql)
{
    if (!empty($date_sql)) {
        $date = explode("-", $date_sql);
        return $date = $date[0] . "/" . $date[1] . "/" . $date[2];
    }
}

?>