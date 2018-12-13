<ul class="uk-nav uk-nav-default uk-nav-parent-icon main-nav" uk-nav>
  <li class="uk-nav-header">Main Menu</li>
  <li><a href="{{ route('dashboard_admin') }}">Dashboard</a></li>
  <li><a href="{{ route('orderlist_admin') }}">Transaksi</a></li>
  <li><a href="#">Pelanggan</a></li>
  <li><a href="{{ route('admin_vendorpage') }}">Vendor</a></li>
  <li><a href="{{ route('admin_withdraw') }}">Withdraw</a></li>
  <li class="uk-nav-header">Management</li>
  <li><a href="{{ route('admin_provinsipage') }}">Provinsi</a></li>
  <li><a href="{{ route('admin_kabupatenpage') }}">Kabupaten</a></li>
  <li><a href="{{ route('admin_kecamatanpage') }}">Kecamatan</a></li>
  <li><a href="{{ route('admin_bankpayment') }}">Bank Pembayaran</a></li>
  <li><a href="{{ route('admin_bankcustomer') }}">Bank Customer</a></li>
  <li><a href="{{ route('userspage') }}">Users</a></li>
</ul>
