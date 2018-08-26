<div class="leftmenu">
        <div class="adminlogo"><img src="{{asset('resources/assets/admin/images/adminlogo.jpg')}}"></div>
        <p class="logstate"><a href="{{url('admin/logout')}}">Logout</a></p>
        <ul>
            <li><a href="{{url('admin/user')}}" @if($menu=='admin/user')class='active'@endif>预约信息</a></li>
            <li><a href="{{url('admin/user/today')}}" @if($menu=='admin/user/today')class='active'@endif>今日预约信息</a></li>
            <li><a href="{{url('admin/user/history')}}" @if($menu=='admin/user/history')class='active'@endif>已预约信息</a></li>
            @if(session('shopid')==0)
                <li><a href="{{url('admin/shop')}}" @if($menu=='admin/shop')class='active'@endif>展厅管理</a></li>
                <li><a href="{{url('admin/message')}}" @if($menu=='admin/message')class='active'@endif>短信管理</a></li>            
            	<li><a href="{{url('admin/awards')}}" @if($menu=='admin/awards')class='active'@endif>品牌荣耀</a></li>
            	<li><a href="{{url('admin/life')}}" @if($menu=='admin/life')class='active'@endif>住宅生活</a></li>
            	<li><a href="{{url('admin/designer')}}" @if($menu=='admin/designer')class='active'@endif>设计师</a></li>
            	<li><a href="{{url('admin/instruction')}}" @if($menu=='admin/instruction')class='active'@endif>空调使用说明</a></li>
            @endif
        </ul>
</div>