<header>
    <div class="container d-flex justify-content-between align-items-center">
        <div class="d-flex">
          <a href="http://localhost:5174/">
            <div class="logo-box d-flex">
              <img src="{{ Vite::asset('resources/assets/logo.png') }}" alt="logo" />
            </div>
          </a>
          <div class="title align-self-center">BoolBnB</div>
        </div>
        <div class="gap-2 d-flex align-items-center">
            <ul class="navbar-nav d-flex ms-auto mb-2 mb-lg-0">
                @guest
                <li>
                    <ul class="login-box d-flex">
                        <li>
                            <a class="nav-link login" href="{{ route('login') }}">Accedi</a>
                        </li>
                        @if (Route::has('register'))
                            <li>
                                <a class="nav-link register" href="{{ route('register') }}">Registrati</a>
                            </li>
                        @endif
                    </ul>
                </li>
                @else
                <li class="user dropdown">
                    <a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle"
                    data-bs-toggle="dropdown" href="#" id="navbarDropdown" role="button" v-pre>
                    <i class="fa-solid fa-circle-user"></i>
                            {{ Auth::user()->name }}
                        </a>
                        <div aria-labelledby="navbarDropdown" class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ route('admin.apartments.index') }}"> I miei appartamenti</a>
                            {{-- <a class="dropdown-item" href="{{ url('profile') }}"> Profilo</a> --}}
                            <a class="dropdown-item" href="{{ route('logout') }}" id="logout-link">
                                Esci
                            </a>
                            <form action="{{ route('logout') }}" class="d-none" id="logout-form" method="POST">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
      </div>
</header>
{{-- <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container ">
        <a class="navbar-brand" href="#">Boolbnb</a>
        <button aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"
            class="navbar-toggler" data-bs-target="#navbarSupportedContent" data-bs-toggle="collapse" type="button">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a @class(['nav-link', 'active' => Route::currentRouteName() == 'home']) aria-current="page" href="{{ route('home') }}">Home</a>
                </li>
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Accedi</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Registrati</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle"
                            data-bs-toggle="dropdown" href="#" id="navbarDropdown" role="button" v-pre>
                            {{ Auth::user()->name }}
                        </a>
                        <div aria-labelledby="navbarDropdown" class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}"> Dashboard</a>
                            <a class="dropdown-item" href="{{ url('profile') }}"> Profilo</a>
                            <a class="dropdown-item" href="{{ route('logout') }}" id="logout-link">
                                Esci
                            </a>
                            <form action="{{ route('logout') }}" class="d-none" id="logout-form" method="POST">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav> --}}
