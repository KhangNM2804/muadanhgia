
function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}
$(document).ready(function () {
    $(".buy-btn").click(function (t) {
        var n = $(this).data("country"),
            e = $(this).data("type-id"),
            i = $(this).data("name"),
            a = $(this).data("price"),
            r = $(this).data("available"),
            l = r < 100 ? r : 100,
            c = "";
        Swal.fire({
            title: "&nbsp;&nbsp;" + i,
            text: "quantity:",
            input: "number",
            inputValue: l,
            inputValidator: function (t) {
                return t < 1 ? "Buy the minimum quantity is 1" : t > r ? "Buy the maximum quantity is  " + r : void 0;
            },
            inputPlaceholder: "quantity",
            inputAttributes: { maxlength: 5 },
            onOpen: function () {
                Swal.getInput().oninput = function (t) {
                    var n = t.target.value < 0 || t.target.value > r ? "del" : "span";
                    Swal.update({ footer: "Total amount:&nbsp;&nbsp;&nbsp;<" + n + ' class="font-weight-bold">' + addCommas((t.target.value || 0) * a) + "đ</" + n + ">" });
                };
            },
            confirmButtonText: '<i class="fa fa-credit-card"></i> Buy',
            cancelButtonText: "Cancel",
            showCancelButton: !0,
            showLoaderOnConfirm: !0,
            footer: 'Total amount:&nbsp;&nbsp;&nbsp;<span class="font-weight-bold">' + addCommas(l * a) + "đ</span>",
            preConfirm: function (t) {
                // return fetchPost("/mua-via-clone", { type_id: e, quantity: t }, function (t, n) {
                //     if (t) return Swal.showValidationMessage("Mua thất bại: " + t.message);
                    // c = n.order_id;
                // });
                return $.ajax({
                    type: 'POST',
                    url: '/category/buy',
                    data: {
                        type_id: e,
                        quantity: t
                    },
                    success: function(res) {
                        if(!res.status){
                            Swal.showValidationMessage("Order fail: " + res.msg)
                        }else{
                            c = res.order_id;
                        }
                    },
                });
            },
            allowOutsideClick: function () {
                return !Swal.isLoading();
            },
        }).then(function (t) {
            t.value &&
                c &&
                Swal.mixin({
                    toast: !0,
                    position: "center",
                    showConfirmButton: !1,
                    timer: 2e4,
                    timerProgressBar: !0,
                    onOpen: function (t) {
                        t.addEventListener("mouseenter", function () {
                            Swal.stopTimer(), (window.location.href = "/don-hang/" + c);
                        }),
                            t.addEventListener("mouseleave", Swal.resumeTimer);
                    },
                }).fire({ icon: "success", html: '<div class="pl-2 text-left">Order completed&nbsp;<strong>#' + (c || "") + '</strong><br><em class="text-muted font-size-sm">Click view detail</em></div>' });
        });
    });

    $("#btn_import").click(function(){
        var insert = 0, update = 0, die = 0;
        var list_id = $('#list-id').val();
		var loai = $('#select_type').val();
        if (list_id == '') {
            Swal.fire("", "Vui Lòng Nhập list ", "error");
            return false;
        }
        if (loai == '') {
            Swal.fire("", "Vui Lòng Chọn loại ", "error");
            return false;
        }
		var hotmail = list_id.split('\n');
		var c = hotmail.length;
        $('#check-count-total').text(0);
        $('#die').text(0);
        $('#insert').text(0);
        $('#update').text(0);
        $("#btn_import").html('Đang import...')
        var count = 1;
        HoldOn.open({
            theme:"sk-circle",
            message:'Đang import, vui lòng chờ đợi. Nếu import số lượng lớn có thể mất khá nhiều thời gian',
        });
        $.ajax({
            type: 'POST',
            url: '/category/ajax_import',
            data: {
                list_id: list_id,
                loai:loai
            },
            success: function(res) {
                $('#check-count-total').text(res.total);
                $('#insert').text(res.insert);
                $('#update').text(res.update);
                $('#list-insert').val(res.list_insert);
                $('#list-update').val(res.list_update);
                $("#btn_import").html('<i class="fa fa-rocket mr-1"></i> Import')
                HoldOn.close();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                HoldOn.close();
                $("#btn_import").html('<i class="fa fa-rocket mr-1"></i> Import')
                Swal.fire({ title: 'Lỗi hệ thống: ' + xhr.responseJSON.message, icon: "error" });
            }
        });
    });
    $(".btn-copy").click(function(){
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(this).data("clipboard-text")).select();
        document.execCommand("copy");
        $temp.remove();
        Dashmix.helpers('notify', {type: 'success', icon: 'fa fa-check mr-1', message: 'Copied '+$(this).data("clipboard-text")});
    }) ;

    $("#btn-submit").click(function (t) {
        var e = function (t) {
            $("#btn-submit, #list-id").prop("disabled", t);
        };
        e(!0);
        var n = $("#list-id").val();
        if (!n) return e(!1), Swal.fire({ title: "Please enter list Business ID", icon: "error" });
        var r = /([0-9]{15,16})/i,
            i = n
                .trim()
                .split("\n")
                .filter(function (t) {
                    return r.exec(t);
                });
        Swal.fire({
            title: "You want to check " + i.length + " link limit?",
            icon: "question",
            showCancelButton: !0,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes",
            cancelButtonText: "Cancel",
        }).then(function (t) {
            if (!t.value) return e(!1);
            $("#check-count-total").text(i.length), $("#check-count-error, #check-count-50, #check-count-350, #check-count-live").text("0"), $("#list-bm-50, #list-bm-350, #list-bm-error, #list-bm-red").val("");
            !(function t(n) {
                if (n >= i.length) return e(!1), void Swal.fire({ title: "Completed", text: "Check done!", icon: "success" });
                var c = r.exec(i[n]),
                    o = c ? c[0] : "";
                if (!o) return t(n + 1);
                var u = "";
                var l = i[n].match(/https:\/\/fb.me\/[a-zA-Z0-9]+/);
                l && (u = l[0] + "|");
                $.ajax({
                    type: 'POST',
                    url: '/apicheckbm',
                    data: {
                        bmid: o,
                    },
                    success: function(res) {
                        if(res.error){
                            $("#check-count-error").text(parseInt($("#check-count-error").text()) + 1)
                            $("#list-bm-error").val($("#list-bm-error").val() + i[n] + "\n")
                        }else{
                            if(res.status){
                                if(res.limit == 50){
                                    $("#check-count-50").text(parseInt($("#check-count-50").text()) + 1), $("#list-bm-50").val($("#list-bm-50").val() + i[n] + "|" + res.name + "|50$\n");
                                }
                                if(res.limit == 350){
                                    $("#check-count-350").text(parseInt($("#check-count-350").text()) + 1), $("#list-bm-350").val($("#list-bm-350").val() + i[n] + "|" + res.name + "|350$\n");
                                }
                                $("#check-count-live").text(parseInt($("#check-count-live").text()) + 1), $("#list-bm-red").val($("#list-bm-red").val() + i[n] +"|" + res.name + "|"+res.limit+"$\n");
                            }else{
                                $("#check-count-error").text(parseInt($("#check-count-error").text()) + 1)
                                $("#list-bm-error").val($("#list-bm-error").val() + i[n] + "\n")
                            }
                        }
                        t(n + 1);
                    }
                });
            })(0);
        });
    });
    if (jQuery('#js-ckeditor2:not(.js-ckeditor-enabled)').length) {
        CKEDITOR.replace('js-ckeditor2');
    }
    if (jQuery('#js-ckeditor3:not(.js-ckeditor-enabled)').length) {
        CKEDITOR.replace('js-ckeditor3');
    }

    if($('.js-dataTable-full2').length){
        $('.js-dataTable-full2').dataTable({
            ordering: false,
            pageLength: 5,
            lengthMenu: [[5, 10, 20], [5, 10, 20]],
            autoWidth: false
        });
    }

    if($('#close_ticket').length){
        $("#close_ticket").click(function(){
            var ticket_id = $(this).data('ticket_id');
            HoldOn.open({
                theme:"sk-circle",
            });
            $.ajax({
                type: 'POST',
                url: '/tickets/close',
                data: {
                    ticket_id: ticket_id,
                },
                success: function(res) {
                    location.reload();
                },
            });
        });
    }
});
