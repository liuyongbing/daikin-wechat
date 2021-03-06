<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>后台管理</title>
    <link href="{{asset('resources/assets/admin/css/css.css')}}" rel="stylesheet">
    <script src="{{asset('resources/assets/admin/js/jquery-1.8.0.min.js')}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{asset('public/ueditor/ueditor.config.js')}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{asset('public/ueditor/ueditor.all.min.js')}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{asset('public/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
<script type="text/javascript">
    function onload(){
        @if(count($errors)&&is_object($errors))
            str = '';
            @foreach($errors->all() as $error)
            str += '{{$error}}'+'\n';
            @endforeach
            alert(str);
        @elseif($errors=='更新成功')
            alert('更新成功');
            location.href='{{url('admin/designer')}}';
        @endif
    }
</script> 
</head>
<body onload="onload()">
<div id="wrapper" class="clearfix">
    @include('_layout.leftmenu',['menu'=>'admin/life']);
    <div class="main">
        <div class="maintop">
            <div class="backlist">
                <a href="{{url('admin/life/create')}}">新增视频</a> | 
                <a href="{{url('admin/life_type')}}">案例类别</a> | 
                <a href="{{url('admin/designer')}}" class="sub_menu_cur">设计师管理</a>
            </div>
        </div>
        <form id="uploadForm" action="{{url('uploadImages')}}" method="post"">
            {{csrf_field()}}
            <input style="display: none;" name="image" type="file" class="inputFile" />
        </form>
        <form method="post" action="{{url('admin/designer/'.$data->id)}}" enctype="multipart/form-data" >
            <div class="mainbom">
                <div class="modbox">
                    <table cellpadding="0" cellspacing="0">
                        {{csrf_field()}}
                        <input type="hidden" name="_method"  value="put" />
                        
                        <tr>
                            <th>姓名：</th>
                            <td>
                                <input type="text" name="name"  class="txt" style="width: 520px;" value="{{old('name', $data->name)}}" />
                            </td>
                        </tr>
                        
                        <tr>
                            <th>标题：</th>
                            <td>
                                <input type="text" name="title"  class="txt" style="width: 520px;" value="{{old('title', $data->title)}}" />
                            </td>
                        </tr>
                        
                        <tr>
                            <th>头像：</th>
                            <td>
                                <input type="file" name="upload_file" class="txt" style="width: 520px;" />
                                <input type="hidden" name="img" value="{{old('img', $data->img)}}" />
                            </td>
                        </tr>
                        
                        <tr>
                            <th>预览：</th>
                            <td>
                                @if (!empty($data->img))
                                    <img src="{{ $data->img }}" width="202" height="202" />
                                @endif
                            </td>
                        </tr>
                        
                        <tr>
                            <th>说明内容：</th>
                            <td><script id="desc" type="text/plain" style="margin-top:20px;width:530px;height:200px;">{!! old('desc',$data->desc) !!}</script></td>
                        </tr>
                    
                        <!--tr>
                            <th>是否显示</th>
                            <td>
                            <label class="desc"><input name="display" type="radio"  value="1" @if(old('display',$data->display) == 1)) checked @endif/>是 </label> 
                            <label class="desc"><input name="display" type="radio"  value="0" @if(old('display',$data->display) == 0)) checked @endif/>否 </label> 
                            </td>
                        </tr-->
                        <tr>
                            <th>&nbsp;</th>
                            <td><a href="javascript:void(0)" class="btnsub" onclick="submitForm()">提交</a></td>
                        </tr>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function submitForm() {
        $("form").submit();
    }
    var ue = UE.getEditor('video', {
        toolbars: [
            [  
               'source', '|','insertvideo', '|','preview'
             ]
        ],
        autoHeightEnabled: true,
        autoFloatEnabled: true,
        textarea: 'video'
    });

    var ue2 = UE.getEditor('desc', {
        toolbars: [
            [  
                'fullscreen', 'source', '|', 'undo', 'redo', '|',
                'bold', 'italic', 'underline', 'removeformat', 'formatmatch', 'autotypeset','forecolor', 'backcolor','fontfamily', 'fontsize', '|',           
                 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
                'simpleupload', 'insertimage','insertvideo', 'attachment','|',
                'horizontal', '|',	      
                'print', 'preview', 'searchreplace', 'drafts'
             ]
        ],
        autoHeightEnabled: true,
        autoFloatEnabled: true,
        textarea: 'desc'
    });
</script>

<script type="text/javascript">

//移除loading加载图片
$('.loading-shadow').removeClass('active');
//看我接下来的解释
$('.uploaded-image').attr('src',$('#img').val());
//更换上传提示文本为重新上传
$('.upload-text').removeClass('on');
$('.re-upload-text').addClass('on');

$(function (e) {
    $("#uploadForm").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: "{{url('uploadImages')}}",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            // 显示加载图片
            beforeSend: function () {
                $('.loading-shadow').addClass('active');
            },
            success: function (data) {
                // 移除loading加载图片
                $('.loading-shadow').removeClass('active');
                // 看我接下来的解释
                $('.uploaded-image').attr('src',data.msg);
                $('.img').attr('value',data.msg);
                // 更换上传提示文本为重新上传
                $('.upload-text').removeClass('on');
                $('.re-upload-text').addClass('on');
            },
            error: function(){}
        });
    });
    
    // 选择完要上传的文件后, 直接触发表单提交
    $('input[name=image]').on('change', function () {
        // 如果确认已经选择了一张图片, 则进行上传操作
        if ($.trim($(this).val())) {
            $("#uploadForm").trigger('submit');
        }
    });
 
    // 触发文件选择窗口
    $('.js-reset-image span').on('click', function () {
        $('input[name=image]').trigger('click');
    });
});
</script>
</body>
</html>
