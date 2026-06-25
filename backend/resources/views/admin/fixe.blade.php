@php
    $config = DB::table('configs')->select('icon', 'logo')->first();
@endphp
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> @yield('titre') - (Admin) {{ config('app.name') }}</title>
    <!--favicon-->
    <link rel="icon" href="{{ Storage::url($config->icon) }}" type="image/png" />

    <!--plugins-->
    <link href="/admin/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="/admin/assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet">
    <link href="/admin/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet">
    <!-- loader-->
    <link href="/admin/assets/css/pace.min.css" rel="stylesheet">
    <script src="/admin/assets/js/pace.min.js"></script>
    <!--Styles-->
    <link href="/admin/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/admin/assets/css/icons.css">

    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="/admin/assets/css/main.css" rel="stylesheet">
    <link href="/admin/assets/css/dark-theme.css" rel="stylesheet">
    <link href="/admin/assets/css/semi-dark-theme.css" rel="stylesheet">
    <link href="/admin/assets/css/minimal-theme.css" rel="stylesheet">
    <link href="/admin/assets/css/shadow-theme.css" rel="stylesheet">


    <link rel="stylesheet" href="{{ asset('admin-css.css?v=') . time() }}">
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    @yield('header')



    <script>
        function url(url) {
            document.location.href = url;
        }

        function url2(url) {
            window.open(url, '_blank');
        }

        function toggle_confirmation(productId) {
            const confirmBtn = document.getElementById('confirmBtn' + productId);
            if (!confirmBtn.classList.contains('d-none')) {
                confirmBtn.classList.add('d-none');
            } else {
                // Masquer tous les autres boutons de confirmation s'ils sont visibles
                document.querySelectorAll('.confirm-btn').forEach(btn => {
                    if (!btn.classList.contains('d-none')) {
                        btn.classList.add('d-none');
                    }
                });
                confirmBtn.classList.remove('d-none');
            }
        }



        function preview_illustration(key) {
            const fileInput = document.getElementById('file-input-' + key);
            fileInput.click();
        }



        var old_total = 0;

        function fetchNotificationsAndUpdateComponent() {
            // Appel AJAX pour récupérer les données du contrôleur
            fetch('{{ route('live_notifications') }}')
                .then(response => response.json())
                .then(data => {
                    const total = data.total;
                    // ,set value in msg-count span select by class name
                    document.querySelector('.msg-count').textContent = total;
                    // Vérifier si le total est supérieur à l'ancien total
                    if (total > old_total) {
                        // Jouer l'audio uniquement s'il y a une nouvelle notification
                        const audio = new Audio('/icons/system-notification-199277.wav');
                        // const audio = new Audio('/icons/maribelle.wav');
                        audio.play();
                        // Actualiser le composant Livewire
                        Livewire.dispatch('notificationUpdated');
                        // Mettre à jour l'ancien total avec le nouveau total
                        old_total = total;
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de la récupération des notifications :', error);
                });
        }

        // Exécuter la fonction toutes les 5 secondes
        setInterval(fetchNotificationsAndUpdateComponent, 6000);
    </script>



</head>

<!--start header-->
<header class="top-header">
    <nav class="navbar navbar-expand justify-content-between">
        <div class="btn-toggle-menu">
            <span class="material-symbols-outlined">menu</span>
        </div>
        <div class="position-relative search-bar d-lg-block d-none" data-bs-toggle="modal"
            data-bs-target="#exampleModal">
            <input class="form-control form-control-sm rounded-5 px-5" disabled type="search" placeholder="Search">
            <span
                class="material-symbols-outlined position-absolute ms-3 translate-middle-y start-0 top-50">search</span>
        </div>
        <ul class="navbar-nav top-right-menu gap-2">
            <li class="nav-item d-lg-none d-block" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <a class="nav-link" href="javascript:;"><span class="material-symbols-outlined">
                        search
                    </span></a>
            </li>
            {{--  <li class="nav-item dark-mode">
              <a class="nav-link dark-mode-icon" href="javascript:;"><span class="material-symbols-outlined">dark_mode</span></a>
            </li> --}}
            <li class="nav-item">
                <a class="nav-link dark-mode" href="javascript:;">
                    <span class="material-symbols-outlined">dark_mode</span>
                </a>
            </li>





            <li class="nav-item dropdown dropdown-app">

                <div class="dropdown-menu dropdown-menu-end mt-lg-2 p-0">
                    <div class="app-container p-2 my-2">
                        <div class="row gx-0 gy-2 row-cols-3 justify-content-center p-2">



                        </div>
                    </div>
            </li>
            <li class="nav-item dropdown dropdown-large">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;"
                    data-bs-toggle="dropdown">
                    <div class="position-relative">
                        <span class="notify-badge msg-count">0</span>
                        <span class="material-symbols-outlined  msg-count">
                            Notifications
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end mt-lg-2">
                    <a href="javascript:;">
                        <div class="msg-header">
                            <p class="msg-header-title">Notifications</p>
                            <p class="msg-header-clear ms-auto"> Notifications sur {{ config('app.name') }}.</p>
                        </div>
                    </a>

                    @livewire('AdminNotifications')





                    <a href="javascript:;">
                        <div class="text-center msg-footer">View All</div>
                    </a>
                </div>
            </li>



            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="offcanvas" href="#ThemeCustomizer"><span
                        class="material-symbols-outlined">
                        settings
                    </span></a>
            </li>






        </ul>


    </nav>
</header>

<!--start sidebar-->
<aside class="sidebar-wrapper">
    <div class="sidebar-header">
        <div class="logo-icon">
            <img href="{{ Storage::url($config->icon) }}"class="logo-img" alt="">
        </div>
        <div class="logo-name flex-grow-1">
            <h5 class="mb-0"> {{ config('app.name') }}</h5>
        </div>
        <div class="sidebar-close ">
            <span class="material-symbols-outlined">close</span>
        </div>
    </div>
    <div class="sidebar-nav" data-simplebar="true">

        <!--navigation-->
        <ul class="metismenu" id="menu">
            <li>
                <a href="{{ route('dashboard') }}">
                    <div class="parent-icon"><span class="material-symbols-outlined">home</span>
                    </div>
                    <div class="menu-title">Dashboard</div>
                </a>
            </li>

            <li>
                <a href="{{ route('cats.index') }}">
                    <div class="parent-icon"><span class="material-symbols-outlined">widgets</span>
                    </div>
                    <div class="menu-title">Categories</div>
                </a>
            </li>
  

            <li>
                <a href="{{ route('transports') }}">
                    <div class="parent-icon icon-color-3">
                        <i class="ri-truck-fill"></i>
                    </div>
                    <div class="menu-title">
                        Les frais de transport
                    </div>
                </a>
            </li>

            <li class="{{ request()->routeIs('coupons*') || request()->routeIs('coupon.*') ? 'mm-active' : '' }}">

                <a href="javascript:;" class="has-arrow">

                    <div class="parent-icon icon-color-3">
                        <i class="ri-coupon-3-fill"></i>
                    </div>

                    <div class="menu-title">
                        Les codes promo
                    </div>

                </a>

                <ul>

                    <li class="{{ request()->routeIs('coupons') ? 'mm-active' : '' }}">
                        <a href="{{ route('coupons') }}">
                            <i class="bx bx-right-arrow-alt"></i>
                            Liste des coupons
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('coupon.add') ? 'mm-active' : '' }}">
                        <a href="{{ route('coupon.add') }}">
                            <i class="bx bx-right-arrow-alt"></i>
                            Créer un coupon
                        </a>
                    </li>

                </ul>

            </li>

            <li>
                <a href="javascript:;" class="has-arrow">
                  

                    <div class="parent-icon"><span class="material-symbols-outlined">redeem</span>
                    </div>
                    <div class="menu-title">Catalogues</div>
                </a>
                <ul>
                    <li> <a href="{{ route('produit.add') }}"><span
                                class="material-symbols-outlined">arrow_right</span>Ajouter Produit</a>
                    </li>
                    <li> <a href="{{ route('produits') }}"><span
                                class="material-symbols-outlined">arrow_right</span>Liste</a>
                    </li>
                    <li> <a href="{{ route('promotions') }}"><span
                                class="material-symbols-outlined">arrow_right</span>Promotion</a>
                    </li>


                </ul>
            </li>

            <li>
                <a href="{{ route('commandes') }}">
                    <div class="parent-icon"><span class="material-symbols-outlined">shopping_cart</span>
                    </div>
                    <div class="menu-title">Commandes</div>
                </a>
            </li>







           <li class="{{ request()->routeIs('clients') || request()->routeIs('personnels') ? 'mm-active' : '' }}">

    <a href="javascript:;" class="has-arrow">

        <div class="parent-icon icon-color-3">
            <i class="ri-team-fill"></i>
        </div>

        <div class="menu-title">
            Personnels & Clients
        </div>

    </a>

    <ul>

        {{-- Clients --}}
        <li class="{{ request()->routeIs('clients') ? 'mm-active' : '' }}">
            <a href="{{ route('clients') }}">
                <i class="ri-user-3-fill"></i>
                Clients
            </a>
        </li>

        {{-- Personnel Admin seulement --}}
        @role('admin')
        <li class="{{ request()->routeIs('personnels') ? 'mm-active' : '' }}">
            <a href="{{ route('personnels') }}">
                <i class="ri-user-settings-fill"></i>
                Gestion du personnel
            </a>
        </li>
        @endrole

    </ul>

