<ul class="uk-navbar-nav nav-hmpg">
  @if( Cookie::get('hasLoginCustomers') )
  <li><a>Rp. 0</a></li>
  <li><a class="navcusticon" uk-tooltip="title: Transaksi; pos: bottom"><span><i class="fas fa-exchange-alt"></i></span></a></li>
  <li><a class="navcusticon" uk-tooltip="title: Notifikasi; pos: bottom"><span><i class="far fa-bell"></i></span></a></li>
  <li><a href="{{ route('accountcustomer_page') }}">{{ $users->customer_name }} <span class="uk-margin-small-left"><i class="fas fa-caret-down"></i></span></a>
    <div class="uk-navbar-dropdown navbarhmpgdropdowncustomer">
      <ul class="uk-nav uk-navbar-dropdown-nav">
        <li><a href="#">Kotak Pesan</a></li>
        <li><a href="#">GardenBuana Pay</a></li>
        <li><a href="#">Vendor Pilihan</a></li>
        <li><a href="#">Pesanan</a></li>
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
  <li><a href="#">{{ $users->vendor_name }} <span class="uk-margin-small-left"><i class="fas fa-caret-down"></i></span></a>
    <div class="uk-navbar-dropdown navbarhmpgdropdowncustomer">
      <ul class="uk-nav uk-navbar-dropdown-nav">
        <li><a href="{{ route('accountvendor_page') }}">Dashboard</a></li>
        <li><a href="#">Upgrade Pro</a></li>
        <li><a href="#">GardenBuana Pay</a></li>
        <li class="uk-nav-divider"></li>
        <li><a href="#">Galeri</a></li>
        <li><a href="#">Kotak Pesan</a></li>
        <li><a href="#">Pesanan</a></li>
        <li class="uk-nav-divider"></li>
        <li><a href="#">Pengaturan Vendor</a></li>
        <li><a href="#">Edit Profil &amp; Pengaturan</a></li>
        <li><a href="{{ route('logoutvendor') }}">Keluar</a></li>
      </ul>
    </div>
  </li>
  @else
  <li><a class="become-vendor" href="{{ route('loginpage_vendor') }}">Masuk sebagai Vendor</a></li>
  <li><a href="{{ route('loginpage_customer') }}">Masuk sebagai Pengguna</a></li>
  @endif
</ul>
