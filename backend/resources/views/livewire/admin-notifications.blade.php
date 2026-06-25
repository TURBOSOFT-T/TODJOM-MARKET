{{-- <div class="header-notifications-list">
@forelse ($notifications as $notification)
<a class="dropdown-item" href="javascript:;">
    <div class="d-flex align-items-center">
      <div class="notify text-danger border">

        <span class="material-symbols-outlined">
            account_circle
            </span>
       
      </div>
      <div class="flex-grow-1">
        <h6 class="msg-name"> {{ $notification->titre }}<span class="msg-time float-end"> {{ $notification->created_at }}
            </span></h6>
        <p class="msg-info"> {{ $notification->message }}</p>
      </div>
    </div>
  </a>
  @empty
  <a class="dropdown-item d-flex w-100 py-3 text-muted text-center fw-bold border-bottom border-gray-200">
      Aucune notification en ce moment !
  </a>
@endforelse
</div>
 --}}

 <div class="header-notifications-list">
  @forelse ($notifications as $notification)
      <div class="dropdown-item">
          <div class="d-flex align-items-center">
              <div class="notify bg-light-primary text-primary">
                  @if ($notification->type == 'commande')
                      <i class="ri-shopping-bag-line text-primary-color"></i>
                  @else
                      <i class="bx bx-group text-primary-color"></i>
                  @endif
              </div>
              <div class="flex-grow-1" onclick="url('{{ $notification->url }}')">
                  <h6 class="msg-name">
                      {{ $notification->titre }}
                      {{-- <span class="msg-time float-end">
                          {{ $notification->created_at }}
                      </span> --}}
                  </h6>
                  <p class="msg-info">
                      {{ $notification->message }}
                  </p>

                  <span class="msg-time float-end">
                    {{ $notification->created_at }}
                </span>
              </div>
             {{--  <div>
                <i class="ri-close-fill" wire:click="delete( {{ $notification->id }})"></i>
            </div> --}}
            <div>
              <i class="ri-close-fill text-danger fs-4" wire:click="delete({{ $notification->id }})" style="cursor: pointer;" title="Supprimer la notification"></i>
          </div>
          
             
          </div>

        
      </div>
        
  @empty
      <a class="dropdown-item d-flex w-100 py-3 text-muted text-center fw-bold border-bottom border-gray-200">
          Aucune notification en ce moment !
      </a>
  @endforelse
</div>
