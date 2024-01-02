<div id="app">
    <div id="sidebar">
        <div class="sidebar-wrapper active">
            <div class="logo text-white ">
                <a href='/{{ $role }}' style="font-size:1.5rem;">
                    <div class="p-2 d-flex justify-content-center" style="background-color: #1E1E2D; width:100%;">
                        <img src="{{ asset('./storage/img/logo/' . $identitas->logo) }}"
                            style="width: 60px; height: 60px;" alt="Logo">
                    </div>
                </a>
            </div>
            <div class="sidebar-header position-relative">
                <div class="d-flex flex-wrap justify-content-end align-items-center">
                    <div class="logo-and-toggle">
                        <div class="theme-toggle d-flex gap-2 align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                aria-hidden="true" role="img" class="iconify iconify--system-uicons" width="20"
                                height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                                <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                        opacity=".3"></path>
                                    <g transform="translate(-210 -1)">
                                        <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                        <circle cx="220.5" cy="11.5" r="4"></circle>
                                        <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2">
                                        </path>
                                    </g>
                                </g>
                            </svg>
                            <div class="form-check form-switch fs-6">
                                <input class="form-check-input  me-0" type="checkbox" id="toggle-dark"
                                    style="cursor: pointer">
                                <label class="form-check-label"></label>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                aria-hidden="true" role="img" class="iconify iconify--mdi" width="20"
                                height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                                </path>
                            </svg>
                        </div>
                    </div>

                    <div class="sidebar-toggler  x">
                        <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                    </div>
                </div>
            </div>
            <div class="sidebar-menu" style="margin-top: -30px;">
                <ul class="menu">
                    <li class="sidebar-title">Menu</li>

                    <li class="sidebar-item {{ $title === 'Dashboard' ? 'active' : '' }}">
                        <a href="{{ route('dashboard.kasir') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ $title === 'Cashier' ? 'active' : '' }}">
                        <a href="{{ route('kasir.transaksi.index') }}" class='sidebar-link'>
                            <i class="bi bi-receipt-cutoff"></i>
                            <span>Cashier</span>
                        </a>
                    </li>

                    <li class="sidebar-title">Data</li>

                    <li
                        class="sidebar-item has-sub {{ $title === 'Products' || $title === 'Suppliers' || $title === 'Categories' ? 'active' : '' }}">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-collection-fill"></i>
                            <span>Product Catalogue</span>
                        </a>

                        <ul class="submenu">
                            <li class="submenu-item {{ $title === 'Categories' ? 'active' : '' }}">
                                <a href="{{ route($role . '.kategori.index') }}" class="submenu-link">Categories</a>
                            </li>

                            <li class="submenu-item {{ $title === 'Products' ? 'active' : '' }}">
                                <a href="{{ route($role . '.produk.index') }}" class="submenu-link">Products</a>
                            </li>
                        </ul>

                    </li>

                    <li
                        class="sidebar-item has-sub {{ $title === 'Purchase' || $title === 'Transaction History' || $title === 'Discounts' || $title == 'Suppliers' ? 'active' : '' }}">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-cash-coin"></i>
                            <span>Transactions</span>
                        </a>

                        <ul class="submenu">

                            <li class="submenu-item  {{ $title === 'Discounts' ? 'active' : '' }}">
                                <a href="{{ route('kasir.diskon.index') }}" class='submenu-link'>
                                    Discounts
                                </a>
                            </li>

                            <li class="submenu-item  {{ $title === 'Purchase' ? 'active' : '' }}">
                                <a href="{{ route('kasir.pembelian.index') }}" class="submenu-link">
                                    Purchase
                                </a>
                            </li>

                            <li class="submenu-item {{ $title === 'Suppliers' ? 'active' : '' }}">
                                <a href="{{ route($role . '.supplier.index') }}" class="submenu-link">Suppliers</a>
                            </li>

                            <li class="submenu-item  {{ $title === 'Transaction History' ? 'active' : '' }}">
                                <a href="{{ route('kasir.riwayat_transaksi') }}" class="submenu-link">Transaction
                                    History
                                </a>
                            </li>
                        </ul>

                    </li>



                    <li class="sidebar-title">Other</li>

                    <li
                        class="sidebar-item has-sub {{ $title === 'Admin Report' || $title === 'Cashier Report' || $title === 'Owner Report' || $title === 'Purchase Report' || $title === 'Transaction Report' ? 'active' : '' }}">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-file-bar-graph-fill"></i>
                            <span>Reports</span>
                        </a>

                        <ul class="submenu ">

                            <li class="submenu-item {{ $title === 'Purchase Report' ? 'active' : '' }} ">
                                <a href="{{ route('report.pembelian', $role) }}" class="submenu-link">Purchase
                                    Report</a>
                            </li>

                            <li class="submenu-item {{ $title === 'Transaction Report' ? 'active' : '' }} ">
                                <a href="{{ route('report.transaksi', $role) }}" class="submenu-link">Transaction
                                    Report</a>
                            </li>

                            <li
                                class="submenu-item has-sub {{ $title === 'Admin Report' || $title === 'Cashier Report' || $title === 'Owner Report' ? 'active' : '' }}">
                                <a href="#" class="submenu-link">User Report</a>

                                <ul class="submenu submenu-level-2">
                                    <li class="submenu-item {{ $title === 'Admin Report' ? 'active' : '' }}">
                                        <a href="{{ route('report.admin', $role) }}" class="submenu-link">Admin
                                            Report</a>
                                    </li>

                                    <li class="submenu-item {{ $title === 'Cashier Report' ? 'active' : '' }}">
                                        <a href="{{ route('report.kasir', $role) }}" class="submenu-link">Cashier
                                            Report</a>
                                    </li>

                                    <li class="submenu-item {{ $title === 'Owner Report' ? 'active' : '' }}">
                                        <a href="{{ route('report.owner', $role) }}" class="submenu-link">Owner
                                            Report</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-item">
                        <a href="#" class='sidebar-link' onclick="confirmLogout()">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Logout</span>
                        </a>
                    </li>

                    <script>
                        function confirmLogout() {
                            var isConfirmed = confirm('Are you sure to logout?');
                            if (isConfirmed) {
                                window.location.href = '{{ route('logout') }}';
                            }
                        }
                    </script>
                </ul>
            </div>
        </div>
    </div>
