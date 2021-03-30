<div id="dashboard_sidebar" class="my-account">
    <h5>my account</h5>
    <ul>
        <li>
            <span class="title">
                <a href="{{ route('logout') }}"
               onclick="event.preventDefault();
               document.getElementById('logout-form').submit();"><i class="fa fa-fw fa-power-off"></i> Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </span>
        </li>
        <li>
            <span class="title">
                <a href="{{route('user.account',$subdomain_name)}}">Account Dashboard</a>
            </span>
        </li>
        <li>
            <span class="title">
                <a href="{{route('user.accinfo',$subdomain_name)}}">Edit Account Information</a>
            </span>
        </li>
        <li>
            <span class="title">
                <a href="{{route('user.accpass',$subdomain_name)}}">Change Password</a>
            </span>
        </li>
        <li>
            <span class="title">
                <a href="{{route('user.orders',$subdomain_name)}}">My Orders</a>
            </span>
        </li>
    </ul>
</div>