</li>

     

<li class="{{ request()->routeIs('admin_contact_form') || request()->routeIs('testimonials') ? 'mm-active' : '' }}">

    <a href="javascript:;" class="has-arrow">

        <div class="parent-icon icon-color-5">
            <i class="ri-customer-service-2-fill"></i>
        </div>

        <div class="menu-title">
            Communication
        </div>

    </a>

    <ul>

        {{-- Contacts --}}
        <li class="{{ request()->routeIs('admin_contact_form') ? 'mm-active' : '' }}">
            <a href="{{ route('admin_contact_form') }}">
                <i class="ri-mail-fill"></i>
                Contacts
            </a>
        </li>

        {{-- Témoignages --}}
        <li class="{{ request()->routeIs('testimonials') ? 'mm-active' : '' }}">
            <a href="{{ route('testimonials') }}">
                <i class="ri-chat-quote-fill"></i>
                Témoignages
            </a>
        </li>

    </ul>

</li>


 @can('setting_view')

<li class="{{ request()->routeIs('contact-admin') || request()->routeIs('banner.*') ? 'mm-active' : '' }}">

    <a href="javascript:;" class="has-arrow">

        <div class="parent-icon icon-color-6">
            <i class="ri-settings-3-fill"></i>
        </div>

        <div class="menu-title">
            Configurations
        </div>

    </a>

    <ul>

        {{-- Informations --}}
        <li class="{{ request()->routeIs('contact-admin') ? 'mm-active' : '' }}">
            <a href="{{ route('contact-admin') }}">
                <i class="ri-information-fill"></i>
                Informations
            </a>
        </li>

        {{-- Bannières --}}
        <li class="{{ request()->routeIs('banner.*') ? 'mm-active' : '' }}">
            <a href="{{ route('banner.index') }}">
                <i class="ri-image-fill"></i>
                Bannières
            </a>
        </li>

    </ul>

