@extends("layouts.master")
@section('content')
    <main id="main-container">

        <!-- Page Content -->
        <div class="content content-full ">
            <div class="block block-rounded block-bordered">
                <div class="block-content">
                    <!-- Connections -->
                    <h2 class="content-heading pt-0 ">
                        <i class="fa fa-fw fa-share-alt text-danger mr-1"></i> <?= __('labels.setting_api') ?>
                    </h2>
                    <div class="row push">
                        <div class="col-lg-4">
                            <p class="text-muted">
                                <?= __('labels.connect_with_api') ?>
                            </p>
                        </div>
                        <div class="col-lg-8 col-xl-7">
                            <div class="form-group row">
                                <div class="col-sm-10 col-md-8 col-xl-8">
                                    <a class="btn btn-block btn-alt-success bg-transparent d-flex align-items-center justify-content-between"
                                        href="javascript:void(0)">
                                        <span>
                                            <i class="fa fa-key mr-1"></i> <span
                                                id="show_api_key">{{ $user->api_key }}</span>
                                        </span>
                                        <i class="fa fa-fw fa-check mr-1"></i>
                                    </a>
                                </div>
                                <div class="col-sm-12 col-md-4 col-xl-4 mt-1 d-md-flex align-items-md-center font-size-sm">
                                    <a class="btn btn-sm btn-success btn-rounded" href="javascript:void(0)"
                                        id="change_apikey">
                                        <i class="si si-reload mr-1"></i> <?= __('labels.change_api_key') ?>
                                    </a>
                                </div>
                                <div class="col-sm-12 col-md-4 col-xl-4 mt-1 d-md-flex align-items-md-center font-size-sm">
                                    <a class="btn btn-sm btn-success btn-rounded" href="javascript:void(0)"
                                        id="copy_apikey"><i class="fa fa-copy mr-1"></i> Copy</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block block-rounded block-bordered">
                <div class="block-content">
                    <!-- Connections -->
                    <h2 class="content-heading pt-0">
                        <i class="fa fa-fw fa-share-alt text-danger mr-1"></i> <?= __('labels.api_balance') ?>
                    </h2>
                    <p class="">API URL: {{ route('api.balance') }}</p>
                    <p class="">Method: <span class="badge badge-danger">POST</span></p>
                    <p class="">Body:</p>
<pre><code class="json">
    {
        "api_key" : "API KEY"
    }
    </code></pre>
                    <p class="">Response:</p>
<pre><code class="json">
    {
        "status": true,
        "balance": 100000
    }
    </code></pre>
                </div>
            </div>
            <div class="block block-rounded block-bordered">
                <div class="block-content">
                    <!-- Connections -->
                    <h2 class="content-heading pt-0">
                        <i class="fa fa-fw fa-share-alt text-danger mr-1"></i> <?= __('labels.api_get_category') ?>
                    </h2>
                    <p class="">API URL: {{ route('api.categories') }}</p>
                    <p class="">Method: <span class="badge badge-primary">GET</span></p>
                    
                    <p class="">Response:</p>
<pre><code class="json">
    {
        "data": [
            {
                "id": 1,
                "name": "Via",
                "icon": null
            },
            {
                "id": 18,
                "name": "Via phi",
                "icon": "{{ asset('assets/media/country/187-philippines.png')}}"
            }
        ]
    }
    </code></pre>
                </div>
            </div>
            <div class="block block-rounded block-bordered">
                <div class="block-content">
                    <!-- Connections -->
                    <h2 class="content-heading pt-0">
                        <i class="fa fa-fw fa-share-alt text-danger mr-1"></i> <?= __('labels.api_get_product') ?>
                    </h2>
                    <p class="">API URL: {{ route('api.product', ['id' => 18]) }}</p>
                    <p class="">Method: <span class="badge badge-primary">GET</span></p>
                    
                    <p class="">Response:</p>
