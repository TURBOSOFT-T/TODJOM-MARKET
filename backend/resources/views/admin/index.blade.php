@extends('admin.fixe')
@section('titre', 'Accueil')
@section('body')

    @php
        $config = DB::table('configs')->select('icon', 'logo')->first();
    @endphp

    <!doctype html>
    <html lang="en" data-bs-theme="dark">

    <body>




        <!--end sidebar-->


        <!--start main content-->
        <main class="page-content">



            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-xl-4 row-cols-xxl-4">
                <div class="col">
                    <div class="card radius-10 border-0 border-start border-primary border-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="">
                                    <p class="mb-1">Total Commandes</p>
                                    <h4 class="mb-0 text-primary"> {{ $total_commandes }}</h4>
                                </div>
                                <div class="ms-auto widget-icon bg-primary text-white">
                                    <i class="bi bi-basket2-fill"></i>
                                </div>
                            </div>
                            <div class="progress mt-3" style="height: 4.5px;">
                                <div class="progress-bar" role="progressbar" style="width: 75%;" aria-valuenow="75"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-0 border-start border-success border-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="">
                                    <p class="mb-1">Total des ventes</p>
                                    <h4 class="mb-0 text-success"> {{ $totalDesCommandes }} {{-- <x-devise></x-devise> --}}</h4>
                                </div>
                                <div class="ms-auto widget-icon bg-success text-white">
                                    <x-devise></x-devise>
                                </div>
                            </div>
                            <div class="progress mt-3" style="height: 4.5px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 75%;"
                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-0 border-start border-danger border-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="">
                                    <p class="mb-1">Produits</p>
                                    <h4 class="mb-0 text-danger"> {{ $total_produits }}</h4>
                                </div>
                                <div class="ms-auto widget-icon bg-danger text-white">
                                    <i class="bi bi-graph-down-arrow"></i>
                                </div>
                            </div>
                            <div class="progress mt-3" style="height: 4.5px;">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 75%;"
                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card radius-10 border-0 border-start border-warning border-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="">
                                    <p class="mb-1">Total clients</p>
                                    <h4 class="mb-0 text-warning"> {{ $totalUser }}</h4>
                                </div>
                                <div class="ms-auto widget-icon bg-warning text-dark">
                                    <i class="bi bi-people-fill"></i>
                                </div>
                            </div>
                            <div class="progress mt-3" style="height: 4.5px;">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 75%;"
                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>




            </div><!--end row-->


            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header bg-transparent">
                            <div class="d-flex align-items-center">
                                <div class="">
                                    <h6 class="mb-0 fw-bold"> Profit net ( <x-devise></x-devise> )</h6>
                                </div>

                            </div>
                        </div>
                        <div class="card-body">
                            <div id="chart1" data-profilNet='@json($ventesPerMonth)'></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header bg-transparent">
                            <div class="d-flex align-items-center">
                                <div class="">
                                    <h6 class="mb-0 fw-bold"> Etat de confirmation</h6>
                                </div>

                            </div>
                        </div>
                        <div class="card-body">
                            <div id="chart2" data-confirmer=" {{ $etat_commandes['confirmer'] }}"
                                data-non_confirmer=" {{ $etat_commandes['non-confirmer'] }}"
                                data-attente=" {{ $etat_commandes['attente'] }}"></div>
                        </div>
                        <ul class="list-group list-group-flush mb-0">
                            <li
                                class="list-group-item border-top d-flex justify-content-between align-items-center bg-transparent">
                                Commandes confirmées<span class="badge bg-success rounded-pill">
                                    {{ $etat_commandes['pourcentage_confirmer'] }} %</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
                                Commandes en cours<span class="badge bg-primary rounded-pill">
                                    {{ $etat_commandes['pourcentage_attente'] }} %
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
                                Commandes non confirmées<span class="badge bg-danger rounded-pill">
                                    {{ $etat_commandes['pourcentage_non-confirmer'] }} %
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>

            </div><!--end row-->



            <div class="row">
                <div class="col-12 col-lg-12 col-xl-6">
                    <div class="card">
                        <div class="card-header bg-transparent">
                            <div class="d-flex align-items-center">
                                <div class="">
                                    <h6 class="mb-0 fw-bold"> Statistiques globale par mois</h6>
                                </div>

                            </div>
                        </div>
                        <div class="card-body">
                            <div id="chart3" data-ventesPerMonth='@json($ventesPerMonth)'
                            data-commandesPerMonth='@json($commandesPerMonth)'
                            data-visitsPerMonth='@json($visitsPerMonth)'></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-12 col-xl-6">
                    <div class="card">
                        <div class="card-header bg-transparent">
                            <div class="d-flex align-items-center">
                                <div class="">
                                    <h6 class="mb-0 fw-bold">Total des utilisateurs(Inscriptions)</h6>
                                </div>
                              
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="chart4"   data-values="@json($inscriptionMonth)"></div>
                        </div>
                    </div>
                </div>
            </div><!--end row-->



            <div class="card">
                <div class="card-body">
                    <div class="customer-table">
                     <div class="d-flex align-items-center">
                                <div class="">
                                    <h6 class="mb-0 fw-bold">Les top 10 clients </h6>
                                </div>
                              
                            </div>
                        <div class="table-responsive white-space-nowrap">
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>
                                            <input class="form-check-input" type="checkbox">
                                        </th>
                                        <th>Order Id</th>
                                        <th>Price</th>
                                        <th>Customer</th>
                                        <th>Payment Status</th>
                                        <th>Completed Payment</th>
                                        <th>Delivery Type</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input class="form-check-input" type="checkbox">
                                        </td>
                                        <td>
                                            <a href="javascript:;">#2415</a>
                                        </td>
                                        <td>$98</td>
                                        <td>
                                            <a class="d-flex align-items-center gap-3" href="javascript:;">
                                                <div class="customer-pic">
                                                    <img src="/admin/assets/images/avatars/01.png" class="rounded-circle"
                                                        width="40" height="40" alt="">
                                                </div>
                                                <p class="mb-0 customer-name fw-bold">Andrew Carry</p>
                                            </a>
                                        </td>
                                        <td><span
                                                class="lable-table bg-success-subtle text-success rounded border border-success-subtle font-text2 fw-bold">Completed<i
                                                    class="bi bi-check2 ms-2"></i></span></td>
                                        <td><span
                                                class="lable-table bg-danger-subtle text-danger rounded border border-danger-subtle font-text2 fw-bold">Failed<i
                                                    class="bi bi-x-lg ms-2"></i></span></td>
                                        <td>Cash on delivery</td>
                                        <td>Nov 12, 10:45 PM</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input class="form-check-input" type="checkbox">
                                        </td>
                                        <td>
                                            <a href="javascript:;">#7845</a>
                                        </td>
                                        <td>$110</td>
                                        <td>
                                            <a class="d-flex align-items-center gap-3" href="javascript:;">
                                                <div class="customer-pic">
                                                    <img src="/admin/assets/images/avatars/02.png" class="rounded-circle"
                                                        width="40" height="40" alt="">
                                                </div>
                                                <p class="mb-0 customer-name fw-bold">Andrew Carry</p>
                                            </a>
                                        </td>
                                        <td><span
                                                class="lable-table bg-warning-subtle text-warning rounded border border-warning-subtle font-text2 fw-bold">Pending<i
                                                    class="bi bi-info-circle ms-2"></i></span></td>
                                        <td><span
                                                class="lable-table bg-primary-subtle text-primary rounded border border-primary-subtle font-text2 fw-bold">Completed<i
                                                    class="bi bi-check2-all ms-2"></i></span></td>
                                        <td>Cash on delivery</td>
                                        <td>Nov 12, 10:45 PM</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input class="form-check-input" type="checkbox">
                                        </td>
                                        <td>
                                            <a href="javascript:;">#5674</a>
                                        </td>
                                        <td>$86</td>
                                        <td>
                                            <a class="d-flex align-items-center gap-3" href="javascript:;">
                                                <div class="customer-pic">
                                                    <img src="/admin/assets/images/avatars/03.png" class="rounded-circle"
                                                        width="40" height="40" alt="">
                                                </div>
                                                <p class="mb-0 customer-name fw-bold">Andrew Carry</p>
                                            </a>
                                        </td>
                                        <td><span
                                                class="lable-table bg-primary-subtle text-primary rounded border border-primary-subtle font-text2 fw-bold">Completed<i
                                                    class="bi bi-check2-all ms-2"></i></span></td>
                                        <td><span
                                                class="lable-table bg-danger-subtle text-danger rounded border border-danger-subtle font-text2 fw-bold">Failed<i
                                                    class="bi bi-x-lg ms-2"></i></span></td>
                                        <td>Cash on delivery</td>
                                        <td>Nov 12, 10:45 PM</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input class="form-check-input" type="checkbox">
                                        </td>
                                        <td>
                                            <a href="javascript:;">#6678</a>
                                        </td>
                                        <td>$78</td>
                                        <td>
                                            <a class="d-flex align-items-center gap-3" href="javascript:;">
                                                <div class="customer-pic">
                                                    <img src="/admin/assets/images/avatars/04.png" class="rounded-circle"
                                                        width="40" height="40" alt="">
                                                </div>
                                                <p class="mb-0 customer-name fw-bold">Andrew Carry</p>
                                            </a>
                                        </td>
                                        <td><span
                                                class="lable-table bg-success-subtle text-success rounded border border-success-subtle font-text2 fw-bold">Paid<i
                                                    class="bi bi-check2 ms-2"></i></span></td>
                                        <td><span
                                                class="lable-table bg-danger-subtle text-danger rounded border border-danger-subtle font-text2 fw-bold">Failed<i
                                                    class="bi bi-x-lg ms-2"></i></span></td>
                                        <td>Cash on delivery</td>
                                        <td>Nov 12, 10:45 PM</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input class="form-check-input" type="checkbox">
                                        </td>
                                        <td>
                                            <a href="javascript:;">#2367</a>
                                        </td>
                                        <td>$69</td>
                                        <td>
                                            <a class="d-flex align-items-center gap-3" href="javascript:;">
                                                <div class="customer-pic">
                                                    <img src="/admin/assets/images/avatars/05.png" class="rounded-circle"
                                                        width="40" height="40" alt="">
                                                </div>
                                                <p class="mb-0 customer-name fw-bold">Andrew Carry</p>
                                            </a>
                                        </td>
                                        <td><span
                                                class="lable-table bg-danger-subtle text-danger rounded border border-danger-subtle font-text2 fw-bold">Failed<i
                                                    class="bi bi-x-lg ms-2"></i></span></td>
                                        <td><span
                                                class="lable-table bg-warning-subtle text-warning rounded border border-warning-subtle font-text2 fw-bold">Pending<i
                                                    class="bi bi-info-circle ms-2"></i></span></td>
                                        <td>Cash on delivery</td>
                                        <td>Nov 12, 10:45 PM</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input class="form-check-input" type="checkbox">
                                        </td>
                                        <td>
                                            <a href="javascript:;">#9870</a>
                                        </td>
                                        <td>$49</td>
                                        <td>
                                            <a class="d-flex align-items-center gap-3" href="javascript:;">
                                                <div class="customer-pic">
                                                    <img src="/admin/assets/images/avatars/06.png" class="rounded-circle"
                                                        width="40" height="40" alt="">
                                                </div>
                                                <p class="mb-0 customer-name fw-bold">Andrew Carry</p>
                                            </a>
                                        </td>
                                        <td><span
                                                class="lable-table bg-danger-subtle text-danger rounded border border-danger-subtle font-text2 fw-bold">Failed<i
                                                    class="bi bi-x-lg ms-2"></i></span></td>
                                        <td><span
                                                class="lable-table bg-success-subtle text-success rounded border border-success-subtle font-text2 fw-bold">Completed<i
                                                    class="bi bi-check2 ms-2"></i></span></td>
                                        <td>Cash on delivery</td>
                                        <td>Nov 12, 10:45 PM</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input class="form-check-input" type="checkbox">
                                        </td>
                                        <td>
                                            <a href="javascript:;">#3456</a>
                                        </td>
                                        <td>$65</td>
                                        <td>
                                            <a class="d-flex align-items-center gap-3" href="javascript:;">
                                                <div class="customer-pic">
                                                    <img src="/admin/assets/images/avatars/07.png" class="rounded-circle"
                                                        width="40" height="40" alt="">
                                                </div>
                                                <p class="mb-0 customer-name fw-bold">Andrew Carry</p>
                                            </a>
                                        </td>
                                        <td><span
                                                class="lable-table bg-success-subtle text-success rounded border border-success-subtle font-text2 fw-bold">Completed<i
                                                    class="bi bi-check2 ms-2"></i></span></td>
                                        <td><span
                                                class="lable-table bg-danger-subtle text-danger rounded border border-danger-subtle font-text2 fw-bold">Failed<i
                                                    class="bi bi-x-lg ms-2"></i></span></td>
                                        <td>Cash on delivery</td>
                                        <td>Nov 12, 10:45 PM</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </main>
        <!--end main content-->


        <!--start overlay-->
        <div class="overlay btn-toggle-menu"></div>
        <!--end overlay-->

        <!-- Search Modal -->
        <div class="modal" id="exampleModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header gap-2">
                        <div class="position-relative popup-search w-100">
                            <input class="form-control form-control-lg ps-5 border border-3 border-primary" type="search"
                                placeholder="Search">
                            <span
                                class="material-symbols-outlined position-absolute ms-3 translate-middle-y start-0 top-50">search</span>
                        </div>
                        <button type="button" class="btn-close d-xl-none" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="search-list">
                            <p class="mb-1">Html Templates</p>
                            <div class="list-group">
                                <a href="javascript:;"
                                    class="list-group-item list-group-item-action active align-items-center d-flex gap-2"><i
                                        class="bi bi-filetype-html fs-5"></i>Best Html Templates</a>
                                <a href="javascript:;"
                                    class="list-group-item list-group-item-action align-items-center d-flex gap-2"><i
                                        class="bi bi-award fs-5"></i>Html5 Templates</a>
                                <a href="javascript:;"
                                    class="list-group-item list-group-item-action align-items-center d-flex gap-2"><i
                                        class="bi bi-box2-heart fs-5"></i>Responsive Html5 Templates</a>
                                <a href="javascript:;"
                                    class="list-group-item list-group-item-action align-items-center d-flex gap-2"><i
                                        class="bi bi-camera-video fs-5"></i>eCommerce Html Templates</a>
                            </div>
                            <p class="mb-1 mt-3">Web Designe Company</p>
                            <div class="list-group">
                                <a href="javascript:;"
                                    class="list-group-item list-group-item-action align-items-center d-flex gap-2"><i
                                        class="bi bi-chat-right-text fs-5"></i>Best Html Templates</a>
                                <a href="javascript:;"
                                    class="list-group-item list-group-item-action align-items-center d-flex gap-2"><i
                                        class="bi bi-cloud-arrow-down fs-5"></i>Html5 Templates</a>
                                <a href="javascript:;"
                                    class="list-group-item list-group-item-action align-items-center d-flex gap-2"><i
                                        class="bi bi-columns-gap fs-5"></i>Responsive Html5 Templates</a>
                                <a href="javascript:;"
                                    class="list-group-item list-group-item-action align-items-center d-flex gap-2"><i
                                        class="bi bi-collection-play fs-5"></i>eCommerce Html Templates</a>
                            </div>
                            <p class="mb-1 mt-3">Software Development</p>
                            <div class="list-group">
                                <a href="javascript:;"
                                    class="list-group-item list-group-item-action align-items-center d-flex gap-2"><i
                                        class="bi bi-cup-hot fs-5"></i>Best Html Templates</a>
                                <a href="javascript:;"
                                    class="list-group-item list-group-item-action align-items-center d-flex gap-2"><i
                                        class="bi bi-droplet fs-5"></i>Html5 Templates</a>
                                <a href="javascript:;"
                                    class="list-group-item list-group-item-action align-items-center d-flex gap-2"><i
                                        class="bi bi-exclamation-triangle fs-5"></i>Responsive Html5 Templates</a>
                                <a href="javascript:;"
                                    class="list-group-item list-group-item-action align-items-center d-flex gap-2"><i
                                        class="bi bi-eye fs-5"></i>eCommerce Html Templates</a>
                            </div>
                            <p class="mb-1 mt-3">Online Shoping Portals</p>
                            <div class="list-group">
                                <a href="javascript:;"
                                    class="list-group-item list-group-item-action align-items-center d-flex gap-2"><i
                                        class="bi bi-facebook fs-5"></i>Best Html Templates</a>
                                <a href="javascript:;"
                                    class="list-group-item list-group-item-action align-items-center d-flex gap-2"><i
                                        class="bi bi-flower2 fs-5"></i>Html5 Templates</a>
                                <a href="javascript:;"
                                    class="list-group-item list-group-item-action align-items-center d-flex gap-2"><i
                                        class="bi bi-geo-alt fs-5"></i>Responsive Html5 Templates</a>
                                <a href="javascript:;"
                                    class="list-group-item list-group-item-action align-items-center d-flex gap-2"><i
                                        class="bi bi-github fs-5"></i>eCommerce Html Templates</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!--start theme customization-->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="ThemeCustomizer" aria-labelledby="ThemeCustomizerLable">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="ThemeCustomizerLable">Theme Customizer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <h6 class="mb-0">Theme Variation</h6>
                <hr>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="LightTheme"
                        value="option1">
                    <label class="form-check-label" for="LightTheme">Light</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="DarkTheme"
                        value="option2" checked="">
                    <label class="form-check-label" for="DarkTheme">Dark</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="SemiDarkTheme"
                        value="option3">
                    <label class="form-check-label" for="SemiDarkTheme">Semi Dark</label>
                </div>
                <hr>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="MinimalTheme"
                        value="option3">
                    <label class="form-check-label" for="MinimalTheme">Minimal Theme</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="ShadowTheme"
                        value="option4">
                    <label class="form-check-label" for="ShadowTheme">Shadow Theme</label>
                </div>

            </div>
        </div>
        <!--end theme customization-->

        @push('scripts')
            <!-- Vector map JavaScript -->
            {{--  <script src="/admin/assets/plugins/apexcharts-bundle/js/apexcharts.min.js"></script> --}}
            {{--  <script src="/admin/assets/js/index2.js"></script> --}}
            <!-- App JS -->
        @endpush
        <script>
            function resetForm() {
                document.querySelector("input[name='date_debut']").value = '';
                document.querySelector("input[name='date_fin']").value = '';
                document.getElementById("myForm").submit(); // Optionnel : soumettre le formulaire après réinitialisation
            }
        </script>


    </body>

    </html>
