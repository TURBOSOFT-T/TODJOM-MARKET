<div>
    <form wire:submit="filtrer">
        <div class="row">
            <div class="col-sm-4">
                <span>
                    <b>{{ $inscriptions->count() }}</b> Résultats sur {{ $total }}
                </span>
            </div>
            <div class="col-sm-12">
                <div class="input-group mb-3">
                   
                    <input type="text" wire:model.live="key" placeholder="Recherche par nom,prenom, nnuméro"
                        class="form-control">
                    <select class="form-control" wire:model="statut2">
                        <option value="">Etat de confirmation</option>
                        <option value="">Tous</option>
                        <option value="confirmer">Confirmé</option>
                        <option value="non_confirmer">Non confirmé</option>
                    </select>
                   
                    <select class="form-control" wire:model="statut">
                        <option value="">Etat</option>
                        <option value="créé">Créé</option>
                        <option value="traitement">Traitement</option>
                    {{--     <option value="Livraison">Livraison</option> --}}
                        
                        <option value="payée">Payée</option>
                       
                        <option value="retournée">Retournée</option>
                    </select>
                    <input type="date" class="form-control" wire:model="date">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            Filtrer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @include('components.alert')

    <div class="table-responsive-sm">
        <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
            <thead class="table-dark">
                <tr>
                    <th></th>
                    <td></td>
                    <th>ID</th>
                     <th>Client</th>
        
                   
                    <th>Statut</th>
                    <th>Mode</th>
                    <th>Date</th>
                    <th class="text-end">
                        <span wire:loading>
                            <img src="https://i.gifer.com/ZKZg.gif" height="15" alt="" srcset="">
                        </span>
                    </th>
                </tr>
            </thead>    


            <tbody>
                @forelse ($inscriptions as $inscription)
                    <tr>
                        <td>
                            <input type="checkbox" wire:click="toggleCommandeSelection({{ $inscription->id }})">
                        </td>
                        <td>
                            <button class="btn btn-sm" data-bs-toggle="modal"
                                data-bs-target="#qr-code-{{ $inscription->id }}">
                                <i class="ri-qr-scan-2-line"></i>
                            </button>
                            <!-- Center modal content -->
                            <div class="modal fade" id="qr-code-{{ $inscription->id }}" tabindex="-1" role="dialog"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myCenterModalLabel">
                                                Commande #{{ $inscription->id }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h6 class="text-muted">
                                                Veuillez scanner ce code Qr pour impprimer le Reçu de inscription .
                                            </h6>
                                            <div class="text-center p-2">
                                              {{--   {!! QrCode::size(100)->generate(route('print_inscription', ['id' => $inscription->id])) !!} --}}
                                            </div>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                        </td>
                        <td>{{ $inscription->id }}</td>
                        <td>
                                <div>
                    <strong>
                        {{ $inscription->nom }}
                        {{ $inscription->prenom }}
                    </strong>

                    <br>

                    <small>
                        {{ $inscription->telephone }}
                    </small>

                    <br>

                    <small class="text-muted">
                        {{ $inscription->email }}
                    </small>
                </div>
                            @if ($inscription->message)
                                <i class="ri-message-2-fill" title="Une note a été ajouté"></i>
                            @endif
                        </td>
                        
                                          

                        <td>
                            @can('order_edit')
                                @if ($inscription->statut === 'payée')
                                    <b class="text-success">
                                        <i class="ri-check-double-fill"></i>
                                        Payée
                                    </b>
                                @elseif($inscription->statut == 'retournée')
                                    <b class="text-danger">
                                        @if ($inscription->etat == 'confirmé')
                                            <i class="ri-text-wrap"></i>
                                            retournée
                                        @else
                                            <i class="ri-close-circle-line"></i>
                                            Annulé
                                        @endif
                                    </b>
                                @else
                                    @if ($inscription->etat == 'confirmé')
                                        <select class="form-control-sm"
                                            wire:change="updateStatus({{ $inscription->id }}, $event.target.value)">
                                            <option value="créé" {{ $inscription->statut === 'créé' ? 'selected' : '' }}>
                                                Créé
                                            </option>
                                            <option value="traitement"
                                                {{ $inscription->statut === 'traitement' ? 'selected' : '' }}>
                                                Traitement</option>
                                          
                                            
                                            <option value="payée" {{ $inscription->statut === 'payée' ? 'selected' : '' }}>
                                                Payée
                                            </option>
                                            
                                            <option value="retournée"
                                                {{ $inscription->statut === 'retournée' ? 'selected' : '' }}>
                                                Retournée
                                            </option>
                                        </select>
                                    @elseif($inscription->etat == 'attente')
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button" class="btn btn-sm btn-primary"
                                                wire:click="confirmer({{ $inscription->id }})">
                                                <i class="ri-checkbox-circle-line"></i>
                                                Valider
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger"
                                                wire:click="annuler({{ $inscription->id }})">
                                                <i class="ri-close-line"></i>
                                                Annluer
                                            </button>
                                        </div>
                                    @else
                                        <i class="ri-close-circle-line"></i>
                                        Annulé
                                    @endif
                                @endif
                            @endcan

                        </td>
                        <td>
                            <span class="text-capitalize">
                                {{ $inscription->mode }}
                            </span>
                        </td>
                        <td>{{ $inscription->created_at }} </td>
                        <td style="text-align: right;">

                            <button class="btn btn-sm btn-info"
    data-bs-toggle="modal"
    data-bs-target="#detailModal{{ $inscription->id }}">

    <i class="ri-eye-line"></i>

</button>

