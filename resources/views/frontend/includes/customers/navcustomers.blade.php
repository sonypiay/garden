<nav class="uk-card uk-card-body uk-card-default uk-card-small uk-height-viewport navsidebar">
  <ul class="uk-nav uk-nav-default">
    <li class="uk-nav-header heading">Menu Utama</li>
    <li><a href="{{ route('accountcustomer_page') }}">Dashboard</a></li>
    <li><a href="#">Kotak Pesan</a></li>
    <li><a href="{{ route('customerorderlist_page') }}">Daftar Transaksi</a></li>
    <li class="uk-nav-divider"></li>
    <li class="uk-nav-header heading">Akun Saya</li>
    <li><a href="{{ route('editprofilecustomer_page') }}">Edit Profil &amp; Pengaturan</a></li>
    <li><a href="{{ route('logoutcustomer') }}">Keluar</a></li>
  </ul>
</nav>
