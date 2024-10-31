$(document).ready(function(){
    $("#btn_get_otp").click(function(){
        $.ajax({
            type: 'POST',
            url: '/momo/get_otp',
            data: {
                username: $("#username").val(),
            },
            success: function(res) {
                if(!res.status){
                    Dashmix.helpers('notify', {from: 'bottom', align: 'right',type: 'danger', icon: 'fa fa-info-circle mr-1', message: res.msg});
                }else{
                    Dashmix.helpers('notify', {from: 'bottom', align: 'right',type: 'success', icon: 'fa fa-info-circle mr-1', message: res.msg});
                    $("#otp").prop( "disabled", false );
                    $("#otp").val("");
                    $("#password").val("");
                    $("#btn_check_otp").prop( "disabled", false );
                }
            },
        });
    })
    $("#btn_check_otp").click(function(){
        $.ajax({
            type: 'POST',
            url: '/momo/check_otp',
            data: {
                username: $("#username").val(),
                otp: $("#otp").val()
            },
            success: function(res) {
                if(!res.status){
                    Dashmix.helpers('notify', {from: 'bottom', align: 'right',type: 'danger', icon: 'fa fa-info-circle mr-1', message: res.msg});
                }else{
                    Dashmix.helpers('notify', {from: 'bottom', align: 'right',type: 'success', icon: 'fa fa-info-circle mr-1', message: res.msg});
                    $("#password").prop( "disabled", false );
                    $("#btn_login").prop( "disabled", false );
                }
            },
        });
    })
    
    $("#btn_login").click(function(){
        $.ajax({
            type: 'POST',
            url: '/momo/login',
            data: {
                username: $("#username").val(),
                password: $("#password").val()
            },
            success: function(res) {
                if(!res.status){
                    Dashmix.helpers('notify', {from: 'bottom', align: 'right',type: 'danger', icon: 'fa fa-info-circle mr-1', message: res.msg});
                }else{
                    Dashmix.helpers('notify', {from: 'bottom', align: 'right',type: 'success', icon: 'fa fa-info-circle mr-1', message: res.msg});
                    location.href = '/momo';
                }
            },
        });
    })
    $("#btn_relogin").click(function(){
        $.ajax({
            type: 'POST',
            url: '/momo/relogin',
            data: {
                username: $(this).data('username')
            },
            success: function(res) {
                if(!res.status){
                    Dashmix.helpers('notify', {from: 'bottom', align: 'right',type: 'danger', icon: 'fa fa-info-circle mr-1', message: res.msg});
                }else{
                    Dashmix.helpers('notify', {from: 'bottom', align: 'right',type: 'success', icon: 'fa fa-info-circle mr-1', message: res.msg});
                    location.reload();
                }
            },
        });
    })
    
    $(".set-auto").click(function(){

        $.ajax({
            type: 'POST',
            url: '/momo/set_auto',
            data: {
                id: $(this).data('idmomo'),
                checked: $(this).is(":checked")
            },
            success: function(res) {
                if(res.checked === "true"){
                    
                    $(".set-auto").map(function(index,el){
                        if($(el).data('idmomo') != res.id){
                            $(el).prop("checked", false);
                        }
                        
                    });
                }
                Dashmix.helpers('notify', {from: 'bottom', align: 'right',type: 'success', icon: 'fa fa-info-circle mr-1', message: res.msg});
            },
        });
    })
    
    $("#btn_info").click(function(){

        $.ajax({
            type: 'POST',
            url: '/momo/getinfo',
            data: {
                username: $("#sdt_to").val()
            },
            success: function(res) {
                if(!res.status){
                    Dashmix.helpers('notify', {from: 'bottom', align: 'right',type: 'danger', icon: 'fa fa-info-circle mr-1', message: res.msg});
                   
                    
                }else{
                     $("#name_to").val(res.name);
                    $("#amount").prop('disabled', false);
                    $("#memo").prop('disabled', false);
                    $("#btn_pay").prop('disabled', false);
                    // Dashmix.helpers('notify', {from: 'bottom', align: 'right',type: 'success', icon: 'fa fa-info-circle mr-1', message: res.msg});
                    Swal.fire('Success',res.msg,'success');
                }
            },
        });
    })
    
    $("#btn_pay").click(function(){

        $.ajax({
            type: 'POST',
            url: '/momo/init_pay',
            data: {
                idmomo: $("#id_from").val(),
                sdt_to: $("#sdt_to").val(),
                amount: $("#amount").val(),
                memo: $("#memo").val()
            },
            success: function(res) {
                if(!res.status){
                    Dashmix.helpers('notify', {from: 'bottom', align: 'right',type: 'danger', icon: 'fa fa-info-circle mr-1', message: res.msg});
                }else{
                    Swal.fire('Success',res.msg,'success');
                    $("#id_from").val()
                    $("#sdt_to").val("")
                    $("#amount").val("")
                    $("#memo").val("")
                    $("#amount").prop('disabled',true);
                    $("#memo").prop('disabled', true);
                    $("#btn_pay").prop('disabled', true);
                }
            },
        });
    })
});