<pre><code class="json">
    {
        "data": [
            {
                "id_product": 2,
                "name": "Via limit 350$ cổ",
                "desc": "Ngoại, Trắng, Limit 50$, Chưa VeryMai",
                "price": 25000,
                "quantity": 0
            },
            {
                "id_product": 5,
                "name": "VIA NGOẠI - LIMIT 5M8 -350$",
                "desc": "Bao login HC Quảng Cáo, Limit ẩn",
                "price": 150000,
                "quantity": 0
            }
        ]
    }
    </code></pre>
                </div>
            </div>
            <div class="block block-rounded block-bordered">
                <div class="block-content">
                    <!-- Connections -->
                    <h2 class="content-heading pt-0">
                        <i class="fa fa-fw fa-share-alt text-danger mr-1"></i> Api order
                    </h2>
                    <p class="">API URL: {{ route('api.buy') }}</p>
                    <p class="">Method: <span class="badge badge-danger">POST</span></p>
                    <p class="">Body:</p>
<pre><code class="json">
    {
        "api_key" : "API KEY",
        "id_product" : 1,
        "quantity" : 10
    }
    </code></pre>
                    <p class="">Response:</p>
<pre><code class="json">
    {
        "status": true,
        "order_id": 20
    }
</code></pre>
<!-- Connections -->
<h2 class="content-heading pt-0">
    <i class="fa fa-fw fa-share-alt text-muted mr-1"></i> <?= __('labels.code_demo_php') ?>
</h2>
<pre><code class="php">
    $dataPost = [
        "api_key" => "API_KEY",
        "id_product" => 1,
        "quantity" => 10,
    ];
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "{{ route('api.buy') }}",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $dataPost,
    ));
    
    $response = curl_exec($curl);
</code>
    
</pre>
                </div>
            </div>
            <div class="block block-rounded block-bordered">
                <div class="block-content">
                    <!-- Connections -->
                    <h2 class="content-heading pt-0">
                        <i class="fa fa-fw fa-share-alt text-danger mr-1"></i> <?= __('labels.api_get_orders') ?>
                    </h2>
                    <p class="">API URL: {{ route('api.list_order') }}</p>
                    <p class="">Method: <span class="badge badge-danger">POST</span></p>
                    <p class="">Body:</p>
<pre><code class="json">
    {
        "api_key" : "API KEY"
    }
    </code></pre>
                    <p class="">Response:</p>
<pre><code class="json">

    </code></pre>
                </div>
            </div>
            <div class="block block-rounded block-bordered">
                <div class="block-content">
                    <!-- Connections -->
                    <h2 class="content-heading pt-0">
                        <i class="fa fa-fw fa-share-alt text-danger mr-1"></i> <?= __('labels.api_get_order_detail') ?>
                    </h2>
                    <p class="">API URL: {{ route('api.detail_order') }}</p>
                    <p class="">Method: <span class="badge badge-danger">POST</span></p>
                    <p class="">Body:</p>
<pre><code class="json">
    {
        "api_key" : "API KEY",
        "order_id" : 18
    }
    </code></pre>
                    <p class="">Response:</p>
<pre><code class="json">
    {
        "id": 18,
        "quantity": 1,
        "price": 1300,
        "total_price": 1300,
        "type": "Via ngoại no very",
        "created_at": "2021-06-07T14:50:51.000000Z",
        "data": [
            {
                "uid": "3456345435465",
                "full_info": "3456345435465|pass|cookie|2fa",
                "link_backup": "http://localhost:2000/download_backup/18/3456345435465"
            }
        ]
    }
    </code></pre>
                </div>
            </div>
        </div>
        <!-- END Page Content -->
    </main>
@endsection
@push('custom-scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            $("#change_apikey").click(function() {
                $.ajax({
                    type: 'POST',
                    url: '/updateAPIKEY',
                    success: function(data) {
                        $("#show_api_key").html(data.api_key)
                    },
                });
            })
            $("#copy_apikey").click(function() {
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val($("#show_api_key").text()).select();
                document.execCommand("copy");
                $temp.remove();
                $(this).html('<i class="fa fa-copy mr-1"></i> Copied')
            })
        })

    </script>
@endpush
