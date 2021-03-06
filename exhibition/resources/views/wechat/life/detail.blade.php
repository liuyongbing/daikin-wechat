<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=640, user-scalable=no, minimal-ui, target-densitydpi=255" />
    <script src="https://cdn.bootcss.com/jquery/1.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ asset('public/css/css.css') }}" />
    <title>大金空调</title>
    <style>
        
    .video{ overflow:hidden;  border-top:4px solid #52c3f1; text-align:center; font-size:16px; color:#666;}
    .video video{ width:640px; height:326px;}
    
    .video-txt{ padding:40px; border-bottom:1px solid #ccc;}
    .video-txt b{ margin-bottom:10px; display:block; font-size:24px;}
    .video-txt p{ font-size:20px; color:#666; line-height:32px;}
    
    .designerd-div{ padding:20px 40px;}
    .designerd-div .title{ margin-bottom:20px;}
    .designerd-div .title span{ margin-right:15px; padding:0 10px; display:inline-block; color:#fff; background:#ff6700; font-size:18px; height:36px; line-height:36px;}
    .designerd-div .col{ margin-bottom:20px; overflow:hidden;}
    .designerd-div .ovf{ margin-right:15px; float:left; width:202px;}
    .designerd-div .txt{}
    .designerd-div .txt b{ font-size:24px; margin-bottom:20px; display:block; margin-bottom:10px;}
    .designerd-div .txt p{ overflow:hidden; font-size:18px; color:#666; line-height:32px;}
    .designerd-div .ovf {
        margin-right: 15px;
        float: left;
        width: 202px;
        height: 202px;
    }
    .designerd-div .ovf img{ width:100%;}
    
    .other-div{ padding:20px 40px;}
    .other-div .title{ margin-bottom:20px;}
    .other-div .title span{ margin-right:15px; padding:0 10px; display:inline-block; color:#fff; background:#0096e0; font-size:18px; height:36px; line-height:36px;}
       
       .other-div .col{ margin-bottom:20px; overflow:hidden;}
    .other-div .ovf{ margin-right:15px; float:left; width:230px;}
    .other-div .txt b{ font-size:24px; margin-bottom:20px; display:block; margin-bottom:10px;}
    .other-div .txt p{ overflow:hidden; font-size:18px; color:#666; line-height:32px;}
    .other-div .ovf img{  width:230px; height:120px;}
    
       
    
    </style>
</head>
<body>

<div class="container">
    
    <div class="head">
        <a href="javascript:void(0);" class="logo"></a>
        <a class="return" href="{{ route('wechat.life.list', ['cur_type_id' => $data->type_id]) }}">返回</a>
    </div>
    
    <div class="video">
        {!! $data->video !!}
        <label>(请在wifi情况下观看）</label>
    </div>
    
    <div class="video-txt">
        <b>{{ $data->title }}</b>
        <p>{!! $data->desc !!}</p>
    </div>
    
    <!--设计师-->
    @if (!empty($designer))
    <div class="designerd-div ">
        <div class="title"><span>设计师</span><label>{{ $designer->name }}</label></div>
        <div class="designer-list">
            <div class="col">
                @if (!empty($designer->img))
                <div class="ovf"><img src="{{ $designer->img }}" /></div>
                @endif
                <div class="txt">
                    <b>{{ $designer->title }}</b>
                    {!! $designer->desc !!}
                </div>
            </div>
        </div>
    </div>
    @endif
    <!--设计师-->
    
    @if (!empty($recommend))
    <!--同分类下的视频推荐-->
    <div class="other-div">
        <div class="title"><span>视频推荐</span></div>
        <div class="other-list">
        @foreach($recommend as $life)
            <div class="col">
                @if (!empty($life->img))
                <div class="ovf">
                    <a href="{{ route('wechat.life.detail', ['id' => $life->id]) }}">
                        <img src="{{ $life->img }}" />
                    </a>
                </div>
                @endif
                <div class="txt">
                    <b><a href="{{ route('wechat.life.detail', ['id' => $life->id]) }}">{{ $life->title }}</a></b>
                    <p>{!! $life->desc !!}</p>
                </div>
            </div>  
        @endforeach
        </div>
    </div>
    <!--同分类下的视频推荐-->
    @endif
    
    @if (!empty($recommendCases))
    <!--设计师相关的视频推荐-->
    <div class="other-div">
        <div class="title"><span>视频推荐</span></div>
        <div class="other-list">
        @foreach($recommendCases as $life)
            <div class="col">
                @if (!empty($life->img))
                <div class="ovf">
                    <a href="{{ route('wechat.life.detail', ['id' => $life->id]) }}">
                        <img src="{{ $life->img }}" />
                    </a>
                </div>
                @endif
                <div class="txt">
                    <b><a href="{{ route('wechat.life.detail', ['id' => $life->id]) }}">{{ $life->title }}</b></a>
                    <p>{!! $life->desc !!}</p>
                </div>
            </div>  
        @endforeach
        </div>
    </div>
    <!--设计师相关的视频推荐-->
    @endif
    
</div>

</body>
</html>
