<script src="{{asset('assets/js/dashmix.core.min.js')}}"></script>
        <script src="{{asset('assets/js/dashmix.app.min.js')}}"></script>
        <script>

        $(function() {
            $('.scroll-down').click (function() {
                $('html, body').animate({scrollTop: $('#selling-bm').offset().top }, 'slow');
                return false;
            });
        });

        </script>
    </body>
</html>