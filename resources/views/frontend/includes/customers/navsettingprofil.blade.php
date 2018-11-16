<nav class="uk-card uk-card-body uk-card-default uk-card-small navcustsetting">
  <ul class="uk-nav uk-nav-default">
    @php $membersince = new DateTime( $myaccount->customer_registered ) @endphp
    <li class="uk-nav-header membersince">Anggota sejak: {{ $membersince->format('M d, Y') }}</li>
    <li><a href="{{ route('editprofilecustomer_page') }}">Rincian Akun</a></li>
    <li><a href="{{ route('changepasswordcustomer_page') }}">Ganti Password</a></li>
    <li><a href="{{ route('editemailcustomer_page') }}">Alamat Email</a></li>
    <li><a href="{{ route('editteleponcustomer_page') }}">Nomor Telepon</a></li>
    <li><a href="{{ route('rekeningbankcustomer_page') }}">Rekening Bank</a></li>
  </ul>
</nav>
