@section('titre', 'Liste des inscription')
@extends('admin.fixe')



  @section('body')
    <!--page-content-wrapper-->
    <div class="page-content-wrapper">
        <div class="page-content">

            <div class="content-wrapper">


      
                        <!-- start page title -->
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item">
                                                <a href="javascript: void(0);">{{ config('app.name') }}</a>
                                            </li>
                                            <li class="breadcrumb-item">
                                                <a href="{{ route('events-inscriptions-list') }}">Inscription</a>
                                            </li>
                                            <li class="breadcrumb-item active">Liste</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- end page title -->
                        <div class="card radius-15">
                            <div class="card-body">

                                <div class="card-title">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="header-title">
                                            Liste des inscriptions
                                        </h5>
                                        <div>
                                        
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                 @livewire('Evenements.ListInscription')  
                            </div>
                        </div>


                   
            </div>
        </div>
    </div>









    <script>
        function add_note(id_commande, nom) {
            //open modal an set id commande in id_mcommande input in modal
            $("#id_commande").val(id_commande);
            $('#nom-client').html(" " + nom);
            $('#modal-note').modal('show');
        }
    </script>

@endsection
