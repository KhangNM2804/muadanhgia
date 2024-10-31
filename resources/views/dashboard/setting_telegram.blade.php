@extends("layouts.master")
@section("content")
<main id="main-container">
    <div class="content">
        <div class="block block-rounded block-themed block-fx-pop">
            <div class="block-header bg-gd-dusk">
                <h3 class="block-title">Thiết lập</h3>
                <div class="block-options"></div>
            </div>
            <div class="block-content">
                <form method="POST" action="{{route('post_setting_telegram')}}" class="form-material m-t-40">
                    @csrf
                    <div class="form-group">
                        <label>TOKEN BOT</label>
                        <div class="input-group">
                            <input type="text" name="token_bot_telegram" id="token_bot_telegram" class="form-control form-control-line" value="{{getSetting('token_bot_telegram')}}" placeholder="Ví dụ: 4534110485:AAHfSbXISTAK7_gD0sK7bJav1fP17ZZi9WM"/>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-dark" id="btn_set_tele_hook">Set webhook</button>
                            </div>
                        </div>
                        <p class="mt-1">Tạo BOT tại đây <a target="_blank" class="badge badge-danger" href="https://t.me/BotFather">@BotFather</a></p>
                    </div>
                    <div class="form-group">
                        <label>URL BOT</label>
                        <input type="text" name="url_bot_telegram" class="form-control form-control-line" value="{{getSetting('url_bot_telegram')}}" placeholder="Ví dụ: https://t.me/ttsellclone_bot"/>
                    </div>
                    <button type="submit" class="btn btn-primary waves-effect waves-light m-r-10 mb-1">Lưu cấu hình</button>
                </form>
            </div>
        </div>

    </div>

</main>
<!-- END Main Container -->
@endsection
@push('custom-scripts')
    <script>
        $(document).ready(function(){
            $("#btn_set_tele_hook").click(function(){
                var token = $("#token_bot_telegram").val();
                if(token == ''){
                    Swal.fire('Lỗi','Vui lòng nhập token bot telegram','error');
                    return false;
                }
                $.ajax({
                    type: 'GET',
                    url: 'https://api.telegram.org/bot'+token+'/setwebhook?url={{route("webhook_telegram")}}',
                    success: function(res) {
                        if(!res.ok){
                            Swal.fire('Lỗi',res.description,'error');
                        }else{
                            Swal.fire('Success','Thành công',res.description);
                        }
                    },
                    error: function(res){
                        Swal.fire('Lỗi',res.description,'error');
                    }
                });
            });
        });
    </script>
@endpush
