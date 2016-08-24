<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{asset('/img/tippspiel/DrL-160x160.png')}}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>{{ $eager_user->name }}</p>
                </div>
            </div>
        @endif

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            @if ($eager_user->user_type_id == 3)
                <!-- Sidebar content for new user -->
                <li class="header">{{ 'Welcome' }}</li>
                <li class="active"><a href="{{ url('home') }}"><i class='fa fa-home'></i> <span>{{ 'Home' }}</span></a></li>
            @else
                <!-- Sidebar content for accepted user -->
                <li class="header">{{ trans('Tippspiel') }}</li>
                <li {{ (Request::is('home') ? 'class=active' : '') }}>
                    <a href="{{ url('home') }}"><i class='fa fa-home'></i> <span>{{ 'Home' }}</span></a>
                </li>

                @foreach($eager_user->group_user as $ug)
                    @if($ug->pending == 0)
                        <li class="treeview {{ checkActive('group/'.$ug->group->id.'/*') }}">
                            <a href="/group/{{$ug->group->id}}/tipp"><i class='fa fa-soccer-ball-o'></i> <span>{{ $ug->group->name }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="{{ checkActive('group/'.$ug->group->id.'/tipp') }}">
                                    <a href="/group/{{$ug->group->id}}/tipp"><i class='fa fa-pencil'></i> <span>{{ 'Tipps abgeben' }}</span></a>
                                </li>
                                <li class="{{ checkActive('group/'.$ug->group->id.'/results') }}">
                                    <a href="/group/{{$ug->group->id}}/results"><i class='fa fa-eye'></i> <span>{{ 'Tippergebnisse ansehen' }}</span></a>
                                </li>
                                <li class="{{ checkActive('group/'.$ug->group->id.'/ranking') }}">
                                    <a href="/group/{{$ug->group->id}}/ranking"><i class='fa fa-bars'></i> <span>{{ 'Tipptabelle ansehen' }}</span></a>
                                </li>
                                @if($ug->isAdmin)
                                    <li class="{{ checkActive('group/'.$ug->group->id.'/manage') }}">
                                        <a href="/group/{{$ug->group->id}}/manage"><i class='fa fa-wrench'></i> <span>{{ 'Verwaltung' }}</span></a></li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @endforeach

                @if($eager_user->user_type_id == 1)
                    <!-- Sidebar content for admin -->
                    <li class="treeview {{ checkActive('admin/*') }}">
                        <a href="#"><i class="fa fa-cog"></i><span>{{ 'Administration' }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu ">
                            <li class="{{ checkActive('admin/user') }}">
                                <a href="{{ url('admin/user') }}"><i class="fa fa-users"></i>{{ 'Benutzer editieren' }}</a>
                            </li>
                            <li class="{{ checkActive('admin/group') }}">
                                <a href="{{ url('admin/group') }}"><i class="fa fa-files-o"></i>{{ 'Gruppenverwaltung' }}</a>
                            </li>
                        </ul>
                    </li>
                @endif
            @endif
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
