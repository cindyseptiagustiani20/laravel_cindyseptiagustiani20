<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Aplikasi Rumah Sakit</a>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('hospitals') }}">Data Rumah Sakit</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('patients') }}">Data Pasien</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}">Logout</a>
            </li>
        </ul>
    </div>
</nav>