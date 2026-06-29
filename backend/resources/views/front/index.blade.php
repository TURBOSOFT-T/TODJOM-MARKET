@extends('front.fixe')
@section('titre', 'Accueil')
@section('body')
<main>
    @php
    $config = DB::table('configs')->first();
    $service = DB::table('services')->get();
    $produit = DB::table('produits')->get();
    @endphp

 
    <style>
        .axil-breadcrumb-item1 {
            font-size: 14px;
            color: #EFB121;

        }

        .axil-breadcrumb-item.active {
            font-weight: bold;
            color: #EFB121;

        }

        .axil-breadcrumb-item:not(.active)::after {
            content: " / ";

            color: #EFB121;
        }

    </style>
    <main class="main-wrapper">


    @include('front.components.banner')

      
    @include('front.components.category')
       

    @include('front.components.produits')
    @include('front.components.modal')

  
        <br><br>

@include('front.components.stat')

        <!-- End About Area  -->

        <br><br>
@include('front.components.promotion')
        <!-- End Expolre Product Area  -->
  @include('front.components.testimonials')
  
    </main>



</main>


@endsection
