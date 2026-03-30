<?php
include('function.php');
include('header.php');
?>
<div>
    <ul class="breadcrumb">
        <li>
            <a href="../index">หน้าแรก</a> <span class="divider">/</span>
        </li>
        <li>
            <a href="#" id="Dash"></a>
        </li>
    </ul>
</div>


<?php
if (!empty($_GET['frm'])) {
    $_file = 'view/frm-' . $_GET['frm'] . ".php";
} else {
    $_file = "view/frm-index.php";
}

if (file_exists($_file)) {
    include $_file;
}
?>
</div>
<?php include('footer.php'); ?>
<script>
    setTimeout(function () {
        var key = $('.box-header').text();
        $('#Dash').html(key);
    }, 100);
</script>
