<ul class="uk-nav uk-nav-default uk-nav-parent-icon main-nav" uk-nav>
  <li class="uk-nav-header">Main Menu</li>
  <li><a href="{{ route('dashboard_admin') }}">Dashboard</a></li>
  <li><a href="{{ route('orderlist_admin') }}">Transaksi</a></li>
  <li><a href="#">Pelanggan</a></li>
  <li class="uk-parent"><a href="#">Vendor</a>
    <ul class="uk-nav-sub">
      <li><a href="#">Free</a></li>
      <li><a href="#">Pro</a></li>
    </ul>
  </li>
  <li class="uk-nav-header">Management</li>
  <li><a href="{{ route('admin_provinsipage') }}">Provinsi</a></li>
  <li><a href="{{ route('admin_kabupatenpage') }}">Kabupaten</a></li>
  <li><a href="{{ route('admin_kecamatanpage') }}">Kecamatan</a></li>
  <li><a href="{{ route('admin_bankpayment') }}">Bank Pembayaran</a></li>
  <li><a href="{{ route('admin_bankcustomer') }}">Bank Customer</a></li>
  <li><a href="{{ route('userspage') }}">Users</a></li>
  <li><a href="#">Pengaturan</a></li>
</ul>
