

        <!-- Start Testimonila Area  -->
        <div class="axil-testimoial-area axil-section-gap bg-vista-white">
            <div class="container">
                <div class="section-title-wrapper">
                    <h4> <span class="axil-breadcrumb-item1 active" aria-current="page"> <i class="fal fa-quote-left"></i> {{ \App\Helpers\TranslationHelper::TranslateText('Témoignages') }}</span> </h4>


                    <h2 class="title"> {{ \App\Helpers\TranslationHelper::TranslateText('Les retours de nos clients') }}</h2>
                </div>

                <!-- End .section-title -->
                <div class="testimonial-slick-activation testimonial-style-one-wrapper slick-layout-wrapper--20 axil-slick-arrow arrow-top-slide">

                    @if ($testimonials->isEmpty())
                    <p> {{ \App\Helpers\TranslationHelper::TranslateText('Aucun témoignage disponible') }}.</p>
                    @else
                    @foreach ($testimonials as $testimonial)
                    <div class="slick-single-layout testimonial-style-one">
                        <div class="review-speech">
                            <p>“
                                {!! \App\Helpers\TranslationHelper::TranslateText($testimonial->message) !!}
                                “</p>
                        </div>
                        <div class="media">
                            <div class="thumbnail">
                                @if ($testimonial->photo)
                                <img src="{{ asset('uploads/testimonials/' . $testimonial->photo) }}" alt="Photo Témoignage" width="100" height="100">
                                @else
                                <img src="./assets/images/testimonial/image-1.png" alt="testimonial image">
                                @endif

                            </div>
                            <div class="media-body">
                                <span class="designation">{{ $testimonial->name }}</span>
                                {{-- <h6 class="title">James C. Anderson</h6> --}}
                            </div>
                        </div>
                        <!-- End .thumbnail -->
                    </div>
                    @endforeach
                    @endif

                    <!-- End .slick-single-layout -->

                </div>

            </div>
            <br><br>
            <br>
            <div class="col-12 d-flex justify-content-center">
                <div class="form-group mb--0">
                    <button class="axil-btn btn-bg-primary2" data-bs-toggle="modal" data-bs-target="#exampleModal" type="submit">
                        <span> {{ \App\Helpers\TranslationHelper::TranslateText('Laisser un témoignage') }}</span>
                    </button>
                </div>

            </div>


            <div id="successMessage" class="alert alert-success" style="display:none;"></div>
            <div id="errorMessage" class="alert alert-danger" style="display:none;"></div>



        </div>


        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> {{ \App\Helpers\TranslationHelper::TranslateText('Témoignage') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>



                    <div class="modal-body">
                        <form id="testimonialForm" action="{{ route('testimonial.store') }}" method="POST" class="testimonial-form p-4 rounded shadow-sm bg-light">
                            @csrf
                            <div class="form-group mb-4">
                                <label for="name" class="form-label text-muted"> {{ \App\Helpers\TranslationHelper::TranslateText('Nom') }}</label>
                                <input type="text" class="form-control border-0 rounded-pill shadow-sm" id="name" name="name" required>
                            </div>
                            <div class="form-group mb-4">
                                <label for="testimonial" class="form-label text-muted"> {{ \App\Helpers\TranslationHelper::TranslateText('Message') }}</label>
                                <textarea class="form-control border-0 rounded-3 shadow-sm" id="testimonial" name="message" rows="8" required></textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-bg-primary2 rounded-pill shadow"> {{ \App\Helpers\TranslationHelper::TranslateText('Envoyer') }}</button>
                            </div>
                        </form>

                        @if ($errors->any())
                        <div class="alert alert-danger mt-4">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @if (session('success'))
                        <div class="alert alert-success mt-4">
                            {{ session('success') }}
                        </div>
                        @endif
                        <style>
                            .testimonial-form {
                                max-width: 600px;
                                margin: 0 auto;
                                background-color: #f8f9fa;
                            }

                            .form-group {
                                margin-bottom: 1.5rem;
                            }

                            .form-label {
                                font-weight: 600;
                                font-size: 1rem;
                            }

                            .form-control {
                                padding: 0.75rem 1rem;
                                font-size: 1rem;
                                color: #495057;
                                background-color: #fff;
                                border-radius: 25px;
                            }

                            textarea.form-control {
                                border-radius: 15px;
                            }

                            button.btn {
                                padding: 0.5rem 2rem;
                                font-size: 1.125rem;
                                transition: background-color 0.3s ease;
                            }

                            button.btn-primary {
                                background-color: #EFB121;
                                border-color: #EFB121;
                            }

                            button.btn-primary:hover {
                                background-color: #EFB121;
                                border-color: #EFB121;
                            }

                            .alert {
                                max-width: 600px;
                                margin: 1rem auto;
                            }

                        </style>

                    </div>



                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#testimonialForm').on('submit', function(e) {
                    e.preventDefault(); // Empêcher l'envoi classique du formulaire

                    $.ajax({
                        url: $(this).attr('action')
                        , method: $(this).attr('method')
                        , data: $(this).serialize()
                        , success: function(response) {
                            // Afficher le message de succès
                            $('#testimonialModal').modal('hide'); // Fermer le modal

                            $('#successMessage').text(
                                'Témoignage créé avec succès! Il sera valide après confirmation des administrateurs'

                            ).show();

                            setTimeout(function() {
                                location.reload();
                            }, 5000);
                        }
                        , error: function(response) {
                            // Afficher un message d'erreur si nécessaire
                            $('#errorMessage').text('Une erreur est survenue.')
                                .show(); // Afficher le message d'erreur
                        }
                    });
                });
            });

        </script>



        <style>
            .btn-bg-primary2 {
                background-color: #5EA13C;
                color: #ffffff;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                text-decoration: none;
            }

        </style>
