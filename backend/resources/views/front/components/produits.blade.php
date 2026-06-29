 <div class="axil-product-area bg-color-white axil-section-gap">
            <div class="container">
                <div class="section-title-wrapper">

                    <h4> <span class="axil-breadcrumb-item1 active" aria-current="page"> <i class="far fa-shopping-basket"></i> {{ \App\Helpers\TranslationHelper::TranslateText('Nos produits') }}</span> </h4>

                    <h2 class="title">
                        {{ \App\Helpers\TranslationHelper::TranslateText('Parcourir nos produits ') }}
                    </h2>
                </div>
                <div class="explore-product-activation slick-layout-wrapper slick-layout-wrapper--15 axil-slick-arrow arrow-top-slide">
                    <div class="slick-single-layout">
                        <div class="row row--15">
                            @foreach ($produits as $produit)
                            @if ($produit)
                            <div class="col-xl-3 col-lg-4 col-sm-6 col-12 mb--30">
                                <div class="axil-product product-style-one">
                                    <div class="thumbnail">
                                        <a href="{{ route('details-produits', ['id' => $produit->id, 'slug' => Str::slug(Str::limit($produit->nom, 10))]) }}">
                                            <img data-sal="zoom-out" data-sal-delay="200" data-sal-duration="800" loading="lazy" class="main-img" border-radius="8px" src="{{ Storage::url($produit->photo) }}" alt="Product Images">
                                            <img class="hover-img" border-radius="8px" src="{{ Storage::url($produit->photo) }}" alt="Product Images">
                                        </a>

                                        <style>
                                            .top-left {
                                                position: absolute;
                                                top: 8px;
                                                right: 18px;
                                                color: #EFB121;
                                            }

                                        </style>

                                        <div class="top-left" style="background-color: #EFB121;color: white;">
                                            <span>
                                                @if ($produit->inPromotion())
                                                <span>
                                                    -{{ $produit->inPromotion()->pourcentage }}%</span>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="product-hover-action">
                                            <ul class="cart-action">

                                                <li class="quickview"><a href="#" data-bs-toggle="modal"
                                                                    data-bs-target="#{{ $produit->id }}"><i
                                                                        class="far fa-eye"></i></a></li>
                                                {{-- <li class="quickview"><a href="#" data-bs-toggle="modal"
                                                                    data-bs-target="#{{ $produit->id }}"><i class="far fa-eye"></i></a></li> --}}
                                                <li class="select-option2">
                                                    <a onclick="AddToCart( {{ $produit->id }} )">
                                                        {{ \App\Helpers\TranslationHelper::TranslateText('Ajouter au panier') }}
                                                    </a>
                                                </li>


                                                @if (Auth()->user())

                                                @php

                                                $count = DB::table('favoris')
                                                ->where('id_user', Auth()->user()->id)
                                                ->where('id_produit', $produit->id)
                                                ->count();
                                                @endphp


                                                <li class="wishlist"><a onclick="AddFavoris({{ $produit->id }})" @if ($count==0) class="" style="color:#000000" @else class="" style="color: #dc3545; background-color:#dc3545" @endif>

                                                        <i class="far fa-heart"></i></a></li>
                                                @endif



                                                <style>
                                                    .select-option2 {
                                                        background-color: #5EA13C;
                                                        color: #ffffff;
                                                        border: none;
                                                        padding: 10px 20px;
                                                        border-radius: 5px;
                                                        text-decoration: none;
                                                    }

                                                    .favori-actif {
                                                        color: red;
                                                        /* Changez la couleur selon votre besoin */
                                                    }

                                                </style>

                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <div class="inner">
                                            <div class="product-rating">

                                            </div>

                                            <div class="">
                                                <h5 class="title"><a href="{{ route('details-produits', ['id' => $produit->id, 'slug' => Str::slug(Str::limit($produit->nom, 10))]) }}">
                                                        {{ \App\Helpers\TranslationHelper::TranslateText( Str::limit($produit->nom, 15)) }}

                                                            ({{ $produit->points }}
                                                                    {{ \App\Helpers\TranslationHelper::TranslateText('Points') }})

                                                    </a>
                                                </h5>
                                            </div>
                                            <div class="product__price__wrapper">
                                                <h6 class="product-price--main">


                                                    @if ($produit->inPromotion())
                                                    <div class="row">
                                                        <div class="col-sm-6 col-6">

                                                            <b class="text-success" style="color: #4169E1">
                                                                {{ $produit->getPrice() }}  <x-devise></x-devise>
                                                            </b>
                                                        </div>

                                                        <div class="col-sm-6 col-6 text-end">
                                                            <strike>


                                                                <span style="font-size: 1.7rem; color: #dc3545; font-weight: bold;">
                                                                    {{ $produit->prix }}  <x-devise></x-devise>
                                                                </span>


                                                            </strike>
                                                        </div>
                                                        @else
                                                        {{-- {{ $produit->getPrice() }}DT --}}


                                                        <span class="price current-price" style="font-size: 1.7rem;">
                                                            {{ $produit->getPrice() }} <x-devise></x-devise>
                                                            </b></span>
                                                        @endif


                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach

                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-12 text-center mt--20 mt_sm--0">
                        <a href="{{ route('shop') }}" class="axil-btn btn-bg-primary2 btn-load-more">

                            {{ \App\Helpers\TranslationHelper::TranslateText('Voir tous les produits') }}
                        </a>
                    </div>
                </div>

            </div>
        </div>
