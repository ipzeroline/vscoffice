<?php
require '../model/class.pagelen.php';
$pl = new pagelen();
$pl->Pagelen = 100;
if (empty($_GET['search'])) {
    $where = null;
} else {
    $where = "emp_name like '%" . $_GET['search'] . "%'";
}
$order = 'emp_status desc,emp_start asc';
$tbl = DB_PREFIX . 'employee' . ' INNER JOIN ' . DB_PREFIX . 'jobs' . ' ON  slip_employee.emp_jobs = slip_jobs.jobs_id';
$cnt = $db->countRow($tbl, $where);
$limit = $pl->countRow($cnt);
$row = $db->result($tbl, $where, $order, $limit);
?>
<div class="row-fluid">
    <div class="box span12">
        <div class="box-header well">
            <h2><i class="icon-list"></i>จัดการข้อมูลพนักงาน</h2>
            <div class="box-icon">
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <div style="text-align:right;padding-bottom:10px;">
                <div id="search" style="float: left;">
                    <form class="form-horizontal">
                        <input autocomplete="off" onfocus="autocomp();" class="typeahead" placeholder="กรอกชื่อพนักงาน"
                               data-items="4" style="margin-bottom: 0px;" data-provide="typeahead" id="search-box"
                               type="text" name="search">
                        <button class="btn btn-primary"><i class="icon-search icon-white"></i>ค้นหา</button>
                    </form>
                </div>
                <a class="btn btn-success" onclick="json_edit_cus('');" data-toggle="modal" href="#"
                   data-target="#Modal">
                    <i class="icon-plus-sign icon-white"></i>เพิ่มข้อมูลพนักงาน
                </a>
            </div>
            <table class="table table-striped table-bordered table-condensed">
                <thead>
                <tr>
                    <th style="width:15%;text-align:center;">ชื่อ-สกุลพนักงาน</th>
                    <th style="text-align:center;">ชื่อเล่น</th>
                    <th style="text-align:center;">ตำแหน่ง</th>
                    <th style="text-align:center;">เลขที่บัญชี</th>
                    <th style="text-align:center;">ธนาคาร</th>
                    <th style="text-align:center;width:10%;">เงินเดือน<br><small>(ปัจจุบัน)</small></th>
                    <th style="text-align:center;width:10%;">ประกันสังคม</th>
                    <th style="text-align:center;">สถานะ</th>
                    <th style="text-align:center;">วันเข้าทำงาน</th>
                    <th style="text-align:center;">Action</th>
                </tr>
                </thead>
                <tbody id="sortable">
                <?php
                if ($row) {
                    foreach ($row as $r) {
                        if ($r->emp_status == 2) {
                            $sta = '<lable class="label label-success">เป็นพนักงาน</lable>';
                        } else if ($r->emp_status == 1) {
                            $sta = '<lable class="label">ออกจากงาน</lable>';
                        }
                        echo '
											<td style="text-align:center;">' . $r->emp_name . '</td>
											<td style="text-align:center;">' . $r->emp_nickname . '</td>
											<td style="text-align:center;">' . $r->jobs_name . '</td>
											<td style="text-align:center;">' . $r->emp_account . '</td>
											<td style="text-align:center;">' . $r->emp_bank . '</td>
											<td style="text-align:right;">' . number_format($r->emp_salary, 2, '.', ',') . '</td>
											<td style="text-align:right;">' . number_format($r->sso, 2, '.', ',') . '</td>
											<td style="text-align:center;">' . $sta . '</td>
											<td style="text-align:center;">' . $r->emp_start . '</td>
											<td class="center" style="text-align:center;">
												<a class="btn btn-success" onclick="json_sale_cus(\'' . $r->emp_id . '\');" href="#" data-toggle="modal" data-target="#Sale">
													<i class="icon-flag icon-white"></i>  
													จ่ายเงินเดือน                                        
												</a>
												<a onclick="json_edit_cus(\'' . $r->emp_id . '\');" class="btn btn-info" href="#" data-toggle="modal" data-target="#Modal">
													<i class="icon-edit icon-white"></i>  
													แก้ไข                                            
												</a>
											</td>
										</tr>';

                    }
                } ?>
                </tbody>
            </table>
            <?php echo $pl->render('?search=' . $_GET['search'] . '&'); ?>
            <div class="clearfix"></div>
        </div>
    </div>
    <div>
        <div class="modal hide fade" id="Modal">
            <form class="form-horizontal" method="post" action="?Mode=Add_emp" target="Alert"
                  enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>เพิ่ม/แก้ไขข้อมูลพนักงาน</h3>
                </div>
                <div class="modal-body">
                    <div id="alert_dialog" style="display:none;text-align:center;" class="alert alert-error"></div>

                    <div class="control-group">
                        <label class="control-label" for="selectError">ตำแหน่งงาน</label>
                        <div class="controls" style="margin-left:180px;">
                            <select id="selectError" data-rel="chosen" name="po" id="po">
                                <option value="">::กรุณาเลือกค่ะ::</option>
                                <?php
                                $tbladd = DB_PREFIX . 'jobs';
                                $add = $db->result($tbladd, null, null, null);
                                if ($add) {
                                    foreach ($add as $a) {
                                        echo '<option value="' . $a->jobs_id . '">' . $a->jobs_name . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">คำนำหน้าชื่อ</label>
                        <div class="controls" style="margin-left: 180px;">
                            <label class="radio">
                                <div class="radio" id="uniform-optionsRadios1"><span><input type="radio" name="first"
                                                                                            id="optionsRadios1"
                                                                                            value="1"
                                                                                            style="opacity: 0;"></span>
                                </div>
                                นาย
                            </label>
                            <div style="clear:both"></div>
                            <label class="radio">
                                <div class="radio" id="uniform-optionsRadios2"><span><input type="radio" name="first"
                                                                                            id="optionsRadios2"
                                                                                            value="2"
                                                                                            style="opacity: 0;"></span>
                                </div>
                                นาง
                            </label>
                            <div style="clear:both"></div>
                            <label class="radio">
                                <div class="radio" id="uniform-optionsRadios2"><span><input type="radio" name="first"
                                                                                            id="optionsRadios2"
                                                                                            value="3"
                                                                                            style="opacity: 0;"></span>
                                </div>
                                นส.
                            </label>
                        </div>
                    </div>
                    <?php
                    inputText('ชื่อ-สกุล', 'name', '', '160');
                    inputText('ชื่อเล่น', 'nickname', '', '160');
                    inputText('เลขที่บัญชี', 'account', '', '160');
                    inputText('ธนาคาร', 'bank', '', '160');
                    inputText('เงินเดือน(ปัจจุบัน)', 'salary', '', '160');
                    inputText('ค่าประกันสังคม', 'sso', '', '160');
                    inputText('วันเกิด', 'born', '', '160');
                    inputText('วันเข้าทำงาน', 'start', '', '160');
                    inputText('อีเมล', 'mail', '', '160');
                    inputText('โทรศัพท์', 'tel', '', '160');
                    inputHidden('', 'id')
                    ?>
                    <div class="control-group">
                        <label class="control-label">สถานะ</label>
                        <div class="controls" style="margin-left: 180px;">
                            <label class="radio">
                                <div class="radio" id="uniform-optionsRadios1"><span><input type="radio" name="status"
                                                                                            id="optionsRadios1"
                                                                                            value="2"
                                                                                            style="opacity: 0;"></span>
                                </div>
                                เป็นพนักงาน
                            </label>
                            <div style="clear:both"></div>
                            <label class="radio">
                                <div class="radio" id="uniform-optionsRadios2"><span><input type="radio" name="status"
                                                                                            id="optionsRadios2"
                                                                                            value="1"
                                                                                            style="opacity: 0;"></span>
                                </div>
                                ลาออก
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn" data-dismiss="modal">ยกเลิก</a>
                    <input type="submit" value="บันทึก" class="btn btn-primary">
                </div>
            </form>
        </div>
        <div class="modal hide fade" style="top:40%" id="Sale">
            <form class="form-horizontal" method="post" action="?Mode=Add_salary" target="Alert"
                  enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>บันทึกเงินเดือน</h3>
                </div>
                <div class="modal-body">
                    <div id="alert_dialog2" style="display:none;text-align:center;" class="alert alert-error"></div>
                    <div class="control-group">
                        <label class="control-label">ชื่อรายการ</label>
                        <div class="controls" style="margin-left: 160px;">
                            <div class="input-prepend input-append"><input name="list" id="list" value="" size="16"
                                                                           type="text"></div>
                        </div>
                    </div>
                    <!---------------------------------------------------------->
                    <div class="control-group">
                        <label class="control-label">วันที่</label>
                        <div class="controls" style="margin-left: 160px;">
                            <div class="input-prepend input-append"><input name="date" id="date"
                                                                           value="<?php echo date("Y/m/d"); ?>"
                                                                           size="16" type="text"></div>
                        </div>
                    </div>
                    <!---------------------------------------------------------->
                    <div class="control-group">
                        <label class="control-label">เงินเดือน</label>
                        <div class="controls" style="margin-left: 160px;">
                            <div class="input-prepend input-append">
                                <input name="sale-name" id="sale-name" size="16" type="text" readonly="readonly">
                                <span class="add-on">=</span>
                                <input style="text-align:right;width:100px;background: #A9F5F2;" class="money_plus"
                                       id="money" name="money" value="" type="text" readonly="readonly">
                                <span class="add-on">เงินต่อขั่วโมง = </span>
                                <input style="text-align:right;width:100px;background:#FFFF99;" id="money_hour"
                                       name="money_hour" value="" type="text" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <!---------------------------------------------------------->
                    <div class="control-group">
                        <label class="control-label">จำนวน ชม. OT</label>
                        <div class="controls" style="margin-left: 160px;">
                            <div class="input-prepend input-append">
                                <input name="ot_hour" id="ot_hour" size="16" type="text" style="text-align:right;">
                                <span class="add-on">=</span>
                                <input style="text-align:right;width:100px;background: #FFFF99;" class="ot" id="ot"
                                       name="ot" value="" type="text" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <!---------------------------------------------------------->
                    <div class="control-group">
                        <label class="control-label">จำนวน วัน OT</label>
                        <div class="controls" style="margin-left: 160px;">
                            <div class="input-prepend input-append">
                                <input name="ot_day" id="ot_day" size="16" type="text" style="text-align:right;">
                                <span class="add-on">=</span>
                                <input style="text-align:right;width:100px;background: #FFFF99;" class="otd" id="otd"
                                       name="otd" value="" type="text" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <!---------------------------------------------------------->
                    <div class="control-group">
                        <label class="control-label"></label>
                        <div class="controls" style="margin-left: 160px;">
                            <div class="input-prepend input-append">
                                <input name="sumott" id="sumott" size="16" type="text" readonly="readonly"
                                       style="text-align:right;">
                                <span class="add-on">=</span>
                                <input style="text-align:right;width:100px;background: #C5FFCA;" class="ots" id="ots"
                                       name="ots" value="" type="text" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <!---------------------------------------------------------->
                    <div class="control-group">
                        <label class="control-label"></label>
                        <div class="controls" style="margin-left: 160px;">
                            <div class="input-prepend input-append">
                                <input name="work" id="work" size="16" type="text" readonly="readonly"
                                       style="text-align:right;">
                                <span class="add-on">=</span>
                                <input style="text-align:right;width:100px;background: #C5FFCA;" class="works"
                                       id="works" name="works" value="" type="text">
                            </div>
                        </div>
                    </div>
                    <!---------------------------------------------------------->
                    <div class="control-group">
                        <label class="control-label"></label>
                        <div class="controls" style="margin-left: 160px;">
                            <div class="input-prepend input-append">
                                <input name="com" id="com" size="16" type="text" readonly="readonly"
                                       style="text-align:right;">
                                <span class="add-on">=</span>
                                <input style="text-align:right;width:100px;background: #F1D0D0;" class="coms" id="coms"
                                       name="coms" value="" type="text">
                            </div>
                        </div>
                    </div>
                    <!---------------------------------------------------------->
                    <div class="control-group">
                        <label class="control-label"></label>
                        <div class="controls" style="margin-left: 160px;">
                            <div class="input-prepend input-append">
                                <input name="sum" id="sum" size="16" type="text" readonly="readonly"
                                       style="text-align:right;">
                                <span class="add-on">=</span>
                                <input style="text-align:right;width:100px;background: #A9F5F2;" class="sums" id="sums"
                                       name="sums" value="" type="text" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <!---------------------------------------------------------->
                    <div class="control-group" >
                        <label class="control-label">ขาด/วัน</label>
                        <div class="controls" style="margin-left: 160px;">
                            <div class="input-prepend input-append">
                                <input name="dis" id="dis" size="16" type="text" style="text-align:right;" value="0">
                                <span class="add-on">=</span>
                                <input style="text-align:right;width:100px;background:#F1D0D0;" class="diss" id="diss"
                                       name="diss" value="0" type="text" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <!---------------------------------------------------------->
                    <div class="control-group">
                        <label class="control-label"></label>
                        <div class="controls" style="margin-left: 160px;">
                            <div class="input-prepend input-append">
                                <input name="disn" id="disn" size="16" readonly="readonly" type="text" style="text-align:right;">
                                <span class="add-on">=</span>
                                <input style="text-align:right;width:100px;background:#F1D0D0;" class="disnn" id="disnn"
                                       name="disnn" value="" type="text">
                            </div>
                        </div>
                    </div>
                    <!---------------------------------------------------------->
                    <div class="control-group">
                        <label class="control-label"></label>
                        <div class="controls" style="margin-left: 160px;">
                            <div class="input-prepend input-append">
                                <input name="vatn" id="vatn" size="16"  readonly="readonly" type="text" style="text-align:right;">
                                <span class="add-on">=</span>
                                <input style="text-align:right;width:100px;background:#F1D0D0;" class="vat" id="vat"
                                       name="vat" value="" type="text">
                            </div>
                        </div>
                    </div>
                    <!---------------------------------------------------------->
                    <div class="control-group">
                        <label class="control-label"></label>
                        <div class="controls" style="margin-left: 160px;">
                            <div class="input-prepend input-append">
                                <input name="ku" id="ku" size="16" type="text" readonly="readonly"
                                       style="text-align:right;">
                                <span class="add-on">=</span>
                                <input style="text-align:right;width:100px;background: #F1D0D0;" class="kuu" id="kuu"
                                       name="kuu" value="" type="text">
                            </div>
                        </div>
                    </div>
                    <!---------------------------------------------------------->
                    <div class="control-group">
                        <label class="control-label"></label>
                        <div class="controls" style="margin-left: 160px;">
                            <div class="input-prepend input-append">
                                <input name="art" id="art" size="16" type="text" readonly="readonly"
                                       style="text-align:right;">
                                <span class="add-on">=</span>
                                <input style="text-align:right;width:100px;background: #F1D0D0;" class="artt" id="artt"
                                       name="artt" value="" type="text" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <!---------------------------------------------------------->
                    <div class="control-group">
                        <label class="control-label"></label>
                        <div class="controls" style="margin-left: 160px;">
                            <div class="input-prepend input-append">
                                <input name="sumd" id="sumd" size="16" type="text" readonly="readonly"
                                       style="text-align:right;">
                                <span class="add-on">=</span>
                                <input style="text-align:right;width:100px;background: #A9F5F2;" class="sumdd"
                                       id="sumdd" name="sumdd" value="" type="text" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <!---------------------------------------------------------->
                    <div class="control-group">
                        <label class="control-label"></label>
                        <div class="controls" style="margin-left: 160px;">
                            <div class="input-prepend input-append">
                                <input name="yod" id="yod" size="16" type="text" readonly="readonly"
                                       style="text-align:right;">
                                <span class="add-on">=</span>
                                <input style="text-align:right;width:100px;background: #088A29; color:#fff;"
                                       class="yodd" id="yodd" name="yodd" value="" type="text" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <!---------------------------------------------------------->
                    <input type="hidden" value="" name="emp_id" id="emp_id">

                </div>
                <div class="modal-footer">
                    <a href="#" class="btn" data-dismiss="modal">ยกเลิก</a>
                    <input type="submit" value="บันทึก" name="submit" class="btn btn-primary">
                    <input type="submit" value="บันทึกและปริ้น" name="submit" class="btn btn-primary">
                </div>
            </form>
        </div>
        <script>
            function getMoney(A) {
                var a = Number(A);
                var b = a.toFixed(2); //get 12345678.90
                a = parseInt(a); // get 12345678
                b = (b - a).toPrecision(2); //get 0.90
                b = parseFloat(b).toFixed(2); //in case we get 0.0, we pad it out to 0.00
                a = a.toLocaleString();//put in commas - IE also puts in .00, so we'll get 12,345,678.00
                //if IE (our number ends in .00)
                if (a < 1 && a.lastIndexOf('.00') == (a.length - 3)) {
                    a = a.substr(0, a.length - 3); //delete the .00
                }
                return a + b.substr(1);//remove the 0 from b, then return a + b = 12,345,678.90
            }

            function json_edit_cus(id) {
                if (id != "") {
                    $.post("index.php?Mode=json_edit_emp", {id: id}, function (data) {
                        $("#id").val(data.emp_id);
                        $("#name").val(data.emp_name);
                        $("#account").val(data.emp_account);
                        $("#salary").val(data.emp_salary);
                        $("#sso").val(data.emp_sso);
                        $("#tel").val(data.emp_tel);
                        $("#mail").val(data.emp_mail);
                        $("#start").val(data.emp_start);
                        $("#born").val(data.emp_born);
                        $("#bank").val(data.emp_bank);
                        $("#nickname").val(data.emp_nickname);
                        $("input[name='status'][value='" + data.emp_status + "']").attr('checked', 'checked');
                        $("input[name='status'][value='" + data.emp_status + "']").parent().attr('class', 'checked');
                        $("input[name='first'][value='" + data.emp_first + "']").attr('checked', 'checked');
                        $("input[name='first'][value='" + data.emp_first + "']").parent().attr('class', 'checked');
                        $("select[name='po'] option[value='" + data.emp_jobs + "']").attr('selected', 'selected');
                        $("select[name='po'] option[value='" + data.emp_jobs + "']").parent().attr('class', 'selected');
                        $(".chzn-results li").each(
                            function () {
                                var aa = $(this).html();
                                $(this).removeClass("result-selected");
                                if (aa == data.jobs_name) {
                                    $(this).addClass("result-selected");
                                    $("div#selectError_chzn a span").html(data.jobs_name);
                                }
                            }
                        );
                    }, "json");
                } else {
                    $("#id").val('');
                    $("#name").val('');
                    $("#account").val('');
                    $("#salary").val('');
                    $("#sso").val('');
                    $("#tel").val('');
                    $("#mail").val('');
                    $("#start").val('');
                    $("#born").val('');
                    $("#bank").val('');
                    $("#nickname").val('');
                    $("input[name='status']").attr('checked', '');
                    $("input[name='first']").attr('checked', '');
                    $("input[name='status']").parent().attr('class', '');
                    $("input[name='first']").parent().attr('class', '');
                    $("select[name='po'] option[value='" + data.emp_jobs + "']").attr('selected', '');
                    $("select[name='po'] option[value='" + data.emp_jobs + "']").parent().attr('class', '');
                    $(".chzn-results li").each(
                        function () {
                            var aa = $(this).html();
                            $(this).removeClass("result-selected");
                            //if(aa==data.jobs_name){$(this).addClass("result-selected");
                            $("div#selectError_chzn a span").html('::กรุณาเลือกค่ะ::');
                        }
                    );
                }
            }



            $("#dis").keyup(function () {
                var dis = 0;
                var disf = $("#dis").val();;
                var money = $("#money").val();
                // console.log(disf);
                // console.log(money);
                var total = parseFloat(money/30) * disf;
        
                if (isNaN(total)) {
                    $("#diss").val('0');
                } else {
                    $("#diss").val(total);
                }
            });


            $("#disn").keyup(function () {
                var dis = 0;
                var total = parseFloat(dis) * 1000;
                if (isNaN(total)) {
                    $("#diss").val('0');
                } else {
                    $("#diss").val(total);
                }
            });




            $("#disnn").keyup(function () {
                var disn = $("#disnn").val();

                // $("#dis").val('0');
                // $("#diss").val('0');
                // var hour = $("#money_hour").val();
                // var tota = parseFloat(disn) / 30;
                // var tol = Math.floor(tota);
                // var total = tol * hour;
                if (isNaN(disn)) {
                    $("#disnn").val('0');
                } else {
                    $("#disnn").val(disn);
                }

            });




            $( "#sso" ).blur(function() {
                this.value = parseFloat(this.value).toFixed(2);
            });

            $("#disnn,#dis,#kuu,#vat").blur(function () {
                var aa = $("#disnn").val();
                var dd = $("#diss").val();
                var kk = $("#kuu").val();
                var art = $("#artt").val();
                var vat = $("#vat").val();
                var rent = $("#coms").val();
                var ee = (parseFloat(aa) + parseFloat(dd) + parseFloat(kk) + parseFloat(art)) + parseFloat(vat)+ parseFloat(rent);
                if (isNaN(ee)) {
                    $("#sumdd").val('กำลังคำนวน');
                } else {
                    $("#sumdd").val(ee);
                }
            });

            $("#disnn,#dis,#ot_day,#ot_hour,#coms,#works,#kuu,#vat").blur(function () {

                var aa = $("#disnn").val();
                var dd = $("#diss").val();
                var kk = $("#kuu").val();
                var art = $("#artt").val();
                var vat = $("#vat").val();
                var rent = $("#coms").val();
                var ee = ((parseFloat(aa) + parseFloat(dd) + parseFloat(kk) + parseFloat(art)) + parseFloat(vat))+ parseFloat(rent);
                if (isNaN(ee)) {
                    $("#sumdd").val('กำลังคำนวน');
                } else {
                    $("#sumdd").val(ee);
                }




                var aa = $("#money").val();
                var bb = $("#ots").val();
                var cc = $("#coms").val();
                var dd = $("#works").val();
                var ee = (parseFloat(aa) + parseFloat(bb) - parseFloat(cc)) + parseFloat(dd);
                if (isNaN(ee)) {
                    $("#sums").val('กำลังคำนวน');
                } else {
                    $("#sums").val(ee);
                }




                var a = $("#sumdd").val();
                var b = $("#sums").val();
                var c = $("#coms").val();
                var total = parseFloat(b) - parseFloat(a) + parseFloat(c);
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
                var ee = (parseFloat(aa) + parseFloat(bb) - parseFloat(cc)) + parseFloat(dd);
                if (isNaN(ee)) {
                    $("#sums").val('กำลังคำนวน');
                } else {
                    $("#sums").val(ee);
                }
            });

            function json_sale_cus(id) {
                if (id != "") {
                    $.post("index.php?Mode=json_edit_emp", {id: id}, function (data) {
                        $('#Sale .modal-body input').val("");
                        $('#Sale #date').val('<?php echo date("Y/m/d");?>');
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
                        $("#emp_id").val(data.emp_id);
                        $("#sale-name").val(data.emp_name);
                        $("#money").val(data.emp_salary);
                        var ggg = $("#money").val() * 0.05;
                        if (ggg > 750) {
                            var gggg = '750';
                        } else {
                            var gggg = $("#money").val() * 0.05;
                        }
                        $('#artt').val(data.emp_sso);
                        // var money_hour = ((data.emp_salary / 30) / 8) * 1.5;
                        var money_hour = ((data.emp_salary / 30) / 8) * 1;
                        $("#money_hour").val(money_hour);
                    }, "json");
                }
            }

            function autocomp() {
                $.post("index.php?Mode=json_autocom", {}, function (data) {

                    var data = $.parseJSON(data);

                    $("#search-box").autocomplete({
                        delay: 0,
                        source: data
                    });

                });
            }

            $(function () {
                $("#date").datepicker({dateFormat: 'yy/mm/dd'});
                $("#born").datepicker({dateFormat: 'yy/mm/dd', changeMonth: true, changeYear: true , yearRange: "c-100:c+10"});
                $("#start").datepicker({dateFormat: 'yy/mm/dd', changeMonth: true, changeYear: true, yearRange: "c-100:c+10"});
            });

            $(function () {
                $('.money_plus,.money_negative').keyup(function () {
                    var num;
                    var total = 0;
                    $('.money_plus').each(function (index) {
                        if ($(this).val() == "") {
                            num = 0;
                        } else {
                            num = $(this).val();
                        }
                        total = parseFloat(total) + parseFloat(num);
                        $('#sum-one').val(getMoney(total));
                    });

                    $('.money_negative').each(function (index) {
                        if ($(this).val() == "") {
                            num = 0;
                        } else {
                            num = $(this).val();
                        }
                        total = parseFloat(total) - parseFloat(num);
                        $('#sum-two').val(getMoney(total));
                    });

                });


            });
        </script>
			