<div class="cart-total my-account">
    <h5>{{trans('app.MyAccount')}}</h5>
    <ul>
        <li>
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
</div>
