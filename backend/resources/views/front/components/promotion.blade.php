
        <!-- Start Expolre Product Area  -->
        <div class="axil-product-area bg-color-white axil-section-gapcommon">
            <div class="container">
                <div class="section-title-border slider-section-title">
                    <h2 class="title"> {{ \App\Helpers\TranslationHelper::TranslateText('Produits en promotion') }}💥</h2>
                </div>
               <div
                        class="popular-product-activation slick-layout-wrapper slick-layout-wrapper--15 axil-slick-angle angle-top-slide">
                        <div class="slick-single-layout">
                            <div class="row">
                                @if ($produits)
                                    @foreach ($produits as $key => $produit)
                                        @if ($produit->inPromotion())
                                            <div class="col-md-6 col-12">
                                                <div class="axil-product product-style-eight product-list-style-3">
                                                    <div class="thumbnail">
                                                        <a
                                                            href="{{ route('details-produits', ['id' => $produit->id, 'slug' => Str::slug(Str::limit($produit->nom, 10))]) }}">
                                                            <img class="main-img" width="300" height="300"
                                                                src="{{ Storage::url($produit->photo) }}"
                                                                alt="Product Images">

                                                            <style>
                                                                .top-left {
                                                                    position: absolute;
                                                                    top: 8px;
                                                                    right: 18px;
                                                                    color: #EFB121;
                                                                }

                                                                .top-right {
                                                                    position: absolute;
                                                                    top: -30px;
                                                                    right: 18px;
                                                                    color: #EFB121;
                                                                }
                                                            </style>

                                                            <div class="top-left"
                                                                style="background-color:#EFB121;color: white;">
                                                                <span>
                                                                    @if ($produit->inPromotion())
                                                                        <span>
                                                                            -{{ $produit->inPromotion()->pourcentage }}%</span>
                                                                    @endif
                                                                </span>
                                                            </div>
                                                        </a>


                                                    </div>
                                                    <div class="product-content">
                                                        <div class=" col-sm-12 inner">
                                                            <div class="top-right">
                                                                <br>
                                                                @if ($produit->stock > 0)
                                                                    <label class="badge btn-bg-primary2">
                                                                        {{ \App\Helpers\TranslationHelper::TranslateText('Stock disponible') }}</label>
                                                                    <span class="text-primary text-capitalize"> Stock
                                                                    </span> |
                                                                    {{ $produit->stock }} U
                                                                @else
                                                                    <label class="badge bg-danger">
                                                                        {{ \App\Helpers\TranslationHelper::TranslateText('Stock non disponible') }}</label>
                                                                    <span class="text-primary text-capitalize"> Stock
                                                                    </span> |
                                                                    {{ $produit->stock }} U
                                                                @endif


                                                            </div>

                                                           {{--  <div class="product-cate"><a
                                                                    href="{{ route('details-produits', ['id' => $produit->id, 'slug' => Str::slug(Str::limit($produit->nom, 10))]) }}">
                                                                    {{ \App\Helpers\TranslationHelper::TranslateText($produit->nom) }}</a>
                                                            </div> --}}
                                                            <div class="color-variant-wrapper">

                                                            </div>
                                                            <br>
                                                            <h5 class="title"><a
                                                                    href="{{ route('details-produits', ['id' => $produit->id, 'slug' => Str::slug(Str::limit($produit->nom, 10))]) }}">
                                                                    {{ \App\Helpers\TranslationHelper::TranslateText(Str::limit($produit->nom, 20)) }}
                                                                       ({{ $produit->points ??  '' }}
                                                                    {{ \App\Helpers\TranslationHelper::TranslateText('Points') }})


                                                                </a></h5>
                                                            <div class="product-rating">

                                                            </div>


                                                            <div class="product-price-variant">
                                                                <span class="price-text">
                                                                    {!! \App\Helpers\TranslationHelper::TranslateText('Coût') !!}:</span>
                                                                <span class="price current-price"> <b class="text-succes"
                                                                        style="color: #4169E1">
                                                                        {{ $produit->getPrice() }}
                                                                    </b></span>

                                                                <span class="price current-price"> <b
                                                                        class="text-succes fs-7" style="color: #4169E1">
                                                                        <x-devise></x-devise>
                                                                    </b>
                                                                </span>

                                                            </div>

                                                            {{--   <a class="select-option2" onclick="AddToCart( {{ $produit->id }} )">
                                                        {{ \App\Helpers\TranslationHelper::TranslateText('Ajouter au panier') }}
                                                    </a> --}}
                                                            <button class="axil-btn btn-bg-primary2" type="submit"
                                                                onclick="AddToCart( {{ $produit->id }} )">

                                                                <span>
                                                                    {{ \App\Helpers\TranslationHelper::TranslateText('Ajouter au panier') }}
                                                                </span>
                                                            </button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif

                            </div>
                        </div>

                    </div>
            </div>
        </div>
