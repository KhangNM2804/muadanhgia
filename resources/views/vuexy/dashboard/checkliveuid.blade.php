@extends("layouts.master")
@section("content")
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Danh sách clone -->
                            <div class="row push">
                                <div class="col-12">
                                    <div class="form-group">
                                        <textarea wrap="off" class="form-control" id="listclone" name="example-textarea-input" rows="6" placeholder="Nhập list clone vào đây" style="font-size: 14px;"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="button" id="checkliveuid" class="btn btn-success" onclick="check_live_uid();">Check Live UID</button>
                                    </div>
                                </div>
                            </div>
                            <!-- END Danh sách clone -->
        
                            <!-- Danh sách kết quả -->
                            <div class="row push">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <textarea wrap="off" class="form-control form-control-alt" id="listclonelive" name="example-textarea-input" rows="6" placeholder="Không có dữ liệu" style="font-size: 14px;"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-info" onclick="copyToClipboard_live();">Copy list LIVE</button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <textarea wrap="off" class="form-control form-control-alt is-invalid" id="listclonedie" name="example-textarea-input" rows="6" placeholder="Không có dữ liệu" style="font-size: 14px;"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-info" onclick="copyToClipboard_die();">Copy List DIE</button>
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
    <!-- END: Content-->
@endsection
@push('custom-scripts')
<script>
    function copyToClipboard_live() {

        /* Get the text field */
        var copyText = document.getElementById("listclonelive");

        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /*For mobile devices*/

        /* Copy the text inside the text field */
        document.execCommand("copy");

        //Thong bao
        Dashmix.helpers('notify', {
            from: 'top',
            align: 'right',
            type: 'success',
            icon: 'fa fa-check mr-1',
            message: 'Đã copy!'
        });
        }

        function copyToClipboard_die() {

        /* Get the text field */
        var copyText = document.getElementById("listclonedie");

        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /*For mobile devices*/

        /* Copy the text inside the text field */
        document.execCommand("copy");

        //Thong bao
        Dashmix.helpers('notify', {
            from: 'bottom',
            align: 'left',
            type: 'success',
            icon: 'fa fa-check mr-1',
            message: 'Đã copy!'
        });
        }
    var listclone, arrclone, n, c;
	var live, die;

	function check_live_uid() {
		$('#checkliveuid').prop('disabled', true);
		$('#listclonelive').val("");
		$('#listclonedie').val("");
		$('.progress').show();
		n = 0;
		live = 0;
		die = 0;
		listclone = $('#listclone').val().trim();
		arrclone = listclone.split('\n');
		c = arrclone.length;
		for (var i = 0; i < c; i++) {
			check_live_uid_progress();
		}
	}

	function check_live_uid_progress() {
		n = n + 1;
		var m = n - 1;
		var uid = get_uid(arrclone[m]);

		var url = 'https://graph.facebook.com/' + uid + '/picture?type=normal';
		fetch(url).then((response) => {
			if (/100x100/.test(response.url)) {
				$('.live').show();
				live++;
				$('#live').html(live);
				$('#listclonelive').val($('#listclonelive').val() + arrclone[m] + '\n');
			} else {
				$('.die').show();
				die++;
				$('#die').html(die);
				$('#listclonedie').val($('#listclonedie').val() + arrclone[m] + '\n');
			}
			var r = $(".progress-bar");
			var t = Math.floor(n * 100 / c);
			r.css("width", t + "%"), jQuery("span", r).html(t + "%");
			if (n < c) {
				check_live_uid_progress();
			} else {
				$('#checkliveuid').prop('disabled', false);
				return false;
			}
		});


	}

	function get_uid(data) {
		var clone = data.split("|");
		return clone[0];
	}
</script>
@endpush