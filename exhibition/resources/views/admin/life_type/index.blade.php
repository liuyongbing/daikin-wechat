@extends('_layout.admin')
@section('content')
    <div id="wrapper" class="clearfix">
    @include('_layout.leftmenu',['menu'=>'admin/life']);

        <div class="main">
            <div class="maintop">
                <div class="backlist">
                    <a href="{{url('admin/life/create')}}">新增内容</a> | 
                    <a href="{{url('admin/life_type')}}" class="sub_menu_cur">案例类别</a> | 
                    <a href="{{url('admin/designer')}}">设计师管理</a>
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
                            <th width="150"><span style="padding-left:38px;">名称</span></th>
                            <th width="100"><span>排序</span></th>
                            <th width="100"></th>
                        </tr>

                        <?php $i=1 ;?>
                        @foreach($data as $value)
                        <tr id="tablerows" <?php (($i++%2)==0) ? $class='class="odd"':$class='';echo $class; ?>>
                            <td><span style="padding-left:30px;">{{$value->name}}</span></td>
                            <td><span>{{$value->sort}}</span></td>
                            <td align="center"><a href="{{url('admin/life_type/'.$value->id)}}">修改</a></td>
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
                url: "{{url('admin/life_type/destroy')}}",
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