@extends("layouts.master")
@section("content")
<main id="main-container">
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="block block-rounded block-themed block-fx-pop">
                    <div class="block-header bg-info">
                        <h3 class="block-title">Share TKQC</h3>
                    </div>
                    <div class="block-content">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Danh sách clone -->
                                <div class="row push">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Cookie via<span class="help"></span></label>
                                            <input type="text" id="uid" class="form-control form-control-line" value="sb=dcfpYK-Fxu1NrSyLMATO0qWu; wd=2560x1336; datr=dsfpYKGw6I-r-td3R_TMpyZe; locale=tl_PH; c_user=100048946989444; xs=41%3AINPaxDMHyCEAYA%3A2%3A1625933805%3A-1%3A7499; fr=1Cs3sizMWWL7Reyqk.AWV4NbTJkaXMnz6IKCwPBPTiSls.Bg6cd1.7g.AAA.0.0.Bg6cfr.AWVl65_CjK4; spin=r.1004099961_b.trunk_t.1625933814_s.1_v.2_; useragent=TW96aWxsYS81LjAgKE1hY2ludG9zaDsgSW50ZWwgTWFjIE9TIFggMTBfMTVfNykgQXBwbGVXZWJLaXQvNTM3LjM2IChLSFRNTCwgbGlrZSBHZWNrbykgQ2hyb21lLzkxLjAuNDQ3Mi4xMTQgU2FmYXJpLzUzNy4zNg%3D%3D; _uafec=Mozilla%2F5.0%20(Macintosh%3B%20Intel%20Mac%20OS%20X%2010_15_7)%20AppleWebKit%2F537.36%20(KHTML%2C%20like%20Gecko)%20Chrome%2F91.0.4472.114%20Safari%2F537.36;">
                                        </div>
                                        <div class="form-group">
                                            <label>Proxy <span class="help"></span></label>
                                            <input type="text" id="proxy" class="form-control form-control-line" value="user14158:D1M6HoIKUd@116.203.17.251:14158" placeholder="user:pass@ip:port">
                                        </div>
                                        <div class="form-group">
                                            <label>List clone <span class="help"></span></label>
                                            <textarea wrap="off" class="form-control" id="acc" name="example-textarea-input" rows="6" placeholder="<?= __('labels.enter_list_clone') ?>" style="font-size: 14px;">c_user=100070650483696;xs=7:MYBYOP2ozeCkuA:2:1625769841:-1:-1;fr=1eqBHMD16YhN1hjVL.AWU8INM4hZBAgLg70ubL8owKCXQ.Bg50dw..AAA.0.0.Bg50dw.AWVKhLkwhgU;datr=cEfnYBhhfeKQKA6CNOvLPlqN;</textarea>
                                        </div>
                                        <div class="form-group">
                                            <button type="button" id="btn_share_tkqc" class="btn btn-success">Share Ads</button>
                                        </div>
                                    </div>
                                </div>
                                <!-- END Danh sách clone -->
            
                                <!-- Danh sách kết quả -->
                                <div class="row push">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <textarea wrap="off" class="form-control form-control-alt" id="result" name="example-textarea-input" rows="6" placeholder="<?= __('labels.no_result') ?>" style="font-size: 14px;"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <button type="button" class="btn btn-info" onclick="copyToClipboard_live();">Copy</button>
                                        </div>
                                    </div>
                                </div>
                                <!-- END Danh sách kết quả -->
            
            
            
                                <div style="position: sticky; bottom: 0; margin-bottom: 0;">
            
                                    <span class="live badge badge-success" style="display: none;">Live: <span class="" id="live">0</span></span>
                                    <span class="die badge badge-danger" style="display: none;">Die: <span class="" id="die">0</span></span>
            
                                    <!-- Animated -->
                                    <div class="progress push" style="display: none; position: sticky; bottom: 0; margin-bottom: 0;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 1%;" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100">
                                            <span class="font-size-sm font-w600">1%</span>
                                        </div>
                                    </div>
                                    <!-- END Animated -->
            
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- END Main Container -->
@endsection
@push('custom-scripts')
<script>
    $('#btn_share_tkqc').click(function(){
        var $this = $(this);
        var $acc = $('#acc').val().trim();
        var $uid = $('#uid').val().trim();
        var $proxy = $('#proxy').val().trim();
        if(!$uid || !$acc){
            alert('Nhập đầy đủ thông tin');
            return;
        }

        $this.html('Processing...');
        $acc = $acc.split("\n");
        $.each($acc, function(index, item){
            $.ajax({
                url: '/tools/share_tkqc_via/api',
                method: 'post',
                data: {
                    acc: item,
                    proxy: $proxy,
                    uid: $uid
                }
            }).done(function(result){
                var res = JSON.parse(result);
                $('#result').append($uid+'|'+res.status+"\n");
            })
        })
    })
</script>
@endpush