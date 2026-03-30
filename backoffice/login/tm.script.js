$("#login").submit(function () {
    $.post('init.php?Mode=Login', $("#login").serialize(), function (data) {

        if (data.status == 'COMPLETE') {

            window.location.href = "../index";

        } else {
            $('.alert').html('ชื่อผู้ใช้หรือรหัสผ่านผิดพลาด!!');
            $('.alert').attr('class', 'alert alert-error');
        }


    });
});