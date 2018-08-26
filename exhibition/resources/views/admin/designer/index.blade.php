@extends('_layout.admin')
@section('content')
    <div id="wrapper" class="clearfix">
    @include('_layout.leftmenu',['menu'=>'admin/designer']);

        <div class="main">
            <div class="maintop">
                <div class="backlist">
                    <a href="{{url('admin/designer/create')}}">新增</a>
                </div>
                <!--div class="schbox" >
	                <form method="get">
	                {{csrf_field()}}
                    <a style="position: absolute;" href="javascript:void(0)" onclick="submitForm();">查询数据</a>
	                </form>
	            </div-->
            </div>

            <div class="mainbom" style="margin-top: 10px">
                <div class="listbox">
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <th width="150"><span style="padding-left:38px;">姓名</span></th>
                            <th width="500"><span style="padding-left:100px;">标题</span></th>
                            <th width="100"></th>
                            <th width="100"></th>
                        </tr>

                        <?php $i=1 ;?>
                        @foreach($data as $value)
                            <tr id="tablerows" <?php (($i++%2)==0) ? $class='class="odd"':$class='';echo $class; ?>>
                            <td><span style="padding-left:30px;">{{$value->name}}</span></td>
                            <td style="padding-top:20px;padding-left:100px;">{{ $value->title }}</td>
                            <td align="center"><a href="{{url('admin/designer/'.$value->id)}}">修改</a></td>
                            <td> <a href="javascript:void(0)" class="delrows" onclick="deltablerows(this,'{{csrf_token()}}',{{$value->id}})">删除</a></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>


            <div class="mainend">
                @include('admin.paginate')
            </div>


        </div>

    </div>
    <script>
        function deltablerows(obj,token,id){
            if(confirm("删除不可逆，请谨慎操作")){
                $(obj).parents('#tablerows').remove();
                destroy(token,id);
            }
        }
        function destroy(token,id) {
            $.ajax({
                type: "POST",
                url: "{{url('admin/designer/destroy')}}",
                dataType:'json',
                data: {'_token':token,'id':id},
                success: function(data){
                    alert(data.msg);
                }
            })}
        function submitForm() {
            $("form").submit();
        }
    </script>
@endsection