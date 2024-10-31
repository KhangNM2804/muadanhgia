@extends("layouts.master")
@section("content")
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">

            <div class="card">
                <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <div class="block block-rounded block-themed block-fx-pop">
                                    <div class="block-content">
                                        <form id="dropzoneForm" class="dropzone" action="{{ route('dropzone.upload') }}">
                                            @csrf
                                        </form>
                                        <button type="button" class="btn btn-success mt-5" id="submit-all">Upload</button>
                                        <p class="mt-5">Hiện hệ thống đang hỗ trợ file backup dạng .html với các định dạng tên sau: <b>uid</b>.html, mhcp_backup_<b>uid</b>.html, <b>uid</b>-backup.html, K49Backup_<b>uid</b>.html - Anh em cần thêm định dạng vui lòng liên hệ admin</p>
                                    </div>
                                </div>
                                <div class="block block-rounded block-themed block-fx-pop">
                                    <div class="block-content">
                                        
                                        <div id="uploaded_image">
                                            
                                        </div>
                                    </div>
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
    <script src="{{ asset('vuexy/app-assets/vendors/js/extensions/dropzone.min.js') }}"></script>
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

    </script>
@endpush
@push('style')
    <link rel="stylesheet" href="{{ asset('vuexy/app-assets/vendors/css/file-uploaders/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vuexy/app-assets/css/plugins/forms/form-file-uploader.css') }}">
@endpush