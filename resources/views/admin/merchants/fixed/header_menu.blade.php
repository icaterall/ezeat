<style type="text/css">
    .menu-item-active{
        color:white;
    }
</style>

<div id="kt_header_menu" class="header-menu header-menu-left header-menu-mobile header-menu-layout-default">
    <ul class="menu-nav">         
        <li class="menu-item @if (\Request::is('manager_gate'))menu-item-active @endif">
            <a href="{{ route('manager.index') }}" class="menu-link">
                <i class="menu-text icon-x flaticon-dashboard"></i>
                <span class="menu-text">&nbsp;Dashboard</span>
                <span class="menu-desc"></span>
            </a>
        </li>

@if (Auth::check())
       @can('manager_privilege') 

        <li class="menu-item 
                    @if (
                    (\Request::is('*/restaurants')) OR (\Request::is('*/restaurants/*'))
                            ) menu-item-active @endif">
            <a href="{{route('admin.restaurants.edit',Auth::user()->restaurants->first()->id)}}" class="menu-link">
                <i class="menu-text icon-x flaticon2-graphic-design"></i>
                <span class="menu-text">&nbsp;Restaurant</span>
                <span class="menu-desc"></span>
            </a>
        </li>
       

        <li class="menu-item 
                    @if (
                    (\Request::is('*/working_days')) OR (\Request::is('*/working_days/*'))
                            ) menu-item-active @endif">
            <a href="{{route('manager.working_days.edit',Auth::user()->restaurants->first()->id)}}" class="menu-link">
                <i class="menu-text icon-x flaticon2-calendar-1"></i>
                <span class="menu-text">&nbsp;Working Time</span>
                <span class="menu-desc"></span>
            </a>
        </li>
@endif

        <li class="menu-item 
                           @if (
                          
                             (\Request::is('*/foods')) OR (\Request::is('*/foods/*'))
                            OR  (\Request::is('*/extras')) OR (\Request::is('*/extras/*'))
                            ) menu-item-active @endif">
            <a href="{{ route('manager.foods.index') }}" class="menu-link">
                <i class="menu-text icon-x flaticon2-pie-chart-2"></i>
                <span class="menu-text">&nbsp;Foods</span>
                <span class="menu-desc"></span>
            </a>
        </li>


        <li class="menu-item 
                           @if (
                          
                             (\Request::is('*/orders')) OR (\Request::is('*/orders/*'))
                            ) menu-item-active @endif">
            <a href="{{ route('manager.orders.index') }}" class="menu-link">
                <i class="menu-text icon-x flaticon-shopping-basket"></i>
                <span class="menu-text">&nbsp;My Orders</span>
                <span class="menu-desc"></span>
            </a>
        </li>

@if (Session::has('switch_user_original'))
        <li class="menu-item">
            <a href="/admin_gate/switch-user-end" class="menu-link">
               
                <i class="menu-text icon-x2  fab fa-expeditedssl"></i>
                <span class="menu-text">&nbsp;Login as Admin </span>
                <span class="menu-desc"></span>
            </a>
        </li>
 @endif       


 @endcan
    </ul>
</div>