<template lang="html">
<div>
  <section class="uk-cover-container cover-joinasvendor">
    <img :src="url + '/images/banner/Banner10.jpg'" alt="" uk-cover>
    <div class="uk-overlay uk-overlay-primary uk-position-cover uk-light cover-overlay-joinasvendor"></div>
  </section>
  <div class="uk-container">
    <div class="uk-width-3-4 uk-align-center container-joinasvendor">
      <div class="uk-margin-bottom slugtext-joinasvendor">Bergabung dengan Mitra kami di seluruh Nusantara Indonesia</div>
      <div class="uk-card uk-card-default uk-card-body sectioncontainer-joinasvendor">
        <!--<h3 class="sectionheading-joinasvendor">Pendaftaran Vendor</h3>-->
        <div class="uk-padding uk-margin-bottom sectionbox-joinasvendor">
          <div>Kami perlu tahu tentang diri Anda</div>
          <span>Silahkan lengkapi formulir dengan informasi yang valid. Informasi ini tidak akan muncul di profil Anda</span>
        </div>
        <div v-if="errorMessage" class="uk-alert-danger" uk-alert>{{ errorMessage }}</div>
        <form class="uk-form-stacked" @submit.prevent="registerVendor">
          <div class="uk-margin">
            <label class="uk-form-label label-joinasvendor">Nama Anda *</label>
            <div class="uk-form-controls">
              <input type="text" class="uk-width-1-1 uk-input form-joinasvendor" v-model="forms.vendor_ownername">
            </div>
            <div v-if="errors.vendor_ownername" class="uk-text-danger uk-text-small">{{ errors.vendor_ownername }}</div>
          </div>
          <div class="uk-margin">
            <label class="uk-form-label label-joinasvendor">Nomor Ponsel Anda *</label>
            <div class="uk-form-controls">
              <input type="text" class="uk-width-1-1 uk-input form-joinasvendor" v-model="forms.phonenumber">
            </div>
            <div v-if="errors.phonenumber" class="uk-text-danger uk-text-small">{{ errors.phonenumber }}</div>
          </div>
          <div class="uk-margin">
            <label class="uk-form-label label-joinasvendor">Nomor Telepon Bisnis *</label>
            <div class="uk-form-controls">
              <input type="text" class="uk-width-1-1 uk-input form-joinasvendor" v-model="forms.phonenumber_business">
            </div>
            <div v-if="errors.phonenumber_business" class="uk-text-danger uk-text-small">{{ errors.phonenumber_business }}</div>
          </div>
          <div class="uk-margin">
            <label class="uk-form-label label-joinasvendor">Nama Jasa/Vendor *</label>
            <div class="uk-form-controls">
              <input type="text" class="uk-width-1-1 uk-input form-joinasvendor" v-model="forms.vendor_name">
            </div>
            <div v-if="errors.vendor_name" class="uk-text-danger uk-text-small">{{ errors.vendor_name }}</div>
          </div>
          <div class="uk-margin">
            <div class="uk-grid-small" uk-grid>
              <div class="uk-width-1-4@xl uk-width-1-4@l uk-width-1-2@m uk-width-1-1@s">
                <label class="uk-form-label label-joinasvendor">Provinsi *</label>
                <div class="uk-form-controls">
                  <select class="uk-width-1-1 uk-select form-joinasvendor" v-model="forms.provinsi" @change="getKabupaten()">
                    <option value="" selected>-- Pilih Provinsi --</option>
                    <option v-for="prov in provinsi" :value="prov.id">{{ prov.nama }}</option>
                  </select>
                  <div v-if="errors.provinsi" class="uk-text-danger uk-text-small">{{ errors.provinsi }}</div>
                </div>
              </div>
              <div class="uk-width-1-4@xl uk-width-1-4@l uk-width-1-2@m uk-width-1-1@s">
                <label class="uk-form-label label-joinasvendor">Kabupaten/Kota *</label>
                <div class="uk-form-controls">
                  <select class="uk-width-1-1 uk-select form-joinasvendor" v-model="forms.kabupaten" @change="getKecamatan()">
                    <option value="" selected>-- Pilih Kabupaten --</option>
                    <option v-for="kab in kabupaten" :value="kab.id">{{ kab.kabupaten }}</option>
                  </select>
                  <div v-if="errors.kabupaten" class="uk-text-danger uk-text-small">{{ errors.kabupaten }}</div>
                </div>
              </div>
              <div class="uk-width-1-4@xl uk-width-1-4@l uk-width-1-2@m uk-width-1-1@s">
                <label class="uk-form-label label-joinasvendor">Kecamatan *</label>
                <div class="uk-form-controls">
                  <select class="uk-width-1-1 uk-select form-joinasvendor" v-model="forms.kecamatan">
                    <option value="" selected>-- Pilih Kecamatan --</option>
                    <option v-for="kec in kecamatan" :value="kec.id">{{ kec.kecamatan }}</option>
                  </select>
                  <div v-if="errors.kecamatan" class="uk-text-danger uk-text-small">{{ errors.kecamatan }}</div>
                </div>
              </div>
              <div class="uk-width-1-4@xl uk-width-1-4@l uk-width-1-2@m uk-width-1-1@s">
                <label class="uk-form-label label-joinasvendor">Kode Pos</label>
                <div class="uk-form-controls">
                  <input type="number" class="uk-width-1-1 uk-input form-joinasvendor" v-model="forms.zipcode">
                </div>
                <div v-if="errors.zipcode" class="uk-text-danger uk-text-small">{{ errors.zipcode }}</div>
              </div>
              <div class="uk-width-expand">
                <label class="uk-form-label label-joinasvendor">Alamat</label>
                <div class="uk-form-controls">
                  <textarea v-model="forms.address" class="uk-textarea uk-height-small form-joinasvendor"></textarea>
                </div>
                <div v-if="errors.address" class="uk-text-danger uk-text-small">{{ errors.address }}</div>
              </div>
            </div>
          </div>
          <div class="uk-margin">
            <div class="uk-grid-small" uk-grid>
              <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-1@s">
                <div class="uk-margin">
                  <label class="uk-form-label label-joinasvendor">Alamat Email *</label>
                  <div class="uk-form-controls">
                    <input type="email" class="uk-width-1-1 uk-input form-joinasvendor" v-model="forms.vendor_email">
                  </div>
                  <div v-if="errors.vendor_email" class="uk-text-danger uk-text-small">{{ errors.vendor_email }}</div>
                </div>
              </div>
              <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-1@s">
                <div class="uk-margin">
                  <label class="uk-form-label label-joinasvendor">Kata Sandi *</label>
                  <div class="uk-form-controls">
                    <input type="password" class="uk-width-1-1 uk-input form-joinasvendor" v-model="forms.password" placeholder="Minimal 8 karakter">
                  </div>
                  <div v-if="errors.password" class="uk-text-danger uk-text-small">{{ errors.password }}</div>
                </div>
              </div>
            </div>
          </div>
          <div class="uk-margin">
            <button type="submit" v-html="forms.submit" class="uk-button uk-button-default button-joinasvendor">Daftar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</template>

