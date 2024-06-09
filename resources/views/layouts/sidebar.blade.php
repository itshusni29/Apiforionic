<aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ asset('skodash/assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">Skodash</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class="bi bi-chevron-double-left"></i></div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{ route('home') }}">
                <div class="parent-icon"><i class="bi bi-house-door"></i></div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        <li class="menu-label">Menu</li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-award"></i></div>
                <div class="menu-title">Users</div>
            </a>
            <ul>
                <li><a href="{{ route('users.index') }}"><i class="bi bi-arrow-right-short"></i>List</a></li>
                <li><a href="{{ route('users.create') }}"><i class="bi bi-arrow-right-short"></i>Add</a></li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-award"></i></div>
                <div class="menu-title">Books</div>
            </a>
            <ul>
                <li><a href="{{ route('books.index') }}"><i class="bi bi-arrow-right-short"></i>List</a></li>
                <li><a href="{{ route('books.create') }}"><i class="bi bi-arrow-right-short"></i>Add</a></li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-award"></i></div>
                <div class="menu-title">Loans</div>
            </a>
            <ul>
                <li><a href="{{ route('borrowed.books.all') }}"><i class="bi bi-arrow-right-short"></i>List</a></li>
                <li><a href="{{ route('borrow.form') }}"><i class="bi bi-arrow-right-short"></i>Add</a></li>
            </ul>
        </li>

        <li class="menu-label">Others</li>
        
        <li>
            <a href="https://codervent.com/skodash/documentation/index.html" target="_blank">
                <div class="parent-icon"><i class="bi bi-file-earmark-code"></i></div>
                <div class="menu-title">Documentation</div>
            </a>
        </li>
        <li>
            <a href="https://themeforest.net/user/codervent" target="_blank">
                <div class="parent-icon"><i class="bi bi-headset"></i></div>
                <div class="menu-title">Support</div>
            </a>
        </li>
    </ul>
    <!--end navigation-->
</aside>
