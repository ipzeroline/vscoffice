<?php
require '../model/class.pagelen.php';
$pl = new pagelen();
$pl->Pagelen = 25;

$where = "ref_menu_id='0'";
$order = 'menu_sort asc';
$tbl = DB_PREFIX . 'menu';
$cnt = $db->countRow($tbl, $where);
$limit = $pl->countRow($cnt);
$row = $db->result($tbl, $where, $order, $limit);
?>
<?php
function radio_menu($data, $id, $select = "")
{
    echo '<div class="control-group">
										<label class="control-label">ไอคอน</label>';
    echo '<div class="controls">';
    foreach ($data as $key => $value) {
        echo '<input type="radio" style="margin-left: 0px;" name="' . $id . '" $id="' . $id . '" value="' . $value . '">';
        echo '<i class="' . $value . '"></i>';

    }
    echo '</div>';
    echo '</div>';
}

?>


<div class="row-fluid">
    <div class="box span12">
        <div class="box-header well">
            <h2><i class="icon-th-list"></i>จัดการเมนูระบบ</h2>
        </div>
        <div class="modal hide fade" id="Modal">
            <form class="form-horizontal" method="post" action="?Mode=add_edit" target="Alert">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>เพิ่ม/แก้ไขกลุ่มเมนู</h3>
                </div>
                <div class="modal-body">
                    <?php
                    inputText('ชื่อกลุ่มเมนู', 'menu', '', '180', '');
                    inputText('ลำดับ', 'sort', '', '180', '');
                    inputHidden('', 'id');
                    ?>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn" data-dismiss="modal">ยกเลิก</a>
                    <input type="submit" value="บันทึก" class="btn btn-primary">
                </div>
            </form>
        </div>

        <div class="modal hide fade" id="add_menu">
            <form class="form-horizontal" method="post" action="?Mode=add_menu_sub" target="Alert">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>เพิ่ม/แก้ไขเมนู</h3>
                </div>
                <div class="modal-body">
                    <?php
                    inputText('ชื่อเมนู', 'menu_sub', '', '180', '');
                    inputText('Component', 'component_sub', '', '180', '');
                    inputText('ลำดับ', 'sort_sub', '', '180', '');
                    inputText('ลิงค์', 'link_sub', '', '180', '');
                    $data[] = 'icon-glass';
                    $data[] = 'icon-music';
                    $data[] = 'icon-search';
                    $data[] = 'icon-envelope';
                    $data[] = 'icon-heart';
                    $data[] = 'icon-star';
                    $data[] = 'icon-star-empty';
                    $data[] = 'icon-user';
                    $data[] = 'icon-film';
                    $data[] = 'icon-th-large';
                    $data[] = 'icon-th';
                    $data[] = 'icon-th-list';
                    $data[] = 'icon-ok';
                    $data[] = 'icon-remove';
                    $data[] = 'icon-zoom-in';
                    $data[] = 'icon-zoom-out';
                    $data[] = 'icon-off';
                    $data[] = 'icon-signal';
                    $data[] = 'icon-cog';
                    $data[] = 'icon-trash';
                    $data[] = 'icon-home';
                    $data[] = 'icon-file';
                    $data[] = 'icon-time';
                    $data[] = 'icon-road';
                    $data[] = 'icon-download-alt';
                    $data[] = 'icon-download';
                    $data[] = 'icon-upload';
                    $data[] = 'icon-inbox';
                    $data[] = 'icon-play-circle';
                    $data[] = 'icon-repeat';
                    $data[] = 'icon-refresh';
                    $data[] = 'icon-list-alt';
                    $data[] = 'icon-lock';
                    $data[] = 'icon-flag';
                    $data[] = 'icon-headphones';
                    $data[] = 'icon-volume-off';
                    $data[] = 'icon-volume-down';
                    $data[] = 'icon-volume-up';
                    $data[] = 'icon-qrcode';
                    $data[] = 'icon-barcode';
                    $data[] = 'icon-tag';
                    $data[] = 'icon-tags';
                    $data[] = 'icon-book';
                    $data[] = 'icon-bookmark';
                    $data[] = 'icon-print';
                    $data[] = 'icon-camera';
                    $data[] = 'icon-font';
                    $data[] = 'icon-bold';
                    $data[] = 'icon-italic';
                    $data[] = 'icon-text-height';
                    $data[] = 'icon-text-width';
                    $data[] = 'icon-align-left';
                    $data[] = 'icon-align-center';
                    $data[] = 'icon-align-right';
                    $data[] = 'icon-align-justify';
                    $data[] = 'icon-list';
                    $data[] = 'icon-indent-left';
                    $data[] = 'icon-indent-right';
                    $data[] = 'icon-facetime-video';
                    $data[] = 'icon-picture';
                    $data[] = 'icon-pencil';
                    $data[] = 'icon-map-marker';
                    $data[] = 'icon-adjust';
                    $data[] = 'icon-tint';
                    $data[] = 'icon-edit';
                    $data[] = 'icon-share';
                    $data[] = 'icon-check';
                    $data[] = 'icon-move';
                    $data[] = 'icon-step-backward';
                    $data[] = 'icon-fast-backward';
                    $data[] = 'icon-backward';
                    $data[] = 'icon-play';
                    $data[] = 'icon-pause';
                    $data[] = 'icon-stop';
                    $data[] = 'icon-forward';
                    $data[] = 'icon-fast-forward';
                    $data[] = 'icon-step-forward';
                    $data[] = 'icon-eject';
                    $data[] = 'icon-chevron-left';
                    $data[] = 'icon-chevron-right';
                    $data[] = 'icon-plus-sign';
                    $data[] = 'icon-minus-sign';
                    $data[] = 'icon-remove-sign';
                    $data[] = 'icon-ok-sign';
                    $data[] = 'icon-question-sign';
                    $data[] = 'icon-info-sign';
                    $data[] = 'icon-screenshot';
                    $data[] = 'icon-remove-circle';
                    $data[] = 'icon-ok-circle';
                    $data[] = 'icon-ban-circle';
                    $data[] = 'icon-arrow-left';
                    $data[] = 'icon-arrow-right';
                    $data[] = 'icon-arrow-up';
                    $data[] = 'icon-arrow-down';
                    $data[] = 'icon-share-alt';
                    $data[] = 'icon-resize-full';
                    $data[] = 'icon-resize-small';
                    $data[] = 'icon-plus';
                    $data[] = 'icon-minus';
                    $data[] = 'icon-asterisk';
                    $data[] = 'icon-exclamation-sign';
                    $data[] = 'icon-gift';
                    $data[] = 'icon-leaf';
                    $data[] = 'icon-fire';
                    $data[] = 'icon-eye-open';
                    $data[] = 'icon-eye-close';
                    $data[] = 'icon-warning-sign';
                    $data[] = 'icon-plane';
                    $data[] = 'icon-calendar';
                    $data[] = 'icon-random';
                    $data[] = 'icon-comment';
                    $data[] = 'icon-magnet';
                    $data[] = 'icon-chevron-up';
                    $data[] = 'icon-chevron-down';
                    $data[] = 'icon-retweet';
                    $data[] = 'icon-shopping-cart';
                    $data[] = 'icon-folder-close';
                    $data[] = 'icon-folder-open';
                    $data[] = 'icon-resize-vertical';
                    $data[] = 'icon-resize-horizontal';
                    $data[] = 'icon-hdd';
                    $data[] = 'icon-bullhorn';
                    $data[] = 'icon-bell';
                    $data[] = 'icon-certificate';
                    $data[] = 'icon-thumbs-up';
                    $data[] = 'icon-thumbs-down';
                    $data[] = 'icon-hand-right';
                    $data[] = 'icon-hand-left';
                    $data[] = 'icon-hand-up';
                    $data[] = 'icon-hand-down';
                    $data[] = 'icon-circle-arrow-right';
                    $data[] = 'icon-circle-arrow-left';
                    $data[] = 'icon-circle-arrow-up';
                    $data[] = 'icon-circle-arrow-down';
                    $data[] = 'icon-globe';
                    $data[] = 'icon-wrench';
                    $data[] = 'icon-tasks';
                    $data[] = 'icon-filter';
                    $data[] = 'icon-briefcase';
                    $data[] = 'icon-fullscreen';
                    radio_menu($data, 'icon');
                    inputHidden('', 'id_sub');
                    inputHidden('', 'ref_sub');
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
                <a class="btn btn-success" onclick="json_edit('');" data-toggle="modal" href="#" data-target="#Modal">
                    <i class="icon-plus-sign icon-white"></i>เพิ่มกลุ่มเมนู
                </a>
            </div>
            <table class="table table-striped table-bordered table-condensed">
                <thead>
                <tr>
                    <th>Group</th>
                    <th>Menu</th>
                    <th>Component</th>
                    <th>Sort Group</th>
                    <th>Sort Menu</th>
                    <th>Link</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if ($row) {
                    foreach ($row as $r) {
                        echo '<tr>
											<td>' . $r->menu_name . '</td>
											<td class="center">-</td>
											<td class="center">-</td>
											<td class="center">' . $r->menu_sort . '</td>
											<td class="center">-</td>
											<td class="center">-</td>
											<td class="center">
												<a onclick="json_edit_menu(\'\',\'' . $r->menu_id . '\');" class="btn btn-success" href="#" data-toggle="modal" data-target="#add_menu">
													<i class="icon-plus-sign icon-white"></i>  
													เพิ่มเมนู                                       
												</a>
												<a onclick="json_edit(\'' . $r->menu_id . '\');" class="btn btn-info" href="#" data-toggle="modal" data-target="#Modal">
													<i class="icon-edit icon-white"></i>  
													แก้ไข                                            
												</a>
												<a class="btn btn-danger" href="?Mode=Del&id=' . $r->menu_id . '">
													<i class="icon-trash icon-white"></i> 
													ลบ
												</a>
											</td>
										</tr>';
                        $sub_row = $db->result($tbl, "ref_menu_id='" . $r->menu_id . "'", $order, $limit);
                        if ($sub_row) {

                            foreach ($sub_row as $rr) {

                                echo '<tr>
											<td>-</td>
											<td class="center">' . $rr->menu_name . '</td>
											<td class="center">' . $rr->menu_component . '</td>
											<td class="center">-</td>
											<td class="center">' . $rr->menu_sort . '</td>
											<td class="center">' . $rr->menu_link . '</td>
											<td class="center">
												<a class="btn btn-info" onclick="json_edit_menu(\'' . $rr->menu_id . '\',\'' . $r->menu_id . '\');" href="#" data-toggle="modal" data-target="#add_menu">
													<i class="icon-edit icon-white"></i>  
													แก้ไข                                            
												</a>
												<a class="btn btn-danger" href="?Mode=Del&id=' . $rr->menu_id . '">
													<i class="icon-trash icon-white"></i> 
													ลบ
												</a>
											</td>
										</tr>';

                            }

                        }
                    }
                } ?>
                </tbody>
            </table>
            <?php echo $pl->render('?'); ?>
            <div class="clearfix"></div>
        </div>
    </div><!--box span12-->
    <div>
        <script>
            function json_edit(id) {
                if (id != "") {
                    $.post("index.php?Mode=json_edit", {id: id}, function (data) {

                        $("#menu").val(data.menu_name);
                        $("#id").val(data.menu_id);
                        $("#sort").val(data.menu_sort);
                    }, "json");
                } else {
                    $("#menu").val('');
                    $("#id").val('');
                    $("#sort").val('');
                }
            }

            function json_edit_menu(id, ref) {
                if (id != "") {
                    $.post("index.php?Mode=json_edit", {id: id}, function (data) {
                        $("#menu_sub").val(data.menu_name);
                        $("#id_sub").val(data.menu_id);
                        $("#sort_sub").val(data.menu_sort);
                        $("#component_sub").val(data.menu_component);
                        $("#link_sub").val(data.menu_link);
                        $("#ref_sub").val(data.ref_menu_id);
                        $("input[name='icon']").attr('checked', '');
                        $("input[name='icon']").parent().attr('class', '');
                        $("input[name='icon'][value='" + data.menu_icon + "']").attr('checked', 'checked');
                        $("input[name='icon'][value='" + data.menu_icon + "']").parent().attr('class', 'checked');
                    }, "json");
                } else {
                    $("#menu_sub").val('');
                    $("#id_sub").val('');
                    $("#sort_sub").val('');
                    $("#component_sub").val('');
                    $("#link_sub").val('');
                    $("#ref_sub").val(ref);
                    $("input[name='icon']").attr('checked', '');
                    $("input[name='icon']").parent().attr('class', '');
                }
            }

            $(function () {
                //$( "#add_menu" ).dialog();
            });
        </script>


        <!--<label class="radio">
            <div class="radio" id="uniform-optionsRadios1">
                <span class="checked">
            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1"></span></div>
            Option one is this and that—be sure to include why it s great
          </label>
          <div style="clear:both"></div>'-->