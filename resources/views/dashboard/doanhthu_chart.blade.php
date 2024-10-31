@extends("layouts.master")
@section('content')
    <!-- Main Container -->
    <main id="main-container">
        <div class="content">
            <div class="block block-rounded block-bordered">
                <div class="block-content">
                    <div>
                        <button type="button" id="btn_month" class="btn btn-info mr-1 mb-3">
                            Tháng này
                        </button>
                        <button type="button" id="btn_week" class="btn btn-outline-info mr-1 mb-3">
                            Tuần này
                        </button>
                        <button type="button" id="btn_year" class="btn btn-outline-info mr-1 mb-3">
                            Năm này
                        </button>
                        <button type="button" id="btn_date" class="btn btn-outline-info mr-1 mb-3">
                            Xem theo ngày
                        </button>
                    </div>
                    <div id="date_range" class="row d-none">
                        <div class="col-lg-6 col-xl-6">
                            <div class="form-group">
                                <div class="input-daterange input-group js-datepicker-enabled" data-date-format="mm/dd/yyyy" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                    <input type="text" class="form-control" id="example-daterange1" autocomplete="off" name="example-daterange1" placeholder="From" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                    <div class="input-group-prepend input-group-append">
                                        <span class="input-group-text font-w600 bg-info text-white">
                                            <i class="fa fa-fw fa-arrow-right"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="example-daterange2" autocomplete="off" name="example-daterange2" placeholder="To" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                </div>
                                <button type="button" id="btn_search" class="btn btn-success mr-1 mb-3 mt-1">
                                    Search
                                </button>
                                <button type="button" id="btn_export_deposit" class="btn btn-danger mr-1 mb-3 mt-1">
                                    Tổng nạp - Xuất file excel
                                </button>
                                <button type="button" id="btn_export_buy" class="btn btn-danger mr-1 mb-3 mt-1">
                                    Tổng mua - Xuất file excel
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="chart-container my-5" style="height:500px; width:500px">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>


    </main>
    <!-- END Main Container -->
@endsection
@push('custom-scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {

            $("#example-daterange1").datepicker({
                format: "dd-mm-yyyy",
                autoclose: true
            });
            $("#example-daterange2").datepicker({
                format: "dd-mm-yyyy",
                autoclose: true
            });

            var datasets = [{{ $deposit_month }}, {{ $buy_month }},
                {{ $deposit_month - $buy_month }}
            ];
            var data = {
                labels: [
                    'Tổng nạp',
                    'Tổng chi',
                    'Khách còn dư'
                ],
                datasets: [{
                    data: datasets,
                    backgroundColor: [
                        'rgb(54, 162, 235)',
                        'rgb(255, 99, 132)',
                        'rgb(255, 205, 86)'
                    ],
                    hoverOffset: 4
                }]
            };
            var config = {
                type: 'doughnut',
                data,
                options: {}
            };

            var myChart = new Chart(
                document.getElementById('myChart'),
                config
            );

            $("#btn_week").click(function() {
                $("#btn_month").removeClass('btn-info')
                $("#btn_month").addClass('btn-outline-info')
                $("#btn_year").removeClass('btn-info')
                $("#btn_year").addClass('btn-outline-info')
                $("#btn_date").removeClass('btn-info')
                $("#btn_date").addClass('btn-outline-info')
                $(this).removeClass('btn-outline-info')
                $(this).addClass('btn-info');
                $("#date_range").addClass("d-none")

                $.ajax({
                    type: 'POST',
                    url: '/get_chart',
                    data: {
                        type: "week",
                    },
                    success: function(res) {
                        if(res.status){
                            myChart.data.datasets.forEach((dataset) => {
                                dataset.data = res.data
                            });
                            myChart.update();
                        }else{
                            Swal.fire('Lỗi',res.msg,'error');
                        }
                    },
                });
            })
            $("#btn_month").click(function() {
                $("#btn_week").removeClass('btn-info')
                $("#btn_week").addClass('btn-outline-info')
                $("#btn_year").removeClass('btn-info')
                $("#btn_year").addClass('btn-outline-info')
                $("#btn_date").removeClass('btn-info')
                $("#btn_date").addClass('btn-outline-info')
                $(this).removeClass('btn-outline-info')
                $(this).addClass('btn-info');
                $("#date_range").addClass("d-none")

                $.ajax({
                    type: 'POST',
                    url: '/get_chart',
                    data: {
                        type: "month",
                    },
                    success: function(res) {
                        if(res.status){
                            myChart.data.datasets.forEach((dataset) => {
                                dataset.data = res.data
                            });
                            myChart.update();
                        }else{
                            Swal.fire('Lỗi',res.msg,'error');
                        }
                    },
                });
            })
            $("#btn_year").click(function() {
                $("#btn_week").removeClass('btn-info')
                $("#btn_week").addClass('btn-outline-info')
                $("#btn_month").removeClass('btn-info')
                $("#btn_month").addClass('btn-outline-info')
                $("#btn_date").removeClass('btn-info')
                $("#btn_date").addClass('btn-outline-info')
                $(this).removeClass('btn-outline-info')
                $(this).addClass('btn-info');
                $("#date_range").addClass("d-none")
                $.ajax({
                    type: 'POST',
                    url: '/get_chart',
                    data: {
                        type: "year",
                    },
                    success: function(res) {
                        if(res.status){
                            myChart.data.datasets.forEach((dataset) => {
                                dataset.data = res.data
                            });
                            myChart.update();
                        }else{
                            Swal.fire('Lỗi',res.msg,'error');
                        }
                    },
                });
            })
            

            $("#btn_date").click(function() {
                $("#btn_week").removeClass('btn-info')
                $("#btn_week").addClass('btn-outline-info')
                $("#btn_month").removeClass('btn-info')
                $("#btn_month").addClass('btn-outline-info')
                $("#btn_year").removeClass('btn-info')
                $("#btn_year").addClass('btn-outline-info')
                $(this).removeClass('btn-outline-info')
                $(this).addClass('btn-info');
                $("#date_range").removeClass("d-none")
            })

            $("#btn_search").click(function() {
            
                $.ajax({
                    type: 'POST',
                    url: '/get_chart',
                    data: {
                        type: "date_range",
                        from: $("#example-daterange1").val(),
                        to: $("#example-daterange2").val(),
                    },
                    success: function(res) {
                        if(res.status){
                            myChart.data.datasets.forEach((dataset) => {
                                dataset.data = res.data
                            });
                            myChart.update();
                        }else{
                            Swal.fire('Lỗi',res.msg,'error');
                        }
                    },
                });
            })

            $("#btn_export_deposit").click(function() {
            
                $.ajax({
                    type: 'POST',
                    url: '/export_deposit_excel',
                    data: {
                        from: $("#example-daterange1").val(),
                        to: $("#example-daterange2").val(),
                    },
                    success: function(res, status, xhr) {
                        
                        if(res.status){
                            var url = "/download_export/"+res.filename

                            window.location = url;
                        }else{
                            Swal.fire('Lỗi',res.msg,'error');
                        }
                    },
                });
            })

            $("#btn_export_buy").click(function() {
            
                $.ajax({
                    type: 'POST',
                    url: '/export_buy_excel',
                    data: {
                        from: $("#example-daterange1").val(),
                        to: $("#example-daterange2").val(),
                    },
                    success: function(res, status, xhr) {
                        
                        if(res.status){
                            var url = "/download_export/"+res.filename

                            window.location = url;
                        }else{
                            Swal.fire('Lỗi',res.msg,'error');
                        }
                    },
                });
            })
        })

    </script>
@endpush
