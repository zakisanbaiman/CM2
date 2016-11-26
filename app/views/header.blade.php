<header>
    <div class="navbar navbar-default navbar-fixed-top navbar-static-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div id="gnavi-logo">
                    <a href="/">構成管理</a>
                </div>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="/" class="gnavi-button hvr-underline-from-center" title="ホーム">ホーム</a>
                    </li>
                    <li>
                        <a href="/article" class="gnavi-button hvr-underline-from-center" title="記事">記事</a>
                    </li>
                    <li>
                        <a href="/manage" class="gnavi-button hvr-underline-from-center" title="構成管理">構成管理</a>
                    </li>
                    <li>
                        <a href="/manage/list" class="gnavi-button hvr-underline-from-center" title="構成管理リスト">構成管理リスト</a>
                    </li>
                {{--
                    <li>
                        <a href="/user/list" class="gnavi-button hvr-underline-from-center" title="ユーザ一覧">ユーザ一覧</a>
                    </li>
                --}}
                    <li>
                        <a href="/csv/import" class="gnavi-button hvr-underline-from-center" title="ファイル取り込み">ファイル取り込み</a>
                    </li>

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
    </div>
</header>