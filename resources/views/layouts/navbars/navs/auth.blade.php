<div class="col-12">
    <div class="text-center">

        <a href="{{route('sales.index')}}" class="btn btn-sm btn-primary btn-simple" >
            <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Ventas</span>
            <span class="d-block d-sm-none">
                <i class="tim-icons icon-bag-16"></i>
            </span>
        </a>
        <a href="{{route('receipts.index')}}" class="btn btn-sm btn-primary btn-simple" >
            <input type="radio" class="d-none d-sm-none" name="options">
            <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Compras</span>
            <span class="d-block d-sm-none">
                <i class="tim-icons icon-basket-simple"></i>
            </span>
        </a>
        <a href="{{route('products.index')}}" class="btn btn-sm btn-primary btn-simple" >
            <input type="radio" class="d-none" name="options">
            <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Productos</span>
            <span class="d-block d-sm-none">
                <i class="tim-icons icon-app"></i>
            </span>
        </a>

    </div>
</div>

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

        </div>


        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
        </button>
        <div class="collapse navbar-collapse" id="navigation">
            <ul class="navbar-nav ml-auto">
                <li class="dropdown nav-item">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                        <div class="photo">
                                <img src="/assets/img/bambu-logo.jpg" alt="{{ __('Profile Photo') }}">
                        </div>
                        <b class="caret d-none d-lg-block d-xl-block"></b>
                        <p class="d-lg-none">{{ __('Log out') }}</p>
                    </a>
                    <ul class="dropdown-menu dropdown-navbar">
                        <li class="nav-link">
                            <a href="{{ route('profile.edit') }}" class="nav-item dropdown-item">Perfil</a>
                        </li>
                        <li class="nav-link">
                            <a href="{{ route('logout') }}" class="nav-item dropdown-item" onclick="event.preventDefault();  document.getElementById('logout-form').submit();">Salir</a>
                        </li>
                        @if(count(session('dataBranch')) > 1)
                        <div class="dropdown-divider"></div>
                        <h6 class="dropdown-header">Sucursales</h6>
                        @foreach(session('dataBranch') as $key => $branch)
                        <li class="nav-link">
                            <a href="{{route('branch.change', $key)}}" class="nav-item dropdown-item"> {{$branch}}</a>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>