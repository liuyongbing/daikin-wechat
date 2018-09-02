<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=640, user-scalable=no, minimal-ui, target-densitydpi=255" />
    <script src="https://cdn.bootcss.com/jquery/1.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ asset('public/css/css.css') }}" />
    <title>大金空调</title>
    <style>
    	
	.list-type{ overflow:hidden; padding:20px 40px; border-top:4px solid #52c3f1; text-align:center;}
	.list-type a{ text-align:center; width:32%; background:#b7b7b7; color:#fff; font-size:30px; height:60px; line-height:60px; display:inline-block;}
	.list-type a:first-child{ float:left;}
	.list-type a:last-child{ float:right;}
	.list-type a.tag{ background:#0096e0;}
	
	.list-cen{ padding:0 40px;}
	.list-cen .col{ float:left; width:268px; font-size:16px; color:#666; margin-bottom:20px;}
	.list-cen .col img{ width:100%;}
	.list-cen .col:nth-child(even){ float:right;}
	.list-cen .col label{ height:35px; line-height:35px; overflow:hidden; display:block; font-size:24px; color:#000; margin-bottom:10px;}
	.list-cen .col span{ height:70px; overflow:hidden; display:block;}
	
    </style>
</head>
<body>

<div class="container">
	
	<div class="head">
		<a href="javascript:void(0);" class="logo"></a>
	</div>
	
	<div class="list-type">
    @if (!empty($types))
        @foreach($types as $type)
		<a href="{{ route('wechat.life.list', ['cur_type_id' => $type->id]) }}" class="{{ $cur_type_id == $type->id ? 'tag' : '' }}">{{ $type->name }}</a>
        @endforeach
    @endif
	</div>
	
	<div class="list-cen">
    
    @if (!empty($data))
        @foreach($data as $item)
		<div class="col">
            @if (!empty($item->img))
			<div class="ovf">
                <a href="{{ route('wechat.life.detail', ['id' => $item->id]) }}" >
                    <img src="{{$item->img}}" />
                </a>
            </div>
            @endif
			<label><a href="{{ route('wechat.life.detail', ['id' => $item->id]) }}" >{{ $item->title }}</a></label>
			<span>{!! $item->desc !!}</span>
		</div>
        @endforeach
    @endif		
	</div>	
</div>

<script>
	
	$(document).ready(function(){
		
		
		
	    
    });
    
	
</script>

</body>
</html>
