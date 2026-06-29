
        <!-- Start About Area  -->
        <div class="about-info-area">
            <div class="container">
                <div class="row row--20">
                    <div class="col-lg-4">
                        <div class="about-info-box">
                            <div class="thumb image-center">
                                <img src="{{ Storage::url($config->icone_satisfaction ?? '') }}" width="100" height="100" alt="Shape">
                            </div>
                            <style>
                                .image-center {
                                    display: flex;
                                    justify-content: center;
                                }

                                .text-justify {
    text-align: justify;
    text-justify: inter-word; /* Réduit l'espace entre les mots */
    white-space: normal; /* Élimine les espaces blancs multiples */
    word-spacing: -1px; /* Ajuste l'espacement entre les mots */
}


                            </style>

                            <div class="content">
                                <h5 class="title" style="text-align: justify">
                                    {!! \App\Helpers\TranslationHelper::TranslateText($config->titre_satisfaction ?? ' ') !!}
                                </h5>

                                <p style="text-align: justify">

                                    {!! \App\Helpers\TranslationHelper::TranslateText($config->des_satisfaction ?? '') !!}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="about-info-box">
                            <div class="thumb image-center">
                                <img src="{{ Storage::url($config->icone_annee ?? ' ')  }}" height="100" width="100" alt="Shape">
                            </div>
                            <div class="content">
                                <h5 class="title" style="text-align: justify">{{-- {{ $config->annee ?? ' ' }}  --}}{!! \App\Helpers\TranslationHelper::TranslateText($config->titre_annee ?? '') !!}.</h5>
                                <p style="text-align: justify">
                                    {!! \App\Helpers\TranslationHelper::TranslateText($config->des_annee ?? ' ') !!}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="about-info-box">
                            <div class="thumb image-center">
                                <img src="{{ Storage::url($config->icone_prix ?? ' ') }}" height="100" width="100" alt="Shape">
                            </div>
                            <div class="content">
                                <h5 class="title" style="text-align: justify">{{-- {{ $config->prix ?? ' ' }} --}} {!! \App\Helpers\TranslationHelper::TranslateText($config->titre_prix ?? ' ') !!}.</h5>
                                <p style="text-align: justify">
                                    {!! \App\Helpers\TranslationHelper::TranslateText($config->des_prix ?? '') !!}.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
