<!--
=========================================================
* * Black Dashboard - v1.0.1
=========================================================

* Product Page: https://www.creative-tim.com/product/black-dashboard
* Copyright 2019 Creative Tim (https://www.creative-tim.com)


* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('img/apple-icon.png')}}">
    <link rel="icon" type="image/png" href="{{asset('img/favicon.png')}}">
    <title>
        BikeShop
    </title>
    <link href="{{asset('/css/css.css')}}" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="{{asset('css/nucleo-icons.css')}}" rel="stylesheet"/>
    <link href="{{asset('css/black-dashboard.css')}}" rel="stylesheet"/>
    <link rel="stylesheet" href="{{asset('/css/solid.min.css')}}">
    <link rel="stylesheet" href="{{asset('/css/bootstrap-select.min.css')}}">
</head>

<body class="">
<div class="wrapper">
    <div class="sidebar" data="blue">
        <div class="sidebar-wrapper">
            <div class="logo">
                <a href="javascript:void(0)" class="simple-text text-center logo-normal">
                    BikeShop
                </a>
            </div>
            <ul class="nav">
                @auth
                    @php $currentPrefix = explode('.', \Request::route()->getName())[0];
                    @endphp
                    @foreach(config('navigation') as $nav)
                        <li class="{{explode('.', $nav['route'])[0] == $currentPrefix ? 'active' : ''}}">
                            <a href="{{route($nav['route'])}}" class="nav-link">
                                <i class="fa fa-{{$nav['icon']}} fa-lg"></i>
                                <p class="nav-link-text">{{$nav['label']}}</p>
                            </a>
                        </li>
                    @endforeach
                @endauth
            </ul>
        </div>
    </div>
    <div class="main-panel" data="blue">
        <nav class="navbar navbar-expand-lg navbar-absolute navbar-transparent">
            <div class="container-fluid">
                <div class="navbar-wrapper">
                    <div class="navbar-toggle d-inline">
                        <button type="button" class="navbar-toggler">
                            <span class="navbar-toggler-bar bar1"></span>
                            <span class="navbar-toggler-bar bar2"></span>
                            <span class="navbar-toggler-bar bar3"></span>
                        </button>
                    </div>
                    @auth
                        <a class="navbar-brand" href="javascript:void(0)">
                            Hi <strong>{{Auth::user()->name}}</strong>
                        </a>
                    @endauth
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                </button>
                @auth
                    <div class="collapse navbar-collapse" id="navigation">
                        <ul class="navbar-nav ml-auto">
                            <li class="dropdown nav-item">
                                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                    <div class="photo">
                                        <img src="{{asset('img/anime3.png')}}" alt="Profile Photo">
                                    </div>
                                    <b class="caret d-none d-lg-block d-xl-block"></b>
                                    <p class="d-lg-none">
                                        Log out
                                    </p>
                                </a>
                                <ul class="dropdown-menu dropdown-navbar">
                                    <li class="nav-link">
                                        <a href="javascript:void(0)" class="nav-item dropdown-item">
                                            Profile
                                        </a>
                                    </li>
                                    <li class="nav-link">
                                        <a href="javascript:void(0)" class="nav-item dropdown-item">
                                            Settings
                                        </a>
                                    </li>
                                    <li class="dropdown-divider"></li>
                                    <li class="nav-link">
                                        <a class="nav-item dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Log out
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            <li class="separator d-lg-none"></li>
                        </ul>
                    </div>
                @endauth
            </div>
        </nav>
        <div class="content">
            @yield('content')
        </div>
    </div>
</div>
<script src="{{asset('js/core/jquery.min.js')}}"></script>
<script src="{{asset('js/core/popper.min.js')}}"></script>
<script src="{{asset('js/core/bootstrap.min.js')}}"></script>
<script src="{{asset('js/plugins/perfect-scrollbar.jquery.min.js')}}"></script>
<script src="{{asset('js/plugins/chartjs.min.js')}}"></script>
<script src="{{asset('js/plugins/bootstrap-notify.js')}}"></script>
<script src="{{asset('js/black-dashboard.js')}}"></script>
<script src="{{asset('js/bootstrap-select.min.js')}}"></script>

