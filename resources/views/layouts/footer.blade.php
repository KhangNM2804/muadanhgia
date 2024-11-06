<!-- Footer -->
<!-- END Footer -->
</div>
<!-- END Page Container -->



<div class="modal fade modalInfoCategory" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideup modal-lg" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title" id="modal_info_title"></h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content" id="modal_info_content">
                </div>
                <div class="block-content block-content-full text-end bg-body">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</div>
@if (!empty($siteSetting['display_noti']['cd_value']))
    @php
        $off_popup_hour = getSetting('off_popup_hour') ?: 3;
    @endphp
    <div class="modal fade modalNotification" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-slideup modal-lg" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Thông báo</h3>
                        <div class="block-options">
                            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"
                                onclick="document.cookie = 'popupShown=true; max-age={{ (int) $off_popup_hour * 60 * 60 }}'">Tắt
                                thông báo ({{ $off_popup_hour }} giờ)</button>
                            <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Đóng</button>
                        </div>
                    </div>
                    <div class="block-content">
                        <div
                            class="font-w600 animated fadeIn bg-body-light border-2x px-3 py-1 mb-3 shadow-sm mw-100 border-left border-success rounded-right">
                            {!! $siteSetting['header_notices']['cd_value'] ?? '' !!}
                        </div>
                    </div>
                    <div class="block-content block-content-full text-end bg-body">
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"
                            onclick="document.cookie = 'popupShown=true; max-age={{ (int) $off_popup_hour * 60 * 60 }}'">Tắt
                            thông báo ({{ $off_popup_hour }} giờ)</button>
                        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif


<script src="{{ asset('assets/js/dashmix.core.min.js') }}"></script>
<script src="{{ asset('assets/js/dashmix.app.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/highlightjs/highlight.pack.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('assets/js/plugins/highlightjs/highlight.pack.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/Holdon/HoldOn.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/be_tables_datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/core/bootstrap.bundle.min.js') }}"></script>
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    @if (session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if (session('error'))
        toastr.error("{{ session('error') }}");
    @endif
</script>
<!-- Page JS Helpers (jQuery Sparkline plugin) -->
<script>
    jQuery(function() {
        Dashmix.helpers('highlightjs');
    });
</script>
<script>
    jQuery(function() {
        Dashmix.helpers('sparkline');
    });
</script>
<script>
    jQuery(function() {
        Dashmix.helpers('select2');
    });
</script>
<script>
    jQuery(function() {
        Dashmix.helpers('notify');
    });
</script>
<script>
    jQuery(function() {
        Dashmix.helpers('ckeditor');
    });
</script>
<script>
    jQuery(function() {
        Dashmix.helpers('datepicker');
    });
</script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        if (document.cookie.indexOf("popupShown=true") == -1) {
            $('.modalNotification').modal('show');
        }

        $(".btnShowInfoCategory").click(function() {
            var category_id = $(this).data('type-id')
            var category_title = $(this).data('type-title')
            Dashmix.layout('header_loader_on');
            $.ajax({
                type: 'GET',
                url: '/category/getDetail/' + category_id,
                success: function(res) {
                    $("#modal_info_content").html(res.result)
                    $("#modal_info_title").html(category_title)
                    $('.modalInfoCategory').modal('show');
                    Dashmix.layout('header_loader_off');
                },
                error: function(xhr, ajaxOptions, thrownError) {}
            });
        })
    });
</script>
@if (App::isLocale('en') || App::isLocale('th'))
    <script src="{{ asset('assets/js/custom_en.js?v=' . time()) }}"></script>
@else
    <script src="{{ asset('assets/js/custom.js?v=' . time()) }}"></script>
@endif
@stack('custom-scripts')
</body>

</html>
