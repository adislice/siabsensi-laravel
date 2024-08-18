
  <form wire:submit.prevent="login" class="d-flex flex-column">
    @csrf
    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <div class="form-with-icon">
        <input type="email" class="form-control" placeholder="Email" name="email" required wire:model="email">
        <i class='bx bx-at form-icon'></i>
      </div>
      <div class="small text-danger">@error('email') {{ $message }} @enderror</div>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <div class="form-with-icon">
        <input type="password" class="form-control" placeholder="Password" name="password" required
          wire:model="password">
        <i class='bx bxs-key form-icon'></i>
      </div>
      <div class="small text-danger">@error('password') {{ $message }} @enderror</div>
    </div>

    <button type="submit" class="btn btn-primary" wire:click="login">
    
    <div> 
        Login
        <svg wire:loading xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="ms-1 animate-rotate" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
    </div>
    </button>
    @if ($loginErrorMsg != "")
    <div class="text-danger small mt-1">
      {{ $loginErrorMsg }}
    </div>
    @endif
    
  </form>
