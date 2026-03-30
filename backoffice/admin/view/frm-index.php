<?php

require '../model/class.pagelen.php';


$pl = new pagelen();
$pl->Pagelen = 25;
(empty($_GET['search']) ? $where = 'admin_active != "N"' : $where = " admin_active != 'N' and(admin_name like '%" . $_GET['search'] . "%' or admin_surname like '%" . $_GET['search'] . "%' or admin_tel like '%" . $_GET['search'] . "%')");
$order = 'admin_id asc';
$tbl = DB_PREFIX . 'user_admin';
$cnt = $db->countRow($tbl, $where);
$limit = $pl->countRow($cnt);
$row = $db->result($tbl, $where, $order, $limit);
?>
<div class="row-fluid">
    <div class="box span12">
        <div class="box-header well">
            <h2><i class="icon-user"></i>จัดการผู้ดูแล</h2>
        </div>
        <div class="modal hide fade" id="Modal">
            <form class="form-horizontal" method="post" action="?Mode=Admin" target="Alert">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>เพิ่ม/แก้ไขผู้ดูแลระบบ</h3>
                </div>
                <div class="modal-body">
                    <?php
                    inputText('ชื่อผู้ใช้', 'user', '', '180', '');
                    inputPassword('รหัสผ่าน', 'pass', '', '180', '');
                    inputText('ชื่อ', 'name', '', '180', '');
                    inputText('นามสกุล', 'lname', '', '180', '');
                    inputText('E-Mail', 'mail', '', '180', '');
                    inputText('Tel', 'tel', '', '180', '');
                    inputHidden('', 'admin_id');
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
                        <input placeholder="กรอกชื่อ หรือ เบอร์โทรศัพท์" style="margin-bottom: 0px;" type="text"
                               name="search" value="<?php echo $_GET['search']; ?>">
                        <button class="btn btn-primary"><i class="icon-search icon-white"></i>ค้นหา</button>
                    </form>
                </div>
                <a class="btn btn-success" onclick="json_edit('');" data-toggle="modal" href="#" data-target="#Modal">
                    <i class="icon-plus-sign icon-white"></i>เพิ่มผู้ดูแลระบบ
                </a>
            </div>
            <table class="table table-striped table-bordered table-condensed">
                <thead>
                <tr>
                    <th>ชื่อผู้ใช้</th>
                    <th>ชื่อ-สกุล</th>
                    <th>E-mail</th>
                    <th>โทรศัพท์</th>
                    <th>เข้าใช้ล่าสุด</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if ($row) {
                    foreach ($row as $r) {
                        if ($inum++ % 2 == 1) $row = ' style="background-color:#63B8FF"'; else $row = '';
                        echo '<tr' . $row . '>
											<td>' . $r->admin_username . '</td>
											<td>' . $r->admin_name . " " . $r->admin_surname . '</td>
											<td>' . $r->admin_email . '</td>
											<td>' . $r->admin_tel . '</td>
											<td class="center">' . date('d/m/Y H:i:s', $r->admin_date_login) . '</td>
											<td class="center">
												<a onclick="json_edit(\'' . $r->admin_id . '\');" class="btn btn-info" href="#" data-toggle="modal" data-target="#Modal">
													<i class="icon-edit icon-white"></i>  
													แก้ไข                                            
												</a>
												<a class="btn btn-danger" onclick="return confirm(\'คุณแน่ใจที่ลบรายการนี้\')" href="?Mode=Del&id=' . $r->admin_id . '">
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
                $("#admin_id").val(data.admin_id);
                $("#user").val(data.admin_username);
                $("#name").val(data.admin_name);
                $("#lname").val(data.admin_surname);
                $("#mail").val(data.admin_email);
                $("#tel").val(data.admin_tel);
                $("input[name='status'][value='" + data.admin_status + "']").parent().attr('class', 'checked');
                $("input[name='status'][value='" + data.admin_status + "']").attr('checked', 'checked');
            }, "json");
        } else {
            $("#admin_id").val('');
            $("#user").val('');
            $("#name").val('');
            $("#lname").val('');
            $("#mail").val('');
            $("#tel").val('');
        }
    }

    $(function () {
        $("#add_menu").dialog();
    });
</script>