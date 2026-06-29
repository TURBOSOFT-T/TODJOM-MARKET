        <div class="container-fluid px-0 mb-5">
            <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($banners as $key => $banner)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <img class="d-block w-100" src="{{ Storage::url($banner->image) }}" alt="Image">


                        <div class="carousel-caption  d-md-block">
                            <div class="container">

                                <div class="main-slider-content">
                                    <span class="subtitle" style="color: #ffffff"><i class="fas fa-fire"></i>

                                        {{ \App\Helpers\TranslationHelper::TranslateText($banner->titre ?? ' ') }}
                                    </span>
                                    <p style="font-size: 1.5rem;   color: #ffffff;  margin-top: 10px; ">

                                        {{ \App\Helpers\TranslationHelper::TranslateText($banner->sous_titre ?? ' ') }}
                                    </p>

                                </div>
                                <div class="shop-btn d-flex justify-content-center">
                                    <a href="{{ route('shop') }}" class="axil-btn btn-bg-primary2 right-icon">

                                        {{ \App\Helpers\TranslationHelper::TranslateText('Voir boutique') }}
                                        <i class="fal fa-long-arrow-right"></i>
                                    </a>
                                </div>




                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <style>
            /* Assurez-vous que les images du carrousel sont responsives */
            .carousel-inner img {
                width: 80%;
                height: auto;
            }

            /* Ajustez la taille du texte du carrousel pour les petits écrans */
            @media (max-width: 768px) {

                .carousel-caption p,
                .carousel-caption h1 {
                    font-size: 1rem;
                    /* Ajustez la taille selon vos besoins */
                }

                .carousel-caption .btn {
                    font-size: 0.875rem;
                    /* Ajustez la taille du bouton selon vos besoins */
                }
            }

            /* Assurez-vous que les contrôles du carrousel sont adaptés pour les petits écrans */
            .carousel-control-prev,
            .carousel-control-next {
                width: 5%;
                /* Ajustez la largeur des contrôles */
                height: 100%;
            }

        </style>

        {{-- <div id="carouselExample" class="carousel slide  carousel-inner" data-ride="carousel" data-interval="3000">
            <div class="carousel-inner">
                @foreach ($banners as $key => $banner)
                <div class="carousel-item {{ $key === 0 ? 'active' : '' }}"
        style="background-image: url('{{ Storage::url($banner->image) }}'); background-size: cover; background-position: center; height: 100vh;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-sm-8">
                    <div class="main-slider-content">
                        <span class="subtitle"><i class="fas fa-fire"></i>
                            {{ $banner->titre ?? '' }}</span>
                        <p style="font-size: 1.5rem;   color: #ffffff;  margin-top: 10px; ">
                            {{ $banner->sous_titre ?? '' }}</p>

                    </div>

                </div>

            </div>

        </div>
        <div class="shop-btn d-flex justify-content-center">
            <a href="{{ route('shop') }}" class="axil-btn btn-bg-secondary right-icon">
                Voir boutique <i class="fal fa-long-arrow-right"></i>
            </a>
        </div>
        </div>
        @endforeach
        </div>
        <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
        </div>
        --}}

