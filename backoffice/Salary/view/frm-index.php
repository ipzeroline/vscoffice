<?php
require '../model/class.pagelen.php';
$pl = new pagelen();
$pl->Pagelen = 30;
if (!empty($_GET)) {
    $where = "slip_salary.emp_id=slip_employee.emp_id";
    if (!empty($_GET['search'])) {
        $where = $where . " AND salary_name like '%" . $_GET['search'] . "%' ";
    }
    if (!empty($_GET['date1']) && !empty($_GET['date2'])) {
        $where = $where . " AND salary_date Between '" . date_to_sql($_GET['date1']) . "' AND '" . date_to_sql($_GET['date2']) . "' ";
    }
    $order = 'salary_id desc';
    $tbl = DB_PREFIX . 'salary,' . DB_PREFIX . 'employee';
//$cnt 	= $db->countRow($tbl, $where);
    $limit = NULL;//$pl->countRow($cnt);
    $row = $db->result($tbl, $where, $order, $limit);
} else {
    $where = "slip_salary.emp_id=slip_employee.emp_id";
    $order = 'salary_id desc';
    $tbl = DB_PREFIX . 'salary,' . DB_PREFIX . 'employee';
//$cnt 	= $db->countRow($tbl, $where);
    $limit = NULL;//$pl->countRow($cnt);
    $row = $db->result($tbl, $where, $order, $limit);
}
?>

<div class="row-fluid">
    <div class="box span12">
        <div class="box-header well">
            <h2><i class="icon-list"></i>จัดการใบเงินเดือน</h2>
            <div class="box-icon">
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <div id="search">
                <form>
                    <input autocomplete="off" autocomplete="off" placeholder="กรอกชื่อพนักงาน" style="margin-bottom: 0px;"
                           value="<?php echo $_GET["search"]; ?>" type="text" name="search" id="t-search"
                           onfocus="autocomp();">
                    <input autocomplete="off" autocomplete="off" placeholder="วันที่ระหว่าง" style="margin-bottom: 0px;width: 100px;"
                           value="" type="text" name="date1" id="date1">
                    <input autocomplete="off" autocomplete="off" placeholder="ถึงวันที่" style="margin-bottom: 0px;width: 100px;" value=""
                           type="text" name="date2" id="date2">
                    <button class="btn btn-primary"><i class="icon-search icon-white"></i>ค้นหา</button>
                </form>
            </div>
            <?php if ($row) { ?>
                <form id="form" method="get" target="_blank">
                    <div style="position:relative;">
                        <span style="left:28px;position:relative;"
                              class="icon32 icon-darkgray icon-arrowreturn-ws"></span>
                        <a href="javascript:void(0)" id="select_all"
                           style="left:30px;position:relative;">เลือกทั้งหมด</a><span
                                style="margin-left: 40px;">|</span><a id="un_select" href="javascript:void(0)"
                                                                      style="left:10px;position:relative;">ไม่เลือกเลย</a>
                        <select style="position:relative;left:20px;top: 5px;" id="action">
                            <option value="">เลือก....</option>
                            <option value="1">ออกใบเงินเดือน</option>
                        </select>
                    </div>
                    <table id="list_pay" class="table table-striped table-bordered table-condensed">
                        <thead>
                        <tr>
                            <th></th>
                            <th style="text-align:center;">ชื่อรายการ</th>
                            <th style="text-align:center;">วันที่</th>
                            <th style="width:30%;text-align:center;">ชื่อ-สกุลพนักงาน</th>
                            <th style="text-align:center;">เลขที่บัญชี</th>
                            <th style="text-align:center;">เงินเดือน</th>

                            <th style="width:25%;text-align:center;">Action</th>
                        </tr>
                        </thead>
                        <tbody id="sortable">
                        <?php

                        foreach ($row as $r) {
                            $total = ($r->salary_salary + $r->salary_ot + $r->salary_sunday) - ($r->salary_pagun + $r->salary_widen + $r->salary_kong + $r->salary_dress + $r->salary_work);
                            echo '
											<td style="text-align:center;"><input autocomplete="off" name="id[]" id="hc" value="' . $r->salary_id . '" type="checkbox"></td>
											<td style="text-align:center;">' . $r->salary_list . '</td>
											<td style="text-align:center;">' . $r->salary_date . '</td>
											<td style="text-align:left;">' . $r->salary_name . '</td>
											<td style="text-align:left;">' . $r->emp_account . '</td>
											<td style="text-align:right;">' . number_format($r->salary_yodd, 2, '.', ',') . '</td>
											<td class="center" style="text-align:center;">
												<a class="btn btn-success" href="../emp/payShow.php?id=' . $r->salary_id . '" target="_blank">
													<i class="icon-print icon-white"></i>  
													ออกใบเงินเดือน                                        
												</a>
												<a onclick="json_edit_cus(\'' . $r->salary_id . '\');" class="btn btn-info" href="#" data-toggle="modal" data-target="#Sale">
													<i class="icon-edit icon-white"></i>  
													แก้ไข                                            
												</a>
												<a class="btn btn-danger" onclick="return confirm(\'คุณแน่ใจที่ลบรายการนี้\')" href="?Mode=Del&id=' . $r->salary_id . '">
													<i class="icon-trash icon-white"></i> 
													ลบ
												</a>
											</td>
										</tr>';

                        } ?>

                        </tbody>
                    </table>
                </form>
            <?php } ?>
            <div class="clearfix"></div>

        </div>
    </div>
