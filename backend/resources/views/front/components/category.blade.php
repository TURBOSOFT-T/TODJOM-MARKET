  <!-- End Slider Area -->
        <!-- Start Categorie Area  -->
        <!-- Start Categorie Area  -->
        <div class="axil-categorie-area bg-color-white axil-section-gapcommon">
            <div class="container">
                <div class="section-title-wrapper">
                    <h4> <span class="axil-breadcrumb-item1 active" aria-current="page"> <i class="far fa-tags"></i> {{ \App\Helpers\TranslationHelper::TranslateText('Categories') }}</span> </h4>
                    <h2 class="title">
                        {{ \App\Helpers\TranslationHelper::TranslateText('Parcourrir par categories') }}
                    </h2>
                </div>
                <div class="categrie-product-activation slick-layout-wrapper--15 axil-slick-arrow  arrow-top-slide">

                    @foreach ($categories as $category)
                    <div class="slick-single-layout">
                        <div class="categrie-product" data-sal="zoom-out" data-sal-delay="200" data-sal-duration="500">
                            <a href="/category/{{ $category->id }}" class="{{ isset($current_category) && $current_category->id === $category->id ? 'selected' : '' }}">
                                <img {{-- class="img-fluid" --}} src="{{ Storage::url($category->photo) }}" width="200" border-radius="8px" height="200" class="rounded shadow" alt="product categorie">
                                {{-- <img class="img-fluid" src="./assets/images/product/categories/elec-4.png" alt="product categorie"> --}}
                                <h6 class="cat-title">
                                    {{ \App\Helpers\TranslationHelper::TranslateText($category->nom ?? '') }}
                                </h6>
                            </a>
                        </div>
                        <!-- End .categrie-product -->
                    </div>
                    @endforeach


                </div>
            </div>
        </div>

