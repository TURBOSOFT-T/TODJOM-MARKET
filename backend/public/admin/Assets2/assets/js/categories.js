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


$('body').on('click', '.showProduct', function () {
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

// Confirmation avec SweetAlert
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
        // Requête AJAX pour supprimer l'élément
        $.ajax({
            type: "DELETE",
            url: "{{ route('cats.store') }}/" + category_id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF Token pour sécuriser la requête
            },
            success: function (data) {
                Swal.fire(
                    "Deleted!",
                    "The category has been deleted successfully.",
                    "success"
                );
                table.draw(); // Rafraîchit les données dans la table
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

