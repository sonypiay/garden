<nav class="uk-card uk-card-default uk-card-body uk-card-small uk-height-viewport navsidebar">
  <ul class="uk-nav uk-nav-default">
    <li class="uk-nav-header heading">Menu Utama</li>
    <li><a href="{{ route('accountvendor_page') }}">Dashboard</a></li>
    <li><a href="#">Upgrade Pro</a></li>
    <li class="uk-nav-divider"></li>
    <li class="uk-nav-header heading">Akun Saya</li>
    <li><a href="{{ route('vendorportfolio_page') }}">Galeri Portfolio</a></li>
    <li><a href="#">Kotak Pesan</a></li>
    <li><a href="{{ route('orderlistvendor_page') }}">Daftar Transaksi</a></li>
    <li class="uk-nav-divider"></li>
    <li><a href="{{ route('editaccountvendor_page') }}">Pengaturan Vendor</a></li>
    <li><a href="{{ route('logoutvendor') }}">Keluar</a></li>
  </ul>
</nav>
