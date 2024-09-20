@php
    use App\Helpers\UserHelper;

@endphp

<aside class="page-sidebar">
    <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
    <div class="main-sidebar" id="main-sidebar">
        <ul class="sidebar-menu" id="simple-bar">
            <li class="pin-title sidebar-main-title">
                <div>
                    <h5 class="sidebar-title f-w-700">Pinned</h5>
                </div>
            </li>

            <li class="sidebar-list"> <i class="fa-solid fa-thumbtack"></i>
                <a class="sidebar-link" href="/">
                    <svg class="stroke-icon">
                        <use href="{{ asset('assets/svg/iconly-sprite.svg#Message') }}"></use>
                    </svg>
                    <h6 class="f-w-600">Dashboards</h6>
                </a>
            </li>


            <li class="sidebar-main-title">
                <div>
                    <h5 class="f-w-700 sidebar-title pt-3">Application</h5>
                </div>
            </li>
            @if( UserHelper::userCan(['create_user', 'edit_user','delete_user','update_user'], false))
            <li class="sidebar-list"> <i class="fa-solid fa-thumbtack"></i><a class="sidebar-link"
                    href="javascript:void(0)">
                    <svg class="stroke-icon">
                        <use href="../assets/svg/iconly-sprite.svg#Info-circle"></use>
                    </svg>
                    <h6 class="f-w-600">Users</h6><i class="iconly-Arrow-Right-2 icli"></i>
                </a>
                <ul class="sidebar-submenu">

                    <li class=""><a class="submenu-title" href="javascript:void(0)">Permissions<i
                                class="iconly-Arrow-Right-2 icli"> </i></a>
                        <ul class="according-submenu" style="display: none;">
                            <li> <a href="{{ route('permissions.create') }}">Add</a></li>
                            <li> <a href="{{ route('permissions.index') }}">List</a></li>
                        </ul>
                    </li>
                    <li class=""><a class="submenu-title" href="javascript:void(0)">Roles<i
                                class="iconly-Arrow-Right-2 icli"> </i></a>
                        <ul class="according-submenu" style="display: none;">
                            <li> <a href="{{ route('roles.create') }}">Add</a></li>
                            <li> <a href="{{ route('roles.index') }}">List</a></li>
                        </ul>
                    </li>
                    <li class=""><a class="submenu-title" href="javascript:void(0)">Users<i
                                class="iconly-Arrow-Right-2 icli"> </i></a>
                        <ul class="according-submenu" style="display: none;">
                            <li> <a href="{{ route('users.create') }}">Add</a></li>
                            <li> <a href="{{ route('users.index') }}">List</a></li>
                        </ul>
                    </li>


                </ul>


            </li>
            @endif

            <li class="sidebar-list"> <i class="fa-solid fa-thumbtack"></i><a class="sidebar-link"
                    href="javascript:void(0)">
                    <svg class="stroke-icon">
                        <use href="{{ asset('assets/svg/iconly-sprite.svg#Chat') }}"></use>
                    </svg>
                    <h6 class="f-w-600">Books</h6><i class="iconly-Arrow-Right-2 icli"> </i>
                </a>
                <ul class="sidebar-submenu" style="display: none;">
                    @if( UserHelper::userCan(['create_book_sentence', 'delete_book_sentence','read_book_sentence','update_book_sentence']))
                    <li> <a href="{{ route('book.create') }}">Add</a></li>
                    @endif
                    @if( UserHelper::userCan(['create_book_sentence','read_book_sentence'], false))
                    <li> <a href="{{ route('book.index') }}">List</a></li>
                    @endif
                </ul>
            </li>






        </ul>
    </div>
    <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
</aside>
