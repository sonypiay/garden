<div class="uk-navbar navsetvendor" uk-navbar>
  <ul class="uk-navbar-nav">
    <li @if( $request->route()->getName() == 'editaccountvendor_page' ) class="active" @endif><a href="{{ route('editaccountvendor_page') }}">Informasi Akun</a></li>
    <li @if( $request->route()->getName() == 'changepasswordvendor_page' ) class="active" @endif><a href="{{ route('changepasswordvendor_page') }}">Password</a></li>
    <li @if( $request->route()->getName() == 'editemailvendor_page' ) class="active" @endif><a href="{{ route('editemailvendor_page') }}">Alamat Email</a></li>
    <li @if( $request->route()->getName() == 'editteleponvendor_page' ) class="active" @endif><a href="{{ route('editteleponvendor_page') }}">Nomor Telepon</a></li>
    <li><a href="{{ route('rekeningbankcustomer_page') }}">Rekening Pencairan</a></li>
    <li><a href="#">Branding Logo</a></li>
    <li><a href="#">Alamat Vendor</a></li>
    <li><a href="#">Status Vendor</a></li>
  </ul>
</div>
