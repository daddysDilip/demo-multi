<div class="dashboard-menu">

    <h3>{{trans('app.MyAccount')}}</h3>

    <ul class="dashboard-mainmenu">

        <li><a href="{{ route('logout') }}"

               onclick="event.preventDefault();

               document.getElementById('logout-form').submit();">

                <i class="fa fa-fw fa-power-off"></i> {{trans('app.Logout')}}

            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">

                {{ csrf_field() }}

            </form></li>

        <li><a href="{{route('user.account',$subdomain_name)}}">{{trans('app.AccountDashboard')}}</a></li>

        <li><a href="{{route('user.accinfo',$subdomain_name)}}">{{trans('app.EditAccountInfo')}}</a></li>

        <li><a href="{{route('user.accpass',$subdomain_name)}}">{{trans('app.ChangePassword')}}</a></li>

        <li><a href="{{route('user.orders',$subdomain_name)}}">{{trans('app.MyOrders')}}</a></li>

    </ul>

</div>