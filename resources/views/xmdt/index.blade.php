@extends("layouts.master")
@section('content')
    <main id="main-container">
        <!-- Page Content -->
        <div class="content">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="block block-rounded block-bordered">
                        <div class="block-header block-header-default">
                            <h4 class="block-title">Hướng Dẫn</h4>
                            <div class="block-options">
                            </div>
                        </div>
                        <div class="block-content">
                            <div
                                class="font-w600 animated fadeIn bg-body-light border-2x px-3 py-1 mb-2 shadow-sm mw-100 border-left border-success rounded-right">
                                Hình ảnh tạo ra <span class="text-danger">ko có thật</span> và chỉ sử dụng với mục đích gửi
                                <span class="text-danger">Xác Minh Danh Tính (Facebook)</span>. Mọi hành vi ko đúng mục đích
                                chúng tôi hoàn toàn <span class="text-danger">ko chịu trách nhiệm!</span>
                            </div>
                            <div
                                class="font-w600 animated fadeIn bg-body-light border-2x px-3 py-1 mb-2 shadow-sm mw-100 border-left border-success rounded-right">
                                Dịch vụ này hoàn toàn <span class="text-danger">miễn phí</span> nhưng yêu cầu số dư tối
                                thiếu trong tài khoản là <span class="text-danger">100,000 VNĐ</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="block block-rounded block-themed block-fx-pop">
                        <div class="block-header bg-info">
                            <h3 class="block-title">Tạo Ảnh Xác Minh Danh Tính</h3>
                            <div class="block-options">
                            </div>
                        </div>
                        <div class="block-content">
                            <div class="row form-group items-push mb-0">
                                <div class="col-md-4">
                                    <div class="custom-control custom-block custom-control-primary mb-1">
                                        <input type="radio" class="custom-control-input" id="selected-phoi-phoi-fr"
                                            name="selected-phoi" value="phoi-fra" checked="&quot;checked&quot;">
                                        <label class="custom-control-label" for="selected-phoi-phoi-fr"
                                            style="background-image: url({{ asset('assets/xmdt/demo/demo_phoi_fra.png') }}); background-size: cover; height: 300px;"></label>
                                        <span class="custom-block-indicator">
                                            <i class="fa fa-check"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <form>
                                <div class="row">
                                    <div class="offset-2 col-md-8">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label text-right" for="label-uid">UID:</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" id="label-uid" name="uid"
                                                    placeholder="Ví dụ: 100005056473654" value="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label text-right" for="label-photo">Photo:</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" id="label-photo" name="photo"
                                                    placeholder="Ví dụ: https://scontent.fhan2-3.fna.fbcdn.net/v/t1.6435-9/189972657_3966926573362503_7142576583941397357_n.jpg"
                                                    value="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label text-right" for="label-name">Họ Tên:</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" id="label-name" name="name"
                                                    placeholder="Ví dụ: Nguyễn Văn A" value="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label text-right" for="label-dob">Ngày Sinh:</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" id="label-dob" name="dob"
                                                    placeholder="Ví dụ: 21/05/2021" value="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label text-right" for="label-address">Địa
                                                Chỉ:</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" id="label-address" name="address"
                                                    placeholder="Ví dụ: Xuân Khánh, Ninh Kiều, Cần Thơ" value="">
                                            </div>
                                        </div>
    
                                        <div class="form-group row">
                                            <div class="offset-2 col-sm-6">
                                                <button type="button" class="btn btn-outline-info" id="btn-preview"><i
                                                        class="fa fa-fw fa-eye mr-1"></i>Xem Trước</button>
                                                <button type="button" class="btn btn-hero-primary" id="btn-create"><i
                                                        class="fa fa-fw fa-gavel mr-1"></i>Tạo Phôi</button>
                                                <button class="btn btn-light" type="reset">Clear</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            

                            <div class="row d-block text-center mt-4 mb-4" id="preview">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Page Content -->
        </div>
    </main>
    @push('custom-scripts')
        <script>
            $(document).ready(function(){

                $("#btn-preview").click(function(){
                    $("#preview").html('<div class="spinner-grow text-primary" role="status">'+
                      '<span class="sr-only">Loading...</span>' +
                      '</div>' +
                      '<div class="spinner-grow text-secondary" role="status">' +
                        ' <span class="sr-only">Loading...</span>' +
                        '</div>' +
                        '<div class="spinner-grow text-success" role="status">' +
                            '<span class="sr-only">Loading...</span>' +
                            '</div>' +
                            '<div class="spinner-grow text-danger" role="status">' +
                                '<span class="sr-only">Loading...</span>' +
                                '</div>' +
                                '<div class="spinner-grow text-warning" role="status">' +
                                    '<span class="sr-only">Loading...</span>' +
                                    '</div>' +
                                    '<div class="spinner-grow text-info" role="status">' +
                                        '<span class="sr-only">Loading...</span>' +
                                        '</div>' +
                                        
                                            '<div class="spinner-grow text-dark" role="status">' +
                                                '<span class="sr-only">Loading...</span>' +
                                                '</div>');
                    $.ajax({
                        type: 'POST',
                        url: '/preview-phoi-xmdt',
                        data: {
                            phoi: $('input[name="selected-phoi"]:checked').val(),
                            uid:"",
                            photo:$('input[name="photo"]').val(),
                            name: $('input[name="name"]').val(),
                            dob:$('input[name="dob"]').val(),
                            address:$('input[name="address"]').val()
                        },
                        success: function(res) {
                            if(res.status){
                                $("#preview").html('<img width="500px" src="'+res.data+'" />')
                            }else {
                                Swal.fire('Lỗi',res.msg,'error');
                                $("#preview").html("");
                            }
                        }
                    });
                });
                $("#btn-create").click(function(){
                    $("#preview").html('<div class="spinner-grow text-primary" role="status">'+
                      '<span class="sr-only">Loading...</span>' +
                      '</div>' +
                      '<div class="spinner-grow text-secondary" role="status">' +
                        ' <span class="sr-only">Loading...</span>' +
                        '</div>' +
                        '<div class="spinner-grow text-success" role="status">' +
                            '<span class="sr-only">Loading...</span>' +
                            '</div>' +
                            '<div class="spinner-grow text-danger" role="status">' +
                                '<span class="sr-only">Loading...</span>' +
                                '</div>' +
                                '<div class="spinner-grow text-warning" role="status">' +
                                    '<span class="sr-only">Loading...</span>' +
                                    '</div>' +
                                    '<div class="spinner-grow text-info" role="status">' +
                                        '<span class="sr-only">Loading...</span>' +
                                        '</div>' +
                                        
                                            '<div class="spinner-grow text-dark" role="status">' +
                                                '<span class="sr-only">Loading...</span>' +
                                                '</div>');
                    $.ajax({
                        type: 'POST',
                        url: '/preview-phoi-xmdt',
                        data: {
                            phoi: $('input[name="selected-phoi"]:checked').val(),
                            uid:"",
                            photo:$('input[name="photo"]').val(),
                            name: $('input[name="name"]').val(),
                            dob:$('input[name="dob"]').val(),
                            address:$('input[name="address"]').val(),
                            is_download: true
                        },
                        success: function(res) {
                            if(res.status){
                                var i=document.createElement("a");
                                i.href= res.data;
                                i.download="phoi_"+$('input[name="selected-phoi"]:checked').val()+".jpeg";
                                i.click();
                            }else {
                                Swal.fire('Lỗi',res.msg,'error');
                                $("#preview").html("");
                            }
                            $("#preview").html("");
                        }
                    });
                });

                
            });
        </script>
    @endpush
@endsection
