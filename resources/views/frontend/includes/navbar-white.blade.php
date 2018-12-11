<header class="uk-box-shadow-small navbarcustomer">
  <nav class="uk-navbar" uk-navbar>
    <div class="uk-navbar-left">
      <ul class="uk-navbar-nav navtopcustomer">
        <li>
          <a class="uk-navbar-item uk-logo logo" href="{{ url('/') }}">
            <img src="{{ asset('images/logobrand/gplogo-primary.png') }}" alt="">
          </a>
        </li>
      </ul>
    </div>
    <div class="uk-navbar-right">
      <ul class="uk-navbar-nav navtopcustomer">
        @if( Cookie::get('hasLoginCustomers') )
        <li><a>Rp. 0</a></li>
        <li><a class="navcusticon" uk-tooltip="title: Transaksi; pos: bottom"><span><i class="fas fa-exchange-alt"></i></span></a></li>
        <li><a class="navcusticon" uk-tooltip="title: Notifikasi; pos: bottom"><span><i class="far fa-bell"></i></span></a></li>
        <li><a>{{ $myaccount->customer_name }} <span class="uk-margin-small-left"><i class="fas fa-caret-down"></i></span></a>
          <div class="uk-navbar-dropdown navbardropdowncustomer">
            <ul class="uk-nav uk-navbar-dropdown-nav">
              <li><a href="{{ route('accountcustomer_page') }}">Dashboard</a></li>
              <li><a href="#">Kotak Pesan</a></li>
              <li><a href="{{ route('customerorderlist_page') }}">Daftar Transaksi</a></li>
              <li class="uk-nav-divider"></li>
              <li><a href="{{ route('editprofilecustomer_page') }}">Edit Profil &amp; Pengaturan</a></li>
              <li><a href="{{ route('logoutcustomer') }}">Keluar</a></li>
            </ul>
          </div>
        </li>
        @elseif( Cookie::get('hasLoginVendor') )
        <li><a>Rp. 0</a></li>
        <li><a class="navcusticon" uk-tooltip="title: Transaksi; pos: bottom"><span><i class="fas fa-exchange-alt"></i></span></a></li>
        <li><a class="navcusticon" uk-tooltip="title: Notifikasi; pos: bottom"><span><i class="far fa-bell"></i></span></a></li>
        <li><a href="#">{{ $myaccount->vendor_name }} <span class="uk-margin-small-left"><i class="fas fa-caret-down"></i></span></a>
          <div class="uk-navbar-dropdown navbardropdowncustomer">
            <ul class="uk-nav uk-navbar-dropdown-nav">
              <li><a href="{{ route('accountvendor_page') }}">Dashboard</a></li>
              <li><a href="#">Upgrade Pro</a></li>
              <li><a href="#">GardenBuana Pay</a></li>
              <li class="uk-nav-divider"></li>
              <li><a href="{{ route('vendorportfolio_page') }}">Galeri Portfolio</a></li>
              <li><a href="#">Kotak Pesan</a></li>
              <li><a href="{{ route('orderlistvendor_page') }}">Daftar Transaksi</a></li>
              <li class="uk-nav-divider"></li>
              <li><a href="{{ route('editaccountvendor_page') }}">Pengaturan Vendor</a></li>
              <li><a href="{{ route('logoutvendor') }}">Keluar</a></li>
            </ul>
          </div>
        </li>
        @else
        <li><a class="joinascustomer" href="{{ route('signuppage') }}"><div>Daftar</div></a></li>
        <li><a class="loginascustomer" href="{{ route('loginpage') }}"><div>Masuk</div></a></li>
        @endif
      </ul>
    </div>
  </nav>
</header>
