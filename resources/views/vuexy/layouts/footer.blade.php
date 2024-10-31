<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<!-- BEGIN: Footer-->
<footer class="footer footer-static footer-light">
    <p class="clearfix mb-0"><span class="float-md-left d-block d-md-inline-block mt-25">COPYRIGHT &copy; 2021<a class="ml-25" href="https://thanhtrungit.net" target="_blank">thanhtrungit.net</a><span class="d-none d-sm-inline-block">, All rights Reserved</span></span><span class="float-md-right d-none d-md-block">Mã nguồn được phát triển bởi <i data-feather="heart"></i> <a class="ml-25" href="https://fb.com/thanhtrtungit97" target="_blank">Thành Trung</a></span></p>
</footer>
<button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
<!-- END: Footer-->


<!-- BEGIN: Vendor JS-->
<script src="{{ asset('vuexy/app-assets/vendors/js/vendors.min.js') }}"></script>
<script src="{{ asset('vuexy/app-assets/vendors/js/charts/apexcharts.min.js') }}"></script>
<script src="{{ asset('vuexy/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
<script src="{{ asset('vuexy/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('vuexy/app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ asset('vuexy/app-assets/js/core/app-menu.js') }}"></script>
<script src="{{ asset('vuexy/app-assets/js/core/app.js') }}"></script>
<script src="{{ asset('vuexy/app-assets/js/scripts/extensions/ext-component-sweet-alerts.js') }}"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="{{ asset('vuexy/app-assets/js/scripts/forms/form-select2.js') }}"></script>
<script src="{{asset('assets/js/plugins/ckeditor/ckeditor.js')}}"></script>

<!-- END: Page JS-->

<script>
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })
</script>
<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            }
        });
    });
</script>
<script src="{{asset('assets/js/custom.js?v='.time())}}"></script>
@stack('custom-scripts')
</body>
<!-- END: Body-->

</html>
