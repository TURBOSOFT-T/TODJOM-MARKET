@section('titre', $event->titre)
@extends('admin.fixe')



  @section('body')
    <!--page-content-wrapper-->
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item">
                                            <a href="javascript: void(0);">{{ config('app.name') }}</a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('events') }}">Evènemrnts</a>
                                        </li>
                                        <li class="breadcrumb-item active">Liste</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                        <!-- Sponsors List Table -->

                        <div class="card radius-15">
                            <div class="card-body">

                                <hr />
                              
                                <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-sm-8">
                                           {{--  <img src="{{ Storage::url($image) }}" alt="{{ $titre }}" class="w-100" srcset=""> --}}
                                           <img src="{{ Storage::url($event->image) }}" class="w-100" width="400 " height="500 "
                                           class="rounded shadow" alt="">
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="mb-3">
                                                <label for="">Nouvelle photo</label>
                                                <input type="file" name="image"    class="form-control">
                                                @error('image')
                                                    <span class="small text-danger"> {{ $message }} </span>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="">Nom</label>
                                                <input type="text" class="form-control" value=" {{ $event->titre }}"  name="titre">
                                                @error('titre')
                                                    <span class="small text-danger"> {{ $message }} </span>
                                                @enderror
                                            </div>

                                            

                                       
                                            
                                           
                                            
                                           
                            
                                            <div class="mb-3">
                                                <label for="description">Description</label>
                                                <textarea rows="5" id="description" value={{ $event->description }} name="description" class="form-control">{!! old('description', $event->description) !!}</textarea>
                                                @error('description')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                            
                            
                            
                                            @include('components.alert')
                            
                                            <div class="modal-footer">
                                                <button class="btn btn-primary btn-sm px-5" type="submit" wire:loading.attr="disabled">
                                                    {{-- <span wire:loading>
                                                        <img src="https://i.gifer.com/ZKZg.gif" height="15" alt="" srcset="">
                                                    </span> --}}
                                                Mettre à jour
                                                </button>
                                                &nbsp; &nbsp;
                                              {{--   <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Fermer</button> --}}
                                                <a class="btn btn-sm btn-secondary"  href="{{ route('events') }}">Renourner à la liste</a>
                                                
                                            </div>
                                           
                            
                                        </div>
                                    </div>
                                </form>



                            </div>
                        </div>


                    </div>



                </div>

            </div>




        </div>
    </div>

 
@endsection