</div>
<div class="modal hide fade" style="top:40%" id="Sale">
    <form class="form-horizontal" method="post" action="?Mode=Add_salary" target="Alert" enctype="multipart/form-data">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h3>บันทึกเงินเดือน</h3>
        </div>
        <div class="modal-body">
            <div id="alert_dialog2" style="display:none;text-align:center;" class="alert alert-error"></div>
            <div class="control-group">
                <label class="control-label">ชื่อรายการ</label>
                <div class="controls" style="margin-left: 160px;">
                    <div class="input-prepend input-append"><input autocomplete="off" name="list" id="list" value="" size="16" type="text">
                    </div>
                </div>
            </div>
            <!---------------------------------------------------------->
            <div class="control-group">
                <label class="control-label">วันที่</label>
                <div class="controls" style="margin-left: 160px;">
                    <div class="input-prepend input-append"><input autocomplete="off" name="date" id="date" value="" size="16" type="text">
                    </div>
                </div>
            </div>
            <!---------------------------------------------------------->
            <div class="control-group">
                <label class="control-label">เงินเดือน</label>
                <div class="controls" style="margin-left: 160px;">
                    <div class="input-prepend input-append">
                        <input autocomplete="off" name="sale-name" id="sale-name" size="16" type="text" readonly="readonly">
                        <span class="add-on">=</span>
                        <input autocomplete="off" style="text-align:right;width:100px;background: #A9F5F2;" class="money_plus" id="money"
                               name="money" value="" type="text" readonly="readonly">
                        <span class="add-on">เงินต่อขั่วโมง = </span>
                        <input autocomplete="off" style="text-align:right;width:100px;background:#FFFF99;" id="money_hour"
                               name="money_hour" value="" type="text" readonly="readonly">
                    </div>
                </div>
            </div>
            <!---------------------------------------------------------->
            <div class="control-group">
                <label class="control-label">จำนวน ชม. OT</label>
                <div class="controls" style="margin-left: 160px;">
                    <div class="input-prepend input-append">
                        <input autocomplete="off" name="ot_hour" id="ot_hour" size="16" type="text" style="text-align:right;">
                        <span class="add-on">=</span>
                        <input autocomplete="off" style="text-align:right;width:100px;background: #FFFF99;" class="ot" id="ot" name="ot"
                               value="" type="text" readonly="readonly">
                    </div>
                </div>
            </div>
            <!---------------------------------------------------------->
            <div class="control-group">
                <label class="control-label">จำนวน วัน OT</label>
                <div class="controls" style="margin-left: 160px;">
                    <div class="input-prepend input-append">
                        <input autocomplete="off" name="ot_day" id="ot_day" size="16" type="text" style="text-align:right;">
                        <span class="add-on">=</span>
                        <input autocomplete="off" style="text-align:right;width:100px;background: #FFFF99;" class="otd" id="otd" name="otd"
                               value="" type="text" readonly="readonly">
                    </div>
                </div>
            </div>
            <!---------------------------------------------------------->
            <div class="control-group">
                <label class="control-label"></label>
                <div class="controls" style="margin-left: 160px;">
                    <div class="input-prepend input-append">
                        <input autocomplete="off" name="sumott" id="sumott" size="16" type="text" readonly="readonly"
                               style="text-align:right;">
                        <span class="add-on">=</span>
                        <input autocomplete="off" style="text-align:right;width:100px;background: #C5FFCA;" class="ots" id="ots" name="ots"
                               value="" type="text" readonly="readonly">
                    </div>
                </div>
            </div>
            <!---------------------------------------------------------->
            <div class="control-group">
                <label class="control-label"></label>
                <div class="controls" style="margin-left: 160px;">
                    <div class="input-prepend input-append">
                        <input autocomplete="off" name="work" id="work" size="16" type="text" readonly="readonly"
                               style="text-align:right;">
                        <span class="add-on">=</span>
                        <input autocomplete="off" style="text-align:right;width:100px;background: #C5FFCA;" class="works" id="works"
                               name="works" value="" type="text">
                    </div>
                </div>
            </div>
            <!---------------------------------------------------------->
            <div class="control-group">
                <label class="control-label"></label>
                <div class="controls" style="margin-left: 160px;">
                    <div class="input-prepend input-append">
                        <input autocomplete="off" name="com" id="com" size="16" type="text" readonly="readonly" style="text-align:right;">
                        <span class="add-on">=</span>
                        <input autocomplete="off" style="text-align:right;width:100px;background: #C5FFCA;" class="coms" id="coms"
                               name="coms" value="" type="text">
                    </div>
                </div>
            </div>
            <!---------------------------------------------------------->
            <div class="control-group">
                <label class="control-label"></label>
                <div class="controls" style="margin-left: 160px;">
                    <div class="input-prepend input-append">
                        <input autocomplete="off" name="sum" id="sum" size="16" type="text" readonly="readonly" style="text-align:right;">
                        <span class="add-on">=</span>
                        <input autocomplete="off" style="text-align:right;width:100px;background: #A9F5F2;" class="sums" id="sums"
                               name="sums" value="" type="text" readonly="readonly">
                    </div>
                </div>
            </div>
            <!---------------------------------------------------------->
            <div class="control-group" style="display:none">
                <label class="control-label">ขาด/วัน</label>
                <div class="controls" style="margin-left: 160px;">
                    <div class="input-prepend input-append">
                        <input autocomplete="off" name="dis" id="dis" size="16" type="text" style="text-align:right;">
                        <span class="add-on">=</span>
                        <input autocomplete="off" style="text-align:right;width:100px;background:#F1D0D0;" class="diss" id="diss"
                               name="diss" value="" type="text" readonly="readonly">
                    </div>
                </div>
            </div>
            <!---------------------------------------------------------->
            <div class="control-group">
                <label class="control-label"></label>
                <div class="controls" style="margin-left: 160px;">
                    <div class="input-prepend input-append">
                        <input autocomplete="off" name="disn" id="disn" size="16" readonly="readonly" type="text" style="text-align:right;">
                        <span class="add-on">=</span>
                        <input autocomplete="off" style="text-align:right;width:100px;background:#F1D0D0;" class="disnn" id="disnn"
                               name="disnn" value="" type="text">
                    </div>
                </div>
            </div>
            <!---------------------------------------------------------->
            <div class="control-group">
                <label class="control-label"></label>
                <div class="controls" style="margin-left: 160px;">
                    <div class="input-prepend input-append">
                        <input autocomplete="off" name="vatn" id="vatn" size="16"  readonly="readonly" type="text" style="text-align:right;">
                        <span class="add-on">=</span>
                        <input autocomplete="off" style="text-align:right;width:100px;background:#F1D0D0;" class="vat" id="vat"
                               name="vat" value="" type="text">
                    </div>
                </div>
            </div>
            <!---------------------------------------------------------->
            <div class="control-group">
                <label class="control-label"></label>
                <div class="controls" style="margin-left: 160px;">
                    <div class="input-prepend input-append">
                        <input autocomplete="off" name="ku" id="ku" size="16" type="text" readonly="readonly" style="text-align:right;">
                        <span class="add-on">=</span>
                        <input autocomplete="off" style="text-align:right;width:100px;background: #F1D0D0;" class="kuu" id="kuu" name="kuu"
                               value="" type="text">
                    </div>
                </div>
            </div>
            <!---------------------------------------------------------->
            <div class="control-group">
                <label class="control-label"></label>
                <div class="controls" style="margin-left: 160px;">
                    <div class="input-prepend input-append">
                        <input autocomplete="off" name="art" id="art" size="16" type="text" readonly="readonly" style="text-align:right;">
                        <span class="add-on">=</span>
                        <input autocomplete="off" style="text-align:right;width:100px;background: #F1D0D0;" class="artt" id="artt"
                               name="artt" value="" type="text" readonly="readonly">
                    </div>
                </div>
            </div>
            <!---------------------------------------------------------->
            <div class="control-group">
                <label class="control-label"></label>
                <div class="controls" style="margin-left: 160px;">
                    <div class="input-prepend input-append">
                        <input autocomplete="off" name="sumd" id="sumd" size="16" type="text" readonly="readonly"
                               style="text-align:right;">
                        <span class="add-on">=</span>
                        <input autocomplete="off" style="text-align:right;width:100px;background: #A9F5F2;" class="sumdd" id="sumdd"
                               name="sumdd" value="" type="text" readonly="readonly">
                    </div>
                </div>
            </div>
            <!---------------------------------------------------------->
            <div class="control-group">
                <label class="control-label"></label>
                <div class="controls" style="margin-left: 160px;">
                    <div class="input-prepend input-append">
                        <input autocomplete="off" name="yod" id="yod" size="16" type="text" readonly="readonly" style="text-align:right;">
                        <span class="add-on">=</span>
                        <input autocomplete="off" style="text-align:right;width:100px;background: #088A29; color:#fff;" class="yodd"
                               id="yodd" name="yodd" value="" type="text" readonly="readonly">
                    </div>
                </div>
            </div>
            <!---------------------------------------------------------->
            <input autocomplete="off" type="hidden" value="" name="emp_id" id="emp_id">
            <input autocomplete="off" type="hidden" value="" name="salary_id" id="salary_id">

        </div>
        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal">ยกเลิก</a>
            <input autocomplete="off" type="submit" value="บันทึก" class="btn btn-primary">
        </div>
    </form>