<!-- Modal détails -->
<div class="modal fade"
    id="detailModal{{ $inscription->id }}"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content border-0 shadow-lg">

            <div class="modal-header bg-primary text-white">

                <h5 class="modal-title">
                    Détails de la réservation #{{ $inscription->id }}
                </h5>

                <button type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <div class="row">

                    {{-- CLIENT --}}
                    <div class="col-md-6 mb-3">

                        <div class="card border-0 bg-light h-100">

                            <div class="card-body">

                                <h5 class="mb-3 text-primary">
                                    Informations client
                                </h5>

                                <p>
                                    <strong>Nom :</strong>
                                    {{ $inscription->nom }}
                                    {{ $inscription->prenom }}
                                </p>

                                <p>
                                    <strong>Email :</strong>
                                    {{ $inscription->email }}
                                </p>

                                <p>
                                    <strong>Téléphone :</strong>
                                    {{ $inscription->telephone }}
                                </p>

                                <p>
                                    <strong>Adresse :</strong>
                                    {{ $inscription->addresse }}
                                </p>

                            </div>

                        </div>

                    </div>

                    {{-- VEHICULE --}}
                    <div class="col-md-6 mb-3">

                        <div class="card border-0 bg-light h-100">

                            <div class="card-body">

                                <h5 class="mb-3 text-success">
                                    Véhicule
                                </h5>

                                @if ($inscription->vehicule)

                                    @if ($inscription->vehicule->image)

                                        <img src="{{ asset('storage/' . $inscription->vehicule->image) }}"
                                            class="img-fluid rounded mb-3"
                                            style="height:180px;width:100%;object-fit:cover;">

                                    @endif

                                    <p>
                                        <strong>Nom :</strong>
                                        {{ $inscription->vehicule->nom }}
                                    </p>

                                    <p>
                                        <strong>Marque :</strong>
                                        {{ $inscription->vehicule->marques->nom }}
                                    </p>
  <p>
                                        <strong>Nombre de places :</strong>
                                        {{ $inscription->vehicule->nbrplace }}
                                    </p>


                                    <p>
                                        <strong>Type :</strong>
                                        {{ $inscription->vehicule->type }}
                                    </p>

                                @endif
                                 @if ($inscription->vehicule->type=='location')

                                  <p>
                                        <strong>Le prix journalier :</strong>
                                        {{ $inscription->vehicule->prix }}
                                    </p>
                                 @endif

                            </div>

                        </div>

                    </div>

                    {{-- DETAILS --}}
                    <div class="col-md-12">

                        <div class="card border-0">

                            <div class="card-body">

                                <h5 class="mb-4 text-dark">
                                    Détails réservation
                                </h5>

                                <div class="row">

                                    <div class="col-md-3 mb-3">

                                        <div class="p-3 rounded bg-primary text-white text-center">

                                            <small>Option</small>

                                            <h5 class="mt-2">

                                                @if ($inscription->option == 'aller')

                                                    Aller

                                                @elseif($inscription->option == 'retour')

                                                    Retour

                                                @elseif($inscription->option == 'double')

                                                    Aller / Retour

                                                @else

                                                    --

                                                @endif

                                            </h5>

                                        </div>

                                    </div>

                                    <div class="col-md-3 mb-3">

                                        <div class="p-3 rounded bg-success text-white text-center">

                                            <small>Places</small>

                                            <h5 class="mt-2">
                                                {{ $inscription->nbrplace ?? '--' }}
                                            </h5>

                                        </div>

                                    </div>

                                    <div class="col-md-3 mb-3">

                                        <div class="p-3 rounded bg-warning text-dark text-center">

                                            <small>Jours</small>

                                            <h5 class="mt-2">
                                                {{ $inscription->nbrjours ?? '--' }}
                                            </h5>

                                        </div>

                                    </div>

                                    <div class="col-md-3 mb-3">

                                        <div class="p-3 rounded bg-dark text-white text-center">

                                            <small>Total</small>

                                            <h5 class="mt-2">

                                                {{ number_format($inscription->prix_total, 0, ',', ' ') }}

                                                FCFA

                                            </h5>

                                        </div>

                                    </div>

                                </div>

                                @if ($inscription->message)

                                    <div class="alert alert-info mt-3">

                                        <strong>Message :</strong>

                                        {{ $inscription->message }}

                                    </div>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="modal-footer">

                <button class="btn btn-secondary"
                    data-bs-dismiss="modal">

                    Fermer

                </button>

            </div>

        </div>

    </div>

</div>
                            <div class="btn-group">
                            
                               
                            
                              
                                @can('order_delete')
                                    <button class="btn btn-sm btn-danger"
                                        onclick="toggle_confirmation({{ $inscription->id }})">
                                      {{--   <i class="ri-delete-bin-6-line"></i> --}}

                                      <i class="bi bi-check-circle"></i>
                                    </button>
                                @endcan
                                
                            </div>
                            @can('order_delete')
                                <button class="btn btn-sm btn-success d-none" type="button"
                                    id="confirmBtn{{ $inscription->id }}" wire:click="delete({{ $inscription->id }})">
                                    <span class="hide-tablete">
                                        Confirmer
                                    </span>
                                </button>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11">
                            <div class="text-center">
                                <div>
                                    <img src="/icons/icons8-ticket-100.png" height="100" width="100"
                                        alt="" srcset="">
                                </div>
                                Aucune inscription trouvé
                                @if ($key)
                                    <b> " {{ $key }} " </b>
                                @endif
                                .
                            </div>
                        </td>
                    </tr>
                @endforelse

            </tbody>


        </table>
    </div>

    {{ $inscriptions->links('pagination::bootstrap-4') }}




</div>
