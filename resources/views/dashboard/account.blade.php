@extends("layouts.master")
@section("content")
<main id="main-container">
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="block block-rounded block-themed block-fx-pop">
                    <div class="block-header bg-info">
                        <h3 class="block-title"><?= __('labels.setting') ?></h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option">
                                <i class="si si-settings"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <h2 class="content-heading"><?= __('labels.account_info') ?></h2>
                        <div class="row">
                            <div class="offset-2 col-lg-8">
                                @if (Session::has('status_2fa'))
                                    <div class="alert alert-success" role="alert">
                                        <p class="mb-0">
                                            {{Session::get('status_2fa')}}
                                        </p>
                                        
                                    </div>
                                @endif
                                <div class="form-group row">
                                    <label class="col-sm-4"><?= __('labels.register_date') ?>:</label>
                                    <div class="col-sm-8">
                                        <span>{{ format_time($user->created_at,"d/m/Y H:i:s") }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4"><?= __('labels.username') ?>:</label>
                                    <div class="col-sm-8">
                                        <span>{{$user->username}}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">Email:</label>
                                    <div class="col-sm-8">
                                        <span>{{$user->email}}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4"><?= __('labels.balance') ?>:</label>
                                    <div class="col-sm-8">
                                        <span><strong>{{number_format($user->coin)}}</strong> VNĐ</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4"><?= __('labels.2fa_authen') ?>:</label>
                                    <div class="col-sm-8">
                                        @if ($user->secret_code)
                                        <span class="text-primary">
                                            <strong><i class="fa fa-check-circle mr-1 text-primary"></i> <?= __('labels.activated') ?></strong>
                                        </span>
                                        <a href="{{ route('2fa_setting') }}" class="btn btn-danger btn-sm"><i class="fa fa-key mr-1"></i> <?= __('labels.disable_2fa') ?></a>
                                        @else
                                        <span class="text-danger">
                                            <strong><i class="fa fa-times-circle mr-1 text-danger"></i> <?= __('labels.not_activated') ?></strong>
                                        </span>
                                        <a href="{{ route('2fa_setting') }}" class="btn btn-success btn-sm"><i class="fa fa-key mr-1"></i> <?= __('labels.enable_2fa') ?></a>
                                        @endif
                                        
                                    </div>
                                </div>
                                @if (!empty(getSetting('token_bot_telegram')))
                                <div class="form-group row">
                                    <label class="col-sm-4"><?= __('labels.connect_telegram') ?>:</label>
                                    <div class="col-sm-8">
                                        @if ($user->tele_chat_id)
                                        <span class="text-primary">
                                            <strong><i class="fa fa-check-circle mr-1 text-primary"></i> <?= __('labels.connected') ?>: {{$user->tele_chat_id}}</strong>
                                        </span>
                                        @else
                                        <span class="text-danger">
                                            <strong><i class="fa fa-times-circle mr-1 text-danger"></i> <?= __('labels.not_connection') ?></strong>
                                        </span>
                                        @endif
                                        <a target="_blank" href="{{getSetting('url_bot_telegram')}}" class="btn btn-success btn-sm"><i class="fa fa-key mr-1"></i> <?= __('labels.connect_with') ?> {{getSetting('url_bot_telegram')}}</a>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4"><?= __('labels.code_active_telegram') ?> <br>(<?= __('labels.please_keep_this_information_confidential') ?>)</label>
                                    <div class="col-sm-8">
                                        <span><strong>{{$user->verifycodetele}}</strong></span>
                                    </div>
                                </div>
                                @endif
                                @if ($user->aff_flg == 1)
                                <div class="form-group row">
                                    <label class="col-sm-4"><?= __('labels.referral_link') ?>:</label>
                                    <div class="col-sm-8">
                                        <span><strong>{{route('get.register', ['aff' => $user->id])}}</strong></span>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
    
                        <h2 class="content-heading"><?= __('labels.change_password') ?></h2>
                        <div class="row">
                            <div class="offset-2 col-lg-8">
                                @if ($errors->any())
                                    <div class="alert alert-danger" role="alert">
                                        <p class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                {{$error}} <br>
                                            @endforeach
                                        </p>
                                        
                                    </div>
                                @endif
                                @if (Session::has('success'))
                                    <div class="alert alert-success" role="alert">
                                        <p class="mb-0">
                                            {{Session::get('success')}}
                                        </p>
                                        
                                    </div>
                                @endif
                                <form class="mb-5" action="{{route('doimatkhau')}}" method="POST">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label"><?= __('labels.current_password') ?></label>
                                        <div class="col-sm-8">
                                            <input type="password" class="form-control" name="current_password" placeholder=""  value="{{old('current_password','')}}"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label"><?= __('labels.new_password') ?></label>
                                        <div class="col-sm-8">
                                            <input type="password" class="form-control" name="password" placeholder="" value="{{old('password','')}}"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label"><?= __('labels.confirm_new_password') ?></label>
                                        <div class="col-sm-8">
                                            <input type="password" class="form-control" name="password_confirmation" placeholder="" value="{{old('password_confirmation','')}}"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-8 ml-auto">
                                            <button type="submit" class="btn btn-primary"><?= __('labels.save_change') ?></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="block block-rounded block-bordered">
            <div class="block-header block-header-default">
                <h3 class="block-title">Login History</h3>
                
            </div>
            <div class="block-content">
                <table class="table table-vcenter">
                    <thead>
                        <tr>
                            <th>Device</th>
                            <th>IP Address</th>
                            <th>Last Logged At</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($user->logins)
                            @foreach ($user->logins as $history_login)
                            <tr>
                                <td>{{ $history_login->device->platform }} {{ $history_login->device->platform_version }}<br>
                                    {{ $history_login->device->browser }} ({{ $history_login->device->browser_version }})
                                </td>
                                <td>{{ $history_login->ip_address }}</td>
                                <td>{{ $history_login->created_at->format('d-m-Y H:i:s') }}</td>
                                <td>@if ($history_login->type == 'auth')
                                    <span class="badge badge-pill badge-success">Succeeded</span>
                                @else
                                <span class="badge badge-pill badge-danger">Failed</span>
                                @endif</td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        @if ($user->aff_flg == 1)
        <div class="block block-rounded block-bordered">
            <div class="block-header block-header-default">
                <h3 class="block-title"><?= __('labels.list_of_members_introduced') ?></h3>
                
            </div>
            <div class="block-content">
                <table class="table table-vcenter">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#ID</th>
                            <th><?= __('labels.username') ?></th>
                            <th>Email</th>
                            <th><?= __('labels.phone_number') ?></th>
                            <th><?= __('labels.register_date') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($user_aff)
                            @foreach ($user_aff as $user)
                            <tr>
                                <th class="text-center" scope="row">{{$user->id}}</th>
                                <td class="font-w600">
                                    {{$user->username}}
                                </td>
                                <td>
                                    {{$user->email}}
                                </td>
                                <td>
                                    {{$user->phone}}
                                </td>
                                
                                <td>
                                    {{format_time($user->created_at,"d-m-Y H:i:s")}}
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
    
</main>
<!-- END Main Container -->
@endsection