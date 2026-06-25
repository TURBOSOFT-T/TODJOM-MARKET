<div>
    <div id="content">
        <div class="breadcrumb">
            <div class="container">
                <h2>Mes Commandes</h2>
               
            </div>
        </div>
        <div class="wishlist">
            <div class="container">
                <div class="wishlist__table">
                    <div class="wishlist__table__wrapper">
                        <table>
                            <colgroup>
                                <col style="width: 20%" />
                                <col style="width: 10%" />
                               
                                <col style="width: 15%" />
                                <col style="width: 10%" />
                                <col style="width: 20%" />
                            </colgroup>
                            <thead  style=" background-color: #b2e21522;">
                                <tr>
                                    <th style="width: 80px;">Article</th>
                                    <th class="product-thumbnail">Montant</th>
                                    <th class="product-thumbnail">Frais</th>
                                   
                                    <th class="product-thumbnail">Date</th>
                                    <th class="product-quantity">Statut</th>
                                    <th class="product-remove">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               {{--  @forelse ($favoris as $key => $favo)
                                <tr>
                                    <td>
                                        <div class="wishlist-product">
                                            <div class="wishlist-product__image"> <img
                                                    src="{{ Storage::url($favo->produit->photo) }}"
                                                    alt=" {{ $favo->produit->nom }}" srcset=""></div>
                                            <div class="wishlist-product__content">
                                                <a href="{{ url('details-produits', $favo->produit->id) }}"> {{
                                                    $favo->produit->nom }}</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="table-primary">
                                        {{ $favo->created_at }}
                                    </td>
                                   
                                    <td>
                                        {{ $favo->produit->getPrice() }} DT
                                    </td>
                                    <td>
                                        {{ $favo->produit->statut }}
                                    </td>
                                    <td>
                                         <button type="button" class=" btn-dark"
                                            onclick="AddToCart( {{ $favo->produit->id }} )">
                                           Ajouter au panier
                                        
                                        </button>
    
                                         <button  type="button" wire:click="delete({{  $favo->id }})">
                                           Retirer
                                        </button>  
                                        
                                        
                                        
                                    </td>
                                </tr>
                                @endforeach --}}
    
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</div>
