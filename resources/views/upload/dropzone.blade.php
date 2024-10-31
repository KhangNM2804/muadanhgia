@extends("layouts.master")
@section('content')
    <main id="main-container">
        <div class="content">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="block block-rounded block-themed block-fx-pop">
                        <div class="block-header bg-info">
                            <h3 class="block-title">Upload backup</h3>
                            <div class="block-options">
                            </div>
                        </div>
                        <div class="block-content">
                            <form id="dropzoneForm" class="dropzone" action="{{ route('dropzone.upload') }}">
                                @csrf
                            </form>
                            <button type="button" class="btn btn-success mt-5" id="submit-all">Upload</button>
                            <p class="mt-5">Hiện hệ thống đang hỗ trợ file backup dạng .html với các định dạng tên sau: <b>uid</b>.html, mhcp_backup_<b>uid</b>.html, <b>uid</b>-backup.html, K49Backup_<b>uid</b>.html - Anh em cần thêm định dạng vui lòng liên hệ admin</p>
                            <button type="button" class="btn btn-danger mb-1" id="rename-all">Click để tự động đổi tên file về định dạng uid.html</button>
                        </div>
                    </div>
                    <div class="block block-rounded block-themed block-fx-pop">
                        <div class="block-header bg-info">
                            <h3 class="block-title">File đã upload</h3>
                            <div class="block-options">
                            </div>
                        </div>
                        <div class="block-content">
                            
                            <div id="uploaded_image">
                                
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
    <script src="{{ asset('assets/js/dropzone.js') }}"></script>
    <script type="text/javascript">
        Dropzone.options.dropzoneForm = {
            autoProcessQueue: false,
            acceptedFiles: ".html",

            init: function() {
                var submitButton = document.querySelector("#submit-all");
                myDropzone = this;

                submitButton.addEventListener('click', function() {
                    myDropzone.processQueue();
                });

                this.on("complete", function() {
                    if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
                        var _this = this;
                        _this.removeAllFiles();
                    }
                    load_images();
                });

            }

        };

        load_images();

        function load_images() {
            $("#uploaded_image").html('<div class="spinner-border text-success" role="status"><span class="sr-only">Loading...</span></div>')
            $.ajax({
                url: "{{ route('dropzone.fetch') }}",
                success: function(data) {
                    $('#uploaded_image').html(data);
                }
            })
        }

        $(document).on('click', '.remove_image', function() {
            var name = $(this).attr('id');
            $.ajax({
                url: "{{ route('dropzone.delete') }}",
                data: {
                    name: name
                },
                success: function(data) {
                    load_images();
                }
            })
        });

        $("#rename-all").click(function(){
            $("#rename-all").html('<div class="spinner-border text-light" role="status"><span class="sr-only">Loading...</span></div> Đang xử lý')
            $.ajax({
                url: "{{ route('dropzone.renameall') }}",
                success: function(data) {
                    load_images();
                    $("#rename-all").html("Click để tự động đổi tên file về định dạng uid.html")
                    Swal.fire('Success',"Xong!",'success');

                }
            })
        })

    </script>
@endpush
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/css/dropzone.css') }}">
@endpush
