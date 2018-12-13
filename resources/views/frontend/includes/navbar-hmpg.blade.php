<ul class="uk-navbar-nav nav-hmpg">
  @if( Cookie::get('hasLoginCustomers') )
  <li><a class="navcusticon" uk-tooltip="title: Transaksi; pos: bottom"><span><i class="fas fa-exchange-alt"></i></span></a></li>
  <li><a class="navcusticon" uk-tooltip="title: Notifikasi; pos: bottom"><span><i class="far fa-bell"></i></span></a></li>
  <li><a href="{{ route('accountcustomer_page') }}">{{ $users->customer_name }} <span class="uk-margin-small-left"><i class="fas fa-caret-down"></i></span></a>
    <div class="uk-navbar-dropdown navbarhmpgdropdowncustomer">
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
  <li><a href="{{ route('withdrawvendor_page') }}">Rp. {{ number_format( $users->credits_balance, 0, ',', '.' ) }}</a></li>
  <li><a class="navcusticon" uk-tooltip="title: Transaksi; pos: bottom"><span><i class="fas fa-exchange-alt"></i></span></a></li>
  <li><a class="navcusticon" uk-tooltip="title: Notifikasi; pos: bottom"><span><i class="far fa-bell"></i></span></a></li>
  <li><a href="#">{{ $users->vendor_name }} <span class="uk-margin-small-left"><i class="fas fa-caret-down"></i></span></a>
    <div class="uk-navbar-dropdown navbarhmpgdropdowncustomer">
      <ul class="uk-nav uk-navbar-dropdown-nav">
        <li><a href="{{ route('accountvendor_page') }}">Dashboard</a></li>
        <li><a href="{{ route('premium') }}">Berlangganan Premium</a></li>
        <li class="uk-nav-divider"></li>
        <li><a href="{{ route('vendorportfolio_page') }}">Galeri Portfolio</a></li>
        <li><a href="{{ route('messagevendor_page') }}">Pesan</a></li>
        <li><a href="{{ route('orderlistvendor_page') }}">Daftar Transaksi</a></li>
        <li class="uk-nav-divider"></li>
        <li><a href="{{ route('editaccountvendor_page') }}">Pengaturan Vendor</a></li>
        <li><a href="{{ route('logoutvendor') }}">Keluar</a></li>
      </ul>
    </div>
  </li>
  @else
  <li><a href="{{ route('aboutus') }}">Tentang Kami</a></li>
  <li><a href="{{ route('discoveryvendor_page') }}">Cari Vendor</a></li>
  <li><a class="" href="{{ route('signuppage') }}"><div>Daftar</div></a></li>
  <li><a class="loginascustomer" href="{{ route('loginpage') }}"><div>Masuk</div></a></li>
  @endif
</ul>
