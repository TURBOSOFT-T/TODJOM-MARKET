@section('titre', 'Liste des produits')
@extends('admin.fixe')

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

   {{--  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    --}}<script src="https://code.jquery.com/jquery-3.5.1.js"></script> 
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
   {{--  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script> 

</head>
@section('body')
<!--page-content-wrapper-->
<div class="page-content-wrapper">
    <div class="page-content">

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
                                <a href="{{ route('produits') }}">Les categories</a>
                            </li>
                            <li class="breadcrumb-item active">Liste</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
      


        <div class="card radius-15">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card-title">
                            <h5 class="mb-0 my-auto">
                                Liste des categories
                            </h5>
                        </div>
                    </div>
                    <div class="col-sm-6">
                     
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                            <a class="btn btn-success btn-sm" onclick="url('{{ route('category.add') }}')"> <i class="fa fa-plus"></i> Ajouter une category</a>
                        </div>
                    </div>
                </div>
                <hr />
     
                <div class="card">
					<div class="card-body">
                <div class="table-responsive-sm">
                    <table id="data-table" class="table table-striped table-bordered data-table">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Photo</th>
                                <th>Description</th>
                                <th width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>

                    </table>


                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="showModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"><i class="fa-regular fa-eye"></i> Détail de la categorie</h4>
            </div>
            <div class="modal-body">
                <p><strong>Name:</strong> <span class="show-name"></span></p>
                <p><strong>Detail:</strong> <span class="show-detail"></span></p>
                <p><strong>Produits:</strong> <span class="produits"></span></p>

              
              
                

            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">




     $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


    });


    var table = $('.data-table').DataTable({
        processing: true
        , serverSide: true
        , ajax: "{{ route('cats.index') }}"
        , columns: [
          
            {
                data: 'nom'
                , name: 'nom'
            },
            
            {
            data: 'photo',
            name: 'photo',
         
        },
            
            {
                data: 'description'
                , name: 'description'
            },

            {
                data: 'action'
                , name: 'action'
                , orderable: false
                , searchable: false
            }
        , ]

    });
  

    $('body').on('click', '.showCategory', function () {
      var category_id = $(this).data('id');
      $.get("{{ route('cats.index') }}" +'/' + category_id, function (data) {
          $('#showModel').modal('show');
          $('.show-name').text(data.nom);
          $('.show-detail').text(data.description);
        
           $('.produits').text(data.produit_count);
           $('.photo').text(data.photo);  

      })
    });




    $('body').on('click', '.deleteProduct', function () {
    var category_id = $(this).data("id");

    
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            
            $.ajax({
                type: "DELETE",
                url: "{{ route('cats.store') }}/" + category_id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
                },
                success: function (data) {
                    Swal.fire(
                        "Deleted!",
                        "The category has been deleted successfully.",
                        "success"
                    );
                    table.draw(); 
                },
                error: function (data) {
                    Swal.fire(
                        "Error!",
                        "An error occurred while trying to delete the category.",
                        "error"
                    );
                    console.error('Error:', data);
                }
            });
        }
    });
}); 


</script>
{{-- 

<script src="{{ asset('/js/categories.js') }}" type="text/javascript"></script>

 --}}



@endsection