</div>
<script>
    $("#dis").keyup(function () {
        var dis = $("#dis").val();
        var total = parseFloat(dis) * 1000;
        if (isNaN(total)) {
            $("#diss").val('0');
        } else {
            $("#diss").val(total);
        }
    });
    $("#disn").keyup(function () {
        $("#dis").val(0);
        $("#diss").val('0');
        var disn = $("#disn").val();
        var hour = $("#money_hour").val();
        var tota = parseFloat(disn) / 30;
        var tol = Math.floor(tota);
        var total = tol * hour;
        if (isNaN(total)) {
            $("#disnn").val('0');
        } else {
            $("#disnn").val(total);
        }

    });
    $("#disnn,#dis,#kuu,#vat").blur(function () {
        var aa = $("#disnn").val();
        var dd = $("#diss").val();
        var kk = $("#kuu").val();
        var art = $("#artt").val();
        var vat = $("#vat").val();
        var ee = (parseFloat(aa) + parseFloat(dd) + parseFloat(kk) + parseFloat(art)) + parseFloat(vat);
        if (isNaN(ee)) {
            $("#sumdd").val('กำลังคำนวน');
        } else {
            $("#sumdd").val(ee);
        }
    });
    $("#disn,#dis,#ot_day,#ot_hour,#coms,#works,#kuu,#vat").blur(function () {
        var a = $("#sumdd").val();
        var b = $("#sums").val();
        var total = parseFloat(b) - parseFloat(a);
        if (isNaN(total)) {
            $("#yodd").val('กำลังคำนวน');
        } else {
            $("#yodd").val(total);
        }
    });
    $("#ot_hour").keyup(function () {
        var ot_hour = $("#ot_hour").val();
        var hour = $("#money_hour").val();
        $("#ot").val(ot_hour * hour);
    });
    $("#ot_day").keyup(function () {
        var ot_day = $("#ot_day").val();
        var hour = $("#money_hour").val();
        var hour = hour * 8;
        $("#otd").val(ot_day * hour);
    });
    $("#ot_day,#ot_hour").blur(function () {
        var a = $("#otd").val();
        var b = $("#ot").val();
        if (a == "") {
            $("#ots").val(parseFloat(b));
        } else if (b == "") {
            $("#ots").val(parseFloat(a));
        } else {
            $("#ots").val(parseFloat(a) + parseFloat(b));
        }
    });
    $("#ot_day,#ot_hour,#coms,#works").blur(function () {
        var aa = $("#money").val();
        var bb = $("#ots").val();
        var cc = $("#coms").val();
        var dd = $("#works").val();
        var ee = parseFloat(aa) + parseFloat(bb) - parseFloat(cc) + parseFloat(dd);
        if (isNaN(ee)) {
            $("#sums").val('กำลังคำนวน');
        } else {
            $("#sums").val(ee);
        }
    });

    function json_edit_cus(id) {
        if (id != "") {
            $.post("index.php?Mode=json_edit_emp", {id: id}, function (data) {
                $("#salary_id").val(data.salary_id);
                $("#emp_id").val(data.emp_id);
                $('#sumott').val('รวมOT');
                $('#work').val('ค่าอาหาร');
                $('#com').val('ค่าห้อง+ค่าไฟ');
                $('#sum').val('รวมสุทธิ');
                $('#disn').val('เบิกล่วงหน้า');
                $('#vatn').val('หักภาษี (บาท)');
                $('#sumd').val('รวมหัก');
                $('#yod').val('ยอดรับจริง');
                $('#ku').val('หัก กยศ.');
                $('#art').val('ประกันสังคม');
                $('#list').val(data.salary_list);
                $('#date').val(data.salary_date);
                $('#sale-name').val(data.salary_name);
                $('#money').val(data.salary_salary);
                $('#money_hour').val(data.salary_money_hour);
                $('#ot_hour').val(data.salary_ot_hour);
                $('#ot').val(data.salary_ot);
                $('#ot_day').val(data.salary_ot_day);
                $('#otd').val(data.salary_otd);
                $('#ots').val(data.salary_ots);
                $('#works').val(data.salary_works);
                $('#coms').val(data.salary_coms);
                $('#sums').val(data.salary_sums);
                $('#dis').val(data.salary_dis);
                $('#diss').val(data.salary_diss);
                // $('#disn').val(data.salary_disn);
                $('#disnn').val(data.salary_disnn);
                $('#vat').val(data.salary_vat);
                $('#kuu').val(data.salary_kuu);
                $('#artt').val(data.salary_artt);
                $('#sumdd').val(data.salary_sumdd);
                $('#yodd').val(data.salary_yodd);
            }, "json");
        }
    }

    $(function () {
        $("#date").datepicker({dateFormat: 'yy-mm-dd'});
        $("#born").datepicker({dateFormat: 'yy/mm/dd', changeMonth: true, changeYear: true});
        $("#start").datepicker({dateFormat: 'yy/mm/dd', changeMonth: true, changeYear: true});
    });

    function autocomp() {
        $.post("index.php?Mode=json_autocom", {}, function (data) {

            var data = $.parseJSON(data);

            $("#t-search").autocomplete({
                delay: 0,
                source: data
            });

        });
    }

    $(function () {
        $("#date1,#date2").datepicker({dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true});
        $('#search').val('<?php echo $_GET["search"]?>');
        $('#date1').val('<?php echo $_GET["date1"]?>');
        $('#date2').val('<?php echo $_GET["date2"]?>');
        $('#select_all').click(function () {

            $("#list_pay input[type='checkbox']").each(function () {
                $(this).attr('checked', 'checked');
                $(this).parent().attr('class', 'checked');
            });
        });
        $('#un_select').click(function () {
            $("#list_pay input[type='checkbox']").each(function () {
                $(this).attr('checked', false);
                $(this).parent().attr('class', '');
            });
        });
        $('#action').change(function () {
            var n = $("#hc:checked").val();
            if (typeof n === "undefined") {
                alert("กรุณาเลือกพนักงานค่ะ");
            } else if ($('#action').val() == "1" && typeof n !== "undefined") {
                $('#form').attr('action', "../emp/pay.php");
                $("#form").submit();
            } else if ($('#action').val() != "1") {
                alert("กรุณาเลือกประเภทการทำงานค่ะ");
            } else {

            }
        });
    });
</script>

