<aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ asset('skodash/assets/images/logo.png') }}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">kutbuk.app</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class="bi bi-chevron-double-left"></i></div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{ route('home') }}">
                <div class="parent-icon"><i class="bi bi-house-door"></i></div>
                <div class="menu-title">Beranda</div>
            </a>
        </li>
        <li class="menu-label">Menu</li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="lni lni-user"></i></div>
                <div class="menu-title">Pengguna</div>
            </a>
            <ul>
                <li><a href="{{ route('users.index') }}"><i class="bi bi-arrow-right-short"></i>Daftar Pengguna</a></li>
                <li><a href="{{ route('users.create') }}"><i class="bi bi-arrow-right-short"></i>Tambah</a></li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="lni lni-book"></i></div>
                <div class="menu-title">Buku</div>
            </a>
            <ul>
                <li><a href="{{ route('books.index') }}"><i class="bi bi-arrow-right-short"></i>Daftar Buku</a></li>
                <li><a href="{{ route('books.create') }}"><i class="bi bi-arrow-right-short"></i>Tambah Buku</a></li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="lni lni-blackboard"></i></div>
                <div class="menu-title">Pinjaman</div>
            </a>
            <ul>
                <li><a href="{{ route('borrowed.books.all') }}"><i class="bi bi-arrow-right-short"></i>Daftar Peminjam</a></li>
                <li><a href="{{ route('borrowed.books.by.book') }}"><i class="bi bi-arrow-right-short"></i>Daftar Buku Dipinjam</a></li>
                <li><a href="{{ route('borrow.form') }}"><i class="bi bi-arrow-right-short"></i>Tambah</a></li>
            </ul>
        </li>

        <li class="menu-label">Lainnya</li>
        
        <li>
            <a href="https://codervent.com/skodash/documentation/index.html" target="_blank">
                <div class="parent-icon"><i class="bi bi-file-earmark-code"></i></div>
                <div class="menu-title">Dokumentasi</div>
            </a>
        </li>
        <li>
            <a href="https://themeforest.net/user/codervent" target="_blank">
                <div class="parent-icon"><i class="bi bi-headset"></i></div>
                <div class="menu-title">Layanan</div>
            </a>
        </li>
    </ul>
    <!--end navigation-->
</aside>