@stack('js')
<script>
    @if(Session::has('success'))
    showNotification("{{Session::get('success')}}", 'success')
    @endif

    @if(Session::has('danger'))
    showNotification("{{Session::get('danger')}}", 'danger')
    @endif

    function showNotification(message, color) {
        $.notify({
            icon: "tim-icons icon-bell-55",
            message: message

        }, {
            type: color,
            timer: 8000,
            placement: {
                from: 'top',
                align: 'right'
            }
        });
    }

    $(document).ready(function () {
        $().ready(function () {
            $sidebar = $('.sidebar');
            $navbar = $('.navbar');
            $main_panel = $('.main-panel');

            $full_page = $('.full-page');

            $sidebar_responsive = $('body > .navbar-collapse');
            sidebar_mini_active = true;
            white_color = false;

            window_width = $(window).width();

            fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

            $('.switch-sidebar-mini input').on("switchChange.bootstrapSwitch", function () {
                var $btn = $(this);

                if (sidebar_mini_active == true) {
                    $('body').removeClass('sidebar-mini');
                    sidebar_mini_active = false;
                    blackDashboard.showSidebarMessage('Sidebar mini deactivated...');
                } else {
                    $('body').addClass('sidebar-mini');
                    sidebar_mini_active = true;
                    blackDashboard.showSidebarMessage('Sidebar mini activated...');
                }

                // we simulate the window Resize so the charts will get updated in realtime.
                var simulateWindowResize = setInterval(function () {
                    window.dispatchEvent(new Event('resize'));
                }, 180);

                // we stop the simulation of Window Resize after the animations are completed
                setTimeout(function () {
                    clearInterval(simulateWindowResize);
                }, 1000);
            });

            $('.switch-change-color input').on("switchChange.bootstrapSwitch", function () {
                var $btn = $(this);

                if (white_color == true) {

                    $('body').addClass('change-background');
                    setTimeout(function () {
                        $('body').removeClass('change-background');
                        $('body').removeClass('white-content');
                    }, 900);
                    white_color = false;
                } else {

                    $('body').addClass('change-background');
                    setTimeout(function () {
                        $('body').removeClass('change-background');
                        $('body').addClass('white-content');
                    }, 900);

                    white_color = true;
                }
            });
        });
    });

    $(".form-check-input").change(function () {
        $(this).val(this.checked ? 1 : 0)
    });

    $(".clear-multiselect").on('click', function () {
        $(this).next().children().first().selectpicker('deselectAll')
    })

    @if(isset($pageHasTable))
    $(document).ready(function () {
        fetch();
    });

    $('#column, #order, #custom-page, #limit, .filters select').on('change', fetch);

    let searchTimeout;
    $('#search').on('keyup', function () {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function () {
            fetch();
        }, 350);
    });

    $('#next-page').on('click', function () {
        fetch(parseInt($('#custom-page').val()) + 1);
    });

    $('#previous-page').on('click', function () {
        fetch(parseInt($('#custom-page').val()) - 1);
    });

    $('.first-last-button').on('click', function () {
        fetch($(this).data('page'));
    });

    function fetch(page = 0) {
        $('.table-body').html('<div class="d-flex justify-content-center"><div class="spinner-border" role="status"></div></div>')
        let customPage = $('#custom-page');
        page = page > 0 ? page : customPage.val();

        let filter = {}
        $(".filters select").each(function () {
            let type = $(this).data('type')

            if (!filter[type]) {
                filter[type] = {};
            }

            filter[type][$(this).attr('id').substring(7)] = $(this).val();
        });

        $.ajax({
            url: "{{ route('table.fetch' , ['tableName' => $tableName]) }}",
            type: "POST",
            data: JSON.stringify({
                "_token": '{{ csrf_token() }}',
                "column": $("#column").val(),
                "order": $("#order").val(),
                "search": $("#search").val(),
                "limit": $("#limit").val(),
                "filter": filter,
                "page": page,
            }),
            dataType: 'json',
            contentType: 'application/json',
            success: function (res) {
                $('.table-body').html(res.html);
                customPage.html('');
                for ($i = 1; $i <= res.lastPage; $i++) {
                    customPage.append('<option value="' + $i + '" ' + ($i === res.currentPage ? 'selected' : '') + '>' + $i + '</option>');
                }
                customPage.selectpicker('refresh');
                customPage.selectpicker('val', res.currentPage);
                $('#last-page').attr('data-page', res.lastPage);
            },
        });
    }
    @endif
</script>
@stack('js.end')
</body>
</html>