<script>
export default {
  props: ['url'],
  data() {
    return {
      provinsi: [],
      kabupaten: [],
      kecamatan: [],
      forms: {
        error: true,
        vendor_ownername: '',
        phonenumber: '',
        phonenumber_business: '',
        vendor_email: '',
        vendor_name: '',
        provinsi: '',
        kabupaten: '',
        kecamatan: '',
        address: '',
        zipcode: '',
        password: '',
        submit: 'Daftar'
      },
      errors: {},
      errorMessage: ''
    }
  },
  methods: {
    getProvinsi() {
      axios({
        method: 'get',
        url: this.url + '/api/provinsi/all'
      }).then( res => {
        let result = res.data;
        this.provinsi = result.data;
      }).catch( err => {
        console.log( err.response.statusText );
      });
    },
    getKabupaten()
    {
      axios({
        method: 'get',
        url: this.url + '/api/kabupaten/provinsi/' + this.forms.provinsi
      }).then( res => {
        let result = res.data;
        this.kabupaten = result.data;
      }).catch( err => {
        console.log( err.response.statusText );
      });
    },
    getKecamatan()
    {
      axios({
        method: 'get',
        url: this.url + '/api/kecamatan/kabupaten/' + this.forms.kabupaten
      }).then( res => {
        let result = res.data;
        this.kecamatan = result.data;
      }).catch( err => {
        console.log( err.response.statusText );
      });
    },
    registerVendor()
    {
      this.errors = {};
      this.errorMessage = '';
      if( this.forms.vendor_ownername === '' )
      {
        this.forms.error = true;
        this.errors.vendor_ownername = 'Nama lengkap wajib diisi.';
      }
      if( this.forms.phonenumber === '' )
      {
        this.forms.error = true;
        this.errors.phonenumber = 'Nomor ponsel wajib diisi.';
      }
      if( this.forms.phonenumber === '' )
      {
        this.forms.error = true;
        this.errors.phonenumber_business = 'Nomor telepon bisnis wajib diisi.';
      }
      if( this.forms.vendor_email === '' )
      {
        this.forms.error = true;
        this.errors.vendor_email = 'Email wajib diisi.';
      }
      if( this.forms.vendor_name === '' )
      {
        this.forms.error = true;
        this.errors.vendor_name = 'Nama jasa/vendor wajib diisi.';
      }
      if( this.forms.provinsi === '' )
      {
        this.forms.error = true;
        this.errors.provinsi = 'Silahkan pilih provinsi.';
      }
      if( this.forms.kabupaten === '' )
      {
        this.forms.error = true;
        this.errors.kabupaten = 'Silahkan pilih kota/kabupaten.';
      }
      if( this.forms.kecamatan === '' )
      {
        this.forms.error = true;
        this.errors.kecamatan = 'Silahkan pilih kecamatan.';
      }
      if( this.forms.address === '' )
      {
        this.forms.error = true;
        this.errors.address = 'Alamat wajib diisi';
      }
      if( this.forms.zipcode === '' )
      {
        this.forms.error = true;
        this.errors.zipcode = 'Kode pos wajib diisi.';
      }
      if( this.forms.password === '' )
      {
        this.forms.error = true;
        this.errors.password = 'Kata sandi wajib diisi.';
      }
      if( this.forms.error === true )
      {
        this.forms.error = false;
        return this.forms.error;
      }
      if( this.getLengthPassword < 8 )
      {
        this.errors.password = 'Kata sandi minimal 8 karakter.';
        return false;
      }

      this.forms.submit = '<span uk-spinner></span>';
      axios({
        method: 'post',
        url: this.url + '/vendor/doregister',
        headers: {'Content-Type': 'application/json'},
        params: {
          vendor_name: this.forms.vendor_name,
          phonenumber: this.forms.phonenumber,
          phonenumber_business: this.forms.phonenumber_business,
          region: this.forms.provinsi,
          district: this.forms.kabupaten,
          subdistrict: this.forms.kecamatan,
          address: this.forms.address,
          zipcode: this.forms.zipcode,
          vendor_ownername: this.forms.vendor_ownername,
          vendor_email: this.forms.vendor_email,
          password: this.forms.password
        }
      }).then( res => {
        let result = res.data;
        this.errors = {};
        this.errorMessage = '';

        var redirect = this.url + '/';
        setTimeout(function(){ document.location = redirect; }, 2000);
      }).catch( err => {
        let status = err.response.status;
        if( status === 409 )
        {
          this.errorMessage = err.response.data.statusText;
        }
        else
        {
          this.errorMessage = status + ' ' + err.response.statusText;
        }
        swal({
          title: 'Terjadi kesalahan',
          text: this.errorMessage,
          icon: 'warning',
          dangerMode: true,
          timer: 4000
        });
        this.forms.submit = 'Daftar';
      });
    }
  },
  computed: {
    getLengthPassword: function() {
      let str = this.forms.password;
      return str.length;
    }
  },
  mounted() {
    this.getProvinsi();
  }
}
</script>
