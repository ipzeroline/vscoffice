function sql_to_date(date) {
    var mount = ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."];
    date = date.split("-");
    var y = parseFloat(date[0]);
    y = y + 543;
    return date[2] + " " + mount[date[1] - 1] + " " + y;
}

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

function add_detail() {
    for (var i = 1; i <= $('#add-row').val(); i++) {
        $('#des_detail').append('<tr><td><div class="input-append"><input name="qty[]" size="16" type="text"></div></td><td><input type="text" name="des[]" class="long-input"></td><td><div class="input-prepend input-append"><input name="price[]" style="text-align:right;" size="16" type="text"><span class="add-on">.</span><input name="satang[]" value="00" size="16" type="text" maxlength="2"></div></td><td><a onclick="test(this);" class="btn btn-danger remov" href="#"><i class="icon-trash icon-white"></i></a></td></tr>');
    }
}

function json_tranfer(id) {
    $("#alert_dialog_tranfer").hide();
    if (id != "") {
        $('#id_teanfer').val(id);
        $.post("index.php?Mode=json_edit", {id: id}, function (data) {
            $('#bill-tranfer').html('');
            $.each(data, function (key, value) {
                /*var date = value.sale_date.split("-");
                date=date[2]+"/"+date[1]+"/"+date[0];
                    $("#date").val(date);
                    var price = value.sd_price.split(".");*/
                if (value.sale_vat == 1) {
                    $('#total_tranfer_text').html('รวม VAT 7%');
                } else {
                    $('#total_tranfer_text').html('รวม');
                }
                $('#sale_id').val(value.sale_id);
                $('#cus_id').val(value.cus_id);
                $.post("index.php?Mode=json_count_send", {id: id, no: value.sd_no}, function (index) {
                    if (index.qty == null) {
                        var send = 0;
                    } else {
                        var send = index.qty;
                    }
                    var num = parseFloat(value.sd_qty) - parseFloat(send);
                    if (num != 0) {
                        var str = '<label><input type="checkbox" onclick="compute();" value="' + value.sd_no + '" name="tranfer_id[]"></label>';
                    } else {
                        var str = "";
                    }
                    $('#bill-tranfer').append('<tr><td style="text-align:center;">' + str + '</td>' +
                        '<td style="text-align:center;">' + value.sd_qty + '</td>' +
                        '<td style="text-align:center;">' + send + '</td>' +
                        '<td style="text-align:center;"><input style="text-align:center;" class="shot" onkeyup="compute();" type="text" value="' + num + '" name="qty[' + value.sd_no + ']"></td>' +
                        '<td>' + value.sd_name + '<input type="hidden" name="sd_name[' + value.sd_no + ']" id="sd_name[' + value.sd_no + ']" value="' + value.sd_name + '"></td>' +
                        '<td style="text-align:right;width:70px;">' + value.sd_price + '<input type="hidden" name="sd_price[' + value.sd_no + ']" id="sd_price[' + value.sd_no + ']" value="' + value.sd_price + '"></td>' +
                        '<td style="text-align:center;"><input style="text-align:right;" class="shot" onkeyup="compute();" type="text" value="0.00" name="free[' + value.sd_no + ']"></td>' +
                        '<td style="text-align:right;width:70px;" id="sum_' + value.sd_no + '">0.00</td>' +
                        '</tr>');
                    $("input[name='tranfer_id[]']:checkbox").not('[data-no-uniform="true"]').uniform();
                }, "json");
            });
        }, "json");
    }
}

function compute() {
    var total = 0;
    $('#bill-tranfer td[id*="sum_"]').html('0.00');
    $('#bill-tranfer input[type="checkbox"]:checked').each(function (index) {
        var num = $('#bill-tranfer input[name="qty[' + $(this).val() + ']"]').val();
        var price = $('#bill-tranfer input[name="sd_price[' + $(this).val() + ']"]').val();
        var free = $('#bill-tranfer input[name="free[' + $(this).val() + ']"]').val();
        $('#sum_' + $(this).val()).html(getMoney(num.replace(",", "") * price.replace(",", "") - free.replace(",", "")));
        total = parseFloat(total) + parseFloat(num.replace(",", "") * price.replace(",", "") - free.replace(",", ""));
        //alert(parseFloat(num.replace(",","")*price.replace(",","")-free.replace(",","")));
    });
    if ($('#total_tranfer_text').html() != "รวม") {
        total = total + (total * 7 / 100);
    }
    $('#total_tranfer').html(getMoney(total));
}

