
<div class="col-lg-3">
    <div class="card" style="width: 18rem;">
        <div class="card-header">
        <h5><a href="{{ route('user.profile') }}" class="text-dark profile">{{ Auth::guard('customer')->user()->name }}'s - Profile</a></h5>                      
        </div>
        <ul class="list-group list-group-flush" id="nav">
            <li class="list-group-item {{ $bold == 1 ? 'fw-bold' : '' }}"><a href="{{ route('customer.orders') }}" class="text-dark ">My orders</a></li>
            <li class="list-group-item {{ $bold == 2 ? 'fw-bold' : '' }}">Wishlist</li>
          <li class="list-group-item"><a href="{{ route('user.logout') }}" class="text-dark">Logout</a></li>
        </ul>
    </div>
</div>