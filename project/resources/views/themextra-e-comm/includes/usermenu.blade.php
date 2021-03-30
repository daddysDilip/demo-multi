<div class="cart-total my-account">
    <div class="head"><i class="icon fa fa-user fa-fw"></i> {{trans('app.MyAccount')}}</div>  
    <nav class="yamm megamenu-horizontal">  
    <ul class="nav">
        <li class="menu-item">
            <span class="title">
                <a href="{{ route('logout') }}"
               onclick="event.preventDefault();
               document.getElementById('logout-form').submit();"><i class="fa fa-fw fa-power-off"></i> {{trans('app.Logout')}}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </span>
        </li>
        <li>
            <span class="title">
                <a href="{{route('user.account',$subdomain_name)}}">{{trans('app.AccountDashboard')}}</a>
            </span>
        </li>
        <li>
            <span class="title">
                <a href="{{route('user.accinfo',$subdomain_name)}}">{{trans('app.EditAccountInfo')}}</a>
            </span>
        </li>
        <li>
            <span class="title">
                <a href="{{route('user.accpass',$subdomain_name)}}">{{trans('app.ChangePassword')}}</a>
            </span>
        </li>
        <li>
            <span class="title">
                <a href="{{route('user.orders',$subdomain_name)}}">{{trans('app.MyOrders')}}</a>
            </span>
        </li>
    </ul>
</nav>
</div>