function json_bill(id) {
    $("#alert_dialog_bill").hide();
    if (id != "") {
        $('#id_teanfer').val(id);
        $.post("index.php?Mode=json_bill", {id: id}, function (data) {
            //alert(data);
            $('#bill-bill').html('');
            var i = 1;
            $.each(data, function (key, value) {
                /*var date = value.sale_date.split("-");
                date=date[2]+"/"+date[1]+"/"+date[0];
                    $("#date").val(date);
                    var price = value.sd_price.split(".");*/
                $('#cus_id_bill').val(value.cus_id);
                $('#sale_id_bil').val(value.sale_id);
                if (value.sale_vat == 0) {
                    var str = '<a style="margin-left:3px;" class="btn btn-success" href="bill-cash.php?id=' + value.cash_id + '" target="_blank"><i class="icon-file icon-white"></i>ใบเสร็จ</a>';
                    var sum = getMoney(value.sum_total);
                    var type = '<label style="display:-webkit-inline-box;" class="label">ปกติ</label>';
                } else {
                    var str = '<a style="margin-left:3px;" class="btn btn-success" href="bill-cash-vat.php?id=' + value.cash_id + '" target="_blank"><i class="icon-file icon-white"></i>ใบเสร็จ</a>';
                    var sum = getMoney(parseFloat(value.sum_total) + (parseFloat(value.sum_total) * 0.07));
                    var type = '<label style="display:-webkit-inline-box;" class="label label-success">บวก VAT7%</label>';
                }
                $('#bill-bill').append('<tr><td style="text-align:center;"><label><input type="checkbox" value="' + value.cash_id + '" name="bill_tf_id[]"></label><input type="hidden" name="cash_id[' + value.tf_id + ']" id="cash_id[' + value.tf_id + ']" value="' + value.cash_id + '"></td>' +
                    '<td style="text-align:center;">' + value.cash_no + '</td>' +
                    '<td style="text-align:center;">' + sql_to_date(value.cash_date) + '</td>' +
                    '<td style="text-align:right;width:150px;">' + sum + '</td>' +
                    '<td style="text-align:center;width:150px;">' + type + '</td>' +
                    '<td>' + str + '</td></tr>');
                $("input[name='bill_tf_id[]']:checkbox").not('[data-no-uniform="true"]').uniform();
                i++;
            });
        }, "json");
    }
}

function json_cash(id) {
    $("#alert_dialog_cash").hide();
    if (id != "") {
        $.post("index.php?Mode=json_cash", {id: id}, function (data) {
            $('#bill-cash').html('');
            $.each(data, function (key, value) {
                $('#sale_id_cash').val(value.sale_id);
                var str = "";
                $.post("index.php?Mode=json_cash_tranfer", {tf_id: value.tf_id}, function (detail) {
                    if (detail.tf_id === undefined) {
                        str = '<label><input type="checkbox" value="' + value.tf_id + '" name="tranfer_id[]"></label>';
                    }
                    if (value.sale_vat == 0) {
                        var vat = "bill-tranfer.php";
                    } else {
                        var vat = "bill-tranfer-vat.php";
                    }
                    $('#name-cash').val(value.tf_name);
                    $('#add-cash').val(value.tf_add);
                    $('#bill-cash').append('<tr><td style="text-align:center;">' + str + '</td>' +
                        '<td style="text-align:center;">' + value.tf_book + '</td>' +
                        '<td style="text-align:center;">' + value.tf_no + '</td>' +
                        '<td style="text-align:center;">' + sql_to_date(value.tf_date) + '</td>' +
                        '<td style="text-align:center;"><a class="btn btn-success" href="' + vat + '?id=' + value.tf_id + '" target="_blank"><i class="icon-zoom-in icon-white"></i>รายละเอียด</a></td></tr>');
                    $("input[name='tranfer_id[]']:checkbox").not('[data-no-uniform="true"]').uniform();
                }, "json");
            });
        }, "json");
    }
}

$(function () {
    $("#date").attr('readonly', 'readonly');
    $("#date").attr('style', 'cursor:pointer;');
    $("#date").datepicker({dateFormat: 'dd/mm/yy'});
    $("#date-tranfer").attr('readonly', 'readonly');
    $("#date-tranfer").attr('style', 'cursor:pointer;');
    $("#date-tranfer").datepicker({dateFormat: 'dd/mm/yy'});
    $("#date-cash").attr('readonly', 'readonly');
    $("#date-cash").attr('style', 'cursor:pointer;');
    $("#date-cash").datepicker({dateFormat: 'dd/mm/yy'});
    $("#date-bill").attr('readonly', 'readonly');
    $("#date-bill").attr('style', 'cursor:pointer;');
    $("#date-bill").datepicker({dateFormat: 'dd/mm/yy'});
});