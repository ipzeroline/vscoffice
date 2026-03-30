<?php
require '../model/class.pagelen.php';
$pl = new pagelen();
$pl->Pagelen = 25;
(empty($_GET['search']) ? $where = null : $where = " gender_name like '%" . $_GET['search'] . "%'");
$order = 'gender_id asc';
$tbl = DB_PREFIX . 'gender';
$cnt = $db->countRow($tbl, $where);
$limit = $pl->countRow($cnt);
$row = $db->result($tbl, $where, $order, $limit);
?>
<div class="row-fluid">
    <div class="box span12">
        <div class="box-header well">
            <h2><i class="icon-tag"></i>จัดการคำนำหน้าชื่อ</h2>
        </div>
        <div class="modal hide fade" id="Modal">
            <form class="form-horizontal" method="post" action="?Mode=Admin" target="Alert">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>เพิ่ม/แก้ไขคำนำหน้าชื่อ</h3>
                </div>
                <div class="modal-body">
                    <?php
                    inputText('ชื่อผู้ใช้', 'gender_name', '', '180', '');
                    inputHidden('', 'gender_id');
                    ?>

                </div>
                <div class="modal-footer">
                    <a href="#" class="btn" data-dismiss="modal">ยกเลิก</a>
                    <input type="submit" value="บันทึก" class="btn btn-primary">
                </div>
            </form>
        </div>

        <div class="box-content">
            <div style="text-align:right;padding-bottom:10px;">
                <div id="search" style="float: left;">
                    <form method="get">
                        <input placeholder="กรอกคำนำหน้าชื่อ" style="margin-bottom: 0px;" type="text" name="search"
                               value="<?php echo $_GET['search']; ?>">
                        <button class="btn btn-primary"><i class="icon-search icon-white"></i>ค้นหา</button>
                    </form>
                </div>
                <a class="btn btn-success" onclick="json_edit('');" data-toggle="modal" href="#" data-target="#Modal">
                    <i class="icon-plus-sign icon-white"></i>เพิ่มคำนำหน้าชื่อ
                </a>
            </div>
            <table class="table table-striped table-bordered table-condensed">
                <thead>
                <tr>
                    <th style="text-align:center;">คำนำหน้าชื่อ</th>
                    <th style="text-align:center;">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if ($row) {
                    foreach ($row as $r) {
                        if ($inum++ % 2 == 1) $row = ' style="background-color:#63B8FF"'; else $row = '';
                        echo '<tr' . $row . '>
											<td style="text-align:center;">' . $r->gender_name . '</td>
											<td class="center" style="text-align:center;">
												<a onclick="json_edit(\'' . $r->gender_id . '\');" class="btn btn-info" href="#" data-toggle="modal" data-target="#Modal">
													<i class="icon-edit icon-white"></i>  
													แก้ไข                                            
												</a>
												<a class="btn btn-danger" onclick="return confirm(\'คุณแน่ใจที่ลบรายการนี้\')" href="?Mode=Del&id=' . $r->gender_id . '">
													<i class="icon-trash icon-white"></i> 
													ลบ
												</a>
											</td>
										</tr>';

                    }
                } else {
                    echo '<tr><td colspan="6" style="text-align:center;background-color:#63B8FF;">ไม่มีรายการที่ท่านต้องการค่ะ</td></tr>';
                } ?>
                </tbody>
            </table>
            <?php echo $pl->render('?search=' . $_GET['search'] . '&'); ?>
            <div class="clearfix"></div>
        </div>
    </div><!--box span12-->
</div><!--row-fluid-->
<script>
    function json_edit(id) {
        $("input[name='status']").parent().attr('class', '');
        $("input[name='status']").attr('checked', '');
        if (id != "") {
            $.post("index.php?Mode=json_edit", {id: id}, function (data) {
                $("#gender_id").val(data.gender_id);
                $("#gender_name").val(data.gender_name);
            }, "json");
        } else {
            $("#gender_id").val('');
            $("#gender_name").val('');
        }
    }

    $(function () {
        $("#add_menu").dialog();
    });
</script>