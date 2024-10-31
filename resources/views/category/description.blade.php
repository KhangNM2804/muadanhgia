<ul class="list-unstyled text-left">
    @php
        $arr_desc = explode("|",$item->desc);
    @endphp
    @foreach ($arr_desc as $desc)
    <li><i class="fa fa-check text-success"></i> {{$desc}}</li>
    @endforeach
</ul>
<div class="mb-2">
    {!! nl2br($item->long_desc) !!}
</div>