</li>

@endcan


        </ul>
        <!--end navigation-->


    </div>
    <div class="sidebar-bottom dropdown dropup-center dropup">
        <div class="dropdown-toggle d-flex align-items-center px-3 gap-3 w-100 h-100" data-bs-toggle="dropdown">
            <div class="user-img">
                <img src="{{ Auth::user()->avatar() }}" alt="">
            </div>
            <div class="user-info">
                <h5 class="mb-0 user-name"> {{ Auth::user()->nom }}</h5>
                <p class="mb-0 user-designation">Cnnecté</p>
            </div>
        </div>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="{{ route('parametres') }}"><span
                        class="material-symbols-outlined me-2">
                        account_circle
                    </span><span>Profile</span></a>
            </li>


            <li>
                <a class="dropdown-item d-flex align-items-center" href="{{ route('home') }}">
                    <span class="material-symbols-outlined me-2">home</span>
                    <span>Accueil</span>
                </a>
            </li>



            <li>
                <div class="dropdown-divider mb-0"></div>
            </li>
            <li><a class="dropdown-item" href="{{ route('logout') }}"><span class="material-symbols-outlined me-2">
                        logout
                    </span><span>Déconnexion</span></a>
            </li>
        </ul>
    </div>
</aside>
<!--end header-->


<body>
    <!-- wrapper -->
    <div>

        <div class="page-wrapper">

            @yield('body')


        </div>
        <!-- END wrapper -->


        <!--end page-content-wrapper-->
    </div>
    <!--end page-wrapper-->
    <!--start overlay-->
    <div class="overlay toggle-btn-mobile"></div>
    <!--end overlay-->
    <!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i
            class='bx bxs-up-arrow-alt'></i></a>
    <!--End Back To Top Button-->
    <!--footer -->
    <div class="footer">
        <p class="mb-0">@ {{ date('Y') }} | Developed By :
            <a href="#" target="_blank" style="color: #c71f17 !important;">
                <strong>
                    TURBOSOFT
                </strong>
            </a>
        </p>
    </div>
    <!-- end footer -->
    </div>
    <!-- end wrapper -->
    <!-- Bootstrap JS -->
    <script src="/admin/assets/js/jquery.min.js"></script>
    <script src="/admin/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <script src="/admin/assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="/admin/assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="/admin/assets/plugins/apex/apexcharts.min.js"></script>
    <script src="/admin/assets/js/index.js"></script>
    <!--BS Scripts-->
    <script src="/admin/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/admin/assets/js/main.js"></script>
    @stack('scripts')

    @if (auth()->user()->is_admin)
        <script>
            function sendMarkRequest(id = null) {
                return $.ajax("{{ route('markNotification') }}", {
                    method: 'POST',
                    data: {
                        _token,
                        id
                    }
                });
            }
            $(function() {
                $('.mark-as-read').click(function() {
                    let request = sendMarkRequest($(this).data('id'));
                    request.done(() => {
                        $(this).parents('div.alert').remove();
                    });
                });
                $('#mark-all').click(function() {
                    let request = sendMarkRequest();
                    request.done(() => {
                        $('div.alert').remove();
                    })
                });
            });
        </script>
    @endif
</body>

</html>
