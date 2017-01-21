<header>
    <!-- Navbar Start-->
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <ul class="nav navbar-nav navbar-left">
                <li><a class="navbar-brand" href="/article">記事</a></li>
                <li><a class="navbar-brand" href="/manage">構成管理</a></li>
                <li><a class="navbar-brand" href="/manage/list">構成管理リスト</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">

                @if (Sentry::check())

                    <li class="dropdown{{ (Request::is('account*') ? ' active' : '') }}">
                        <a class="dropdown-toggle" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="{{ route('account') }}">
                            {{ Sentry::getUser()->email }}
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                            @if(Sentry::getUser()->hasAccess('admin'))
                                <li><a href="{{ route('admin') }}"><i class="icon-cog"></i>サイト管理</a></li>
                            @endif
                            <li{{ (Request::is('account/profile') ? ' class="active"' : '') }}>
                                <a href="{{ route('profile') }}"><i class="icon-user"></i>アカウント管理</a></li>
                            <li class="divider"></li>
                            <li><a href="{{ route('logout') }}"><i class="icon-off"></i>ログアウト</a></li>
                        </ul>
                    </li>
                @else
                    <li {{ (Request::is('auth/login') ? 'class="active"' : '') }}><a href="{{ route('login') }}">ログイン</a></li>
                    <li {{ (Request::is('auth/signup') ? 'class="active"' : '') }}><a href="{{ route('signup') }}">会員登録</a></li>
                @endif

            </ul>
        </div>
    </div>
    <!-- End of Navber -->
</header>