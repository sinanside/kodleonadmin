
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>{{ __('main.title') }}</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="img/admin.png">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">
   @can('isAdmin')
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark bg-dark border-bottom">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/settings" class="nav-link">{{ __('main.settings') }}</a>
            </li>

        </ul>

        <!-- SEARCH FORM -->
        <form class="form-inline ml-3">
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" @keyup="searchit" type="search" v-model="search" placeholder="{{ __('main.search') }}" aria-label="{{ __('main.search') }}">
                <div class="input-group-append">
                    <button class="btn btn-navbar" @click="searchit">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
        @endcan

    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: black" >
        <!-- Brand Logo -->
        <a href="/" class="brand-link">
            <img src="../img/logo.png" alt="logo" class="brand-image elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">Admin</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar" >
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    @if(auth()->user()->photo )
                    <img src="../img/profile/{{ auth()->user()->photo }}" class="img-circle elevation-2" alt="User Image">
                    @else
                    <img src="../img/nophoto.png" class="img-circle elevation-2" alt="User Image">
                    @endif
                </div>
                <div class="info">
                    <a href="#" class="d-block"><router-link to="/profile">{{ auth()->user()->name }}</router-link></a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    @can('isAdmin')
                    <li class="nav-item">
                        <router-link to="/dashboard" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt blue"></i>
                            <p>
                                {{ __('main.dashboard') }}
                            </p>
                        </router-link>
                    </li>

                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-baseball-ball white"></i>
                                <p>
                                    İçerik Yöneticisi
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <router-link to="/hizmettur" class="nav-link">
                                        <i class="fas fa-angle-right nav-icon cyan"></i>
                                        <p>Hizmet Yönetimi</p>
                                    </router-link>
                                </li>
                            </ul>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <router-link to="/althizmettur" class="nav-link">
                                        <i class="fas fa-angle-right nav-icon cyan"></i>
                                        <p>Alt Hizmet Yönetimi</p>
                                    </router-link>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <router-link to="/icerikolustur" class="nav-link">
                                        <i class="fas fa-angle-right nav-icon cyan"></i>
                                        <p>İçerik Oluştur</p>
                                    </router-link>
                                </li>
                            </ul>

                        </li>

                        <!-- MENÜ - KAYITLAR  -->

                        <!--<li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-user-clock yellow"></i>
                                <p>
                                    {{ __('main.register') }}
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <router-link to="/regs" class="nav-link">
                                        <i class="fas fa-angle-right nav-icon cyan"></i>
                                        <p>Teklifler</p>
                                    </router-link>
                                </li>
                            </ul>

                        </li>-->

                        <!-- MENÜ - KAYITLAR BİTİŞ  -->

                       <!-- <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-home blue"></i>
                                <p>
                                    Sayfalar
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <router-link to="/sayfaolustur" class="nav-link">
                                        <i class="fas fa-angle-right nav-icon cyan"></i>
                                        <p>Sayfa Oluştur</p>
                                    </router-link>
                                </li>
                            </ul>

                        </li>-->

                       <!-- <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-cogs red"></i>
                                <p>
                                    Şubeler
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <router-link to="/affiliates" class="nav-link">
                                        <i class="fas fa-angle-right nav-icon cyan"></i>
                                        <p>Şube Oluştur</p>
                                    </router-link>
                                </li>
                            </ul>

                        </li>-->

                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-desktop pink"></i>
                                <p>
                                    {{ __('main.carousel') }}
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <router-link to="/carousel" class="nav-link">
                                        <i class="fas fa-angle-right nav-icon indigo"></i>
                                        <p>{{ __('main.carouselmain') }}</p>
                                    </router-link>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <router-link to="/carouselalt" class="nav-link">
                                        <i class="fas fa-angle-right nav-icon indigo"></i>
                                        <p>{{ __('carousel.carouselalt') }}</p>
                                    </router-link>
                                </li>
                            </ul>

                        </li>

                       <!-- <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-question teal"></i>
                                <p>
                                    {{ __('main.sss') }}
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <router-link to="/sss" class="nav-link">
                                        <i class="fas fa-angle-right nav-icon indigo"></i>
                                        <p>
                                            {{ __('sss.list') }}
                                        </p>
                                    </router-link>
                                </li>
                            </ul>
                        </li>-->

                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-blog orange"></i>
                                <p>
                                    {{ __('main.blog') }}
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <router-link to="/blogolustur" class="nav-link">
                                        <i class="fas fa-folder-plus nav-icon green"></i>
                                        <p>{{ __('main.blogpost') }}</p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/makaleyorumlari" class="nav-link">
                                        <i class="fas fa-folder-plus nav-icon blue"></i>
                                        <p>Makale Yorumları</p>
                                    </router-link>
                                </li>
                            </ul>
                        </li>


                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-bell yellow"></i>
                                <p>
                                    Aktivite Yönetimi
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <router-link to="/activities" class="nav-link">
                                        <i class="fas fa-folder-plus nav-icon green"></i>
                                        <p>Aktiviteler</p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/activitycreator" class="nav-link">
                                        <i class="fas fa-folder-plus nav-icon blue"></i>
                                        <p>İçerikler</p>
                                    </router-link>
                                </li>
                            </ul>
                        </li>


                        <li class="nav-item">
                            <router-link to="/commentolustur" class="nav-link">
                                <i class="nav-icon fas fa-comments blue"></i>
                                <p>
                                    Site Yorumları
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/galeryolustur" class="nav-link">
                                <i class="nav-icon fas fa-images brown"></i>
                                <p>
                                   Galeri
                                </p>
                            </router-link>
                        </li>

                        <li class="nav-item">
                            <router-link to="/ourteam" class="nav-link">
                                <i class="nav-icon fas fa-users green"></i>
                                <p>
                                    Grup Üyeleri
                                </p>
                            </router-link>
                        </li>

                       <!-- <li class="nav-item">
                            <router-link to="/isortaklari" class="nav-link">
                                <i class="nav-icon fa fa-cubes lightblue"></i>
                                <p>
                                    İş Ortakları
                                </p>
                            </router-link>
                        </li>-->

                    <li class="nav-item">
                        <router-link to="/contactinfo" class="nav-link">
                            <i class="nav-icon fas fa-id-card white"></i>
                            <p>
                                {{ __('main.contactinfo') }}
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/socialmedia" class="nav-link">
                            <i class="nav-icon fas fa-user-friends cyan"></i>
                            <p>
                                {{ __('main.socialmedia') }}
                            </p>
                        </router-link>
                    </li>

                        <li class="nav-item">
                            <router-link to="/contactus" class="nav-link">
                                <i class="nav-icon fas fa-envelope red"></i>
                                <p>
                                    {{ __('contactus.title') }}
                                </p>
                            </router-link>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-cog green"></i>
                                <p>
                                    {{ __('main.management') }}
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <router-link to="/users" class="nav-link">
                                        <i class="fas fa-users nav-icon blue"></i>
                                        <p>{{ __('main.users') }}</p>
                                    </router-link>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <router-link to="/dilsecenekleri" class="nav-link">
                                        <i class="fas fa-language nav-icon blue"></i>
                                        <p>Di Seçenekleri</p>
                                    </router-link>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <router-link to="/developer" class="nav-link">
                                        <i class="fas fa-cogs nav-icon pink"></i>
                                        <p>{{ __('main.developer') }}</p>
                                    </router-link>
                                </li>
                            </ul>
                        </li>
                    @endcan

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                              <i class="nav-icon fas fa-power-off red"></i>
                            <p>
                            {{ __('main.logout') }}
                            </p>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content">
                <router-view></router-view>

                <!-- set progressbar -->
                <vue-progress-bar></vue-progress-bar>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    <!-- /.content-wrapper -->



    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
            {{ __('main.copyright') }}
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2019 <a href="https://dizaynschool.com">Dizaynschool</a>.</strong>
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

@auth
    <script>
       window.user = @json(auth()->user());
    </script>
@endauth

<script src="/js/app.js"></script>
</body>
</html>
