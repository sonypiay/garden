<template lang="html">
  <div class="uk-margin-top">
    <div class="uk-card uk-card-default uk-card-body container-settingaccount">
      <h3 class="content_headingsettingprofile">Ubah Informasi Akun</h3>
      <div v-if="errorMessage" class="uk-alert-danger" uk-alert>{{ errorMessage }}</div>
      <form class="uk-form-action" @submit.prevent="onUpdateAccount">
        <div class="uk-margin">
          <label class="uk-form-label form-settinglabel">Tautan Anda</label>
          <div class="uk-form-controls">
            <input type="text" class="uk-width-1-1 uk-input form-settingaction" :value="url + '/discovery/vendor/' + vendors.slugname + '/' + vendors.id" disabled>
          </div>
        </div>
        <div class="uk-margin">
          <label class="uk-form-label form-settinglabel">Nama Anda</label>
          <div class="uk-form-controls">
            <input type="text" placeholder="Nama Anda" class="uk-width-1-1 uk-input form-settingaction" v-model="vendors.ownername">
          </div>
          <div v-if="errors.ownername" class="uk-text-danger uk-text-small">{{ errors.ownername }}</div>
        </div>
        <div class="uk-margin">
          <label class="uk-form-label form-settinglabel">Nama Vendor</label>
          <div class="uk-form-controls">
            <input type="text" placeholder="Nama Vendor" class="uk-width-1-1 uk-input form-settingaction" v-model="vendors.name">
          </div>
          <div v-if="errors.name" class="uk-text-danger uk-text-small">{{ errors.name }}</div>
        </div>
        <div class="uk-margin">
          <div class="uk-grid-small" uk-grid>
            <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-width-1-1@s">
              <label class="uk-form-label form-settinglabel">Provinsi</label>
              <div class="uk-form-controls">
                <select class="uk-width-1-1 uk-select form-settingaction" v-model="vendors.region" @change="getKabupaten()">
                  <option value="" selected>-- Pilih Provinsi --</option>
                  <option v-for="prov in provinsi" :value="prov.id">{{ prov.nama }}</option>
                </select>
                <div v-if="errors.provinsi" class="uk-text-danger uk-text-small">{{ errors.provinsi }}</div>
              </div>
            </div>
            <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-width-1-1@s">
              <label class="uk-form-label form-settinglabel">Kabupaten/Kota</label>
              <div class="uk-form-controls">
                <select class="uk-width-1-1 uk-select form-settingaction" v-model="vendors.district" @change="getKecamatan()">
                  <option value="" selected>-- Pilih Kabupaten --</option>
                  <option v-for="kab in kabupaten" :value="kab.id">{{ kab.kabupaten }}</option>
                </select>
                <div v-if="errors.kabupaten" class="uk-text-danger uk-text-small">{{ errors.kabupaten }}</div>
              </div>
            </div>
            <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-width-1-1@s">
              <label class="uk-form-label form-settinglabel">Kecamatan</label>
              <div class="uk-form-controls">
                <select class="uk-width-1-1 uk-select form-settingaction" v-model="vendors.subdistrict">
                  <option value="" selected>-- Pilih Kecamatan --</option>
                  <option v-for="kec in kecamatan" :value="kec.id">{{ kec.kecamatan }}</option>
                </select>
                <div v-if="errors.kecamatan" class="uk-text-danger uk-text-small">{{ errors.kecamatan }}</div>
              </div>
            </div>
          </div>
        </div>
        <div class="uk-margin">
          <label class="uk-form-label form-settinglabel">Alamat Vendor</label>
          <div class="uk-form-controls">
            <textarea class="uk-textarea form-settingaction" rows="8" cols="80" v-model="vendors.address" placeholder="Alamat Vendor"></textarea>
          </div>
          <div v-if="errors.address" class="uk-text-danger uk-text-small">{{ errors.address }}</div>
        </div>
        <div class="uk-margin">
          <label class="uk-form-label form-settinglabel">Kode Pos</label>
          <div class="uk-form-controls">
            <input type="text" class="uk-width-1-1 uk-input form-settingaction" v-model="vendors.zipcode">
          </div>
          <div v-if="errors.zipcode" class="uk-text-danger uk-text-small">{{ errors.zipcode }}</div>
        </div>
        <div class="uk-margin">
          <button v-html="forms.submit" class="uk-button uk-button-default btn_settingaction">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  props: ['url','vendors'],
  data() {
    return {
      forms: {
        error: false,
        submit: 'Ubah Data'
      },
      provinsi: [],
      kabupaten: [],
      kecamatan: [],
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
    getKabupaten(val)
    {
      var url;
      if( val === undefined )
        url = this.url + '/api/kabupaten/provinsi/' + this.vendors.region;
      else
        url = this.url + '/api/kabupaten/all';

      axios({
        method: 'get',
        url: url
      }).then( res => {
        let result = res.data;
        this.kabupaten = result.data;
      }).catch( err => {
        console.log( err.response.statusText );
      });
    },
    getKecamatan(val)
    {
      var url;
      if( val === undefined )
        url = this.url + '/api/kecamatan/kabupaten/' + this.vendors.district;
      else
        url = this.url + '/api/kecamatan/all';

      axios({
        method: 'get',
        url: url
      }).then( res => {
        let result = res.data;
        this.kecamatan = result.data;
      }).catch( err => {
        console.log( err.response.statusText );
      });
    },
    onUpdateAccount()
    {
      this.errors = {};
      this.errorMessage = '';
      if( this.vendors.ownername === '' )
      {
        this.forms.error = true;
        this.errors.ownername = 'Nama Anda wajib diisi.';
      }
      if( this.vendors.name === '' )
      {
        this.forms.error = true;
        this.errors.name = 'Nama Vendor wajib diisi.';
      }
      if( this.vendors.region === '' )
      {
        this.forms.error = true;
        this.errors.region = 'Provinsi tidak boleh kosong.';
      }
      if( this.vendors.district === '' )
      {
        this.forms.error = true;
        this.errors.district = 'Kota tidak boleh kosong.';
      }
      if( this.vendors.subdistrict === '' )
      {
        this.forms.error = true;
        this.errors.subdistrict = 'Kecamatan tidak boleh kosong.';
      }

      if( this.forms.error === true )
      {
        this.forms.error = false;
        return this.forms.error;
      }
      this.forms.submit = '<span uk-spinner></span>';
      axios({
        method: 'put',
        url: this.url + '/vendor/account/edit_account',
        headers: {
          'Content-Type': 'application/json'
        },
        params: {
          vendor_name: this.vendors.name,
          ownername: this.vendors.ownername,
          region: this.vendors.region,
          district: this.vendors.district,
          subdistrict: this.vendors.subdistrict,
          address: this.vendors.address,
          kodepos: this.vendors.zipcode
        }
      }).then( res => {
        swal({
          title: 'Berhasil',
          text: res.data.statusText,
          icon: 'success',
          timer: 5000
        });
        this.errors = {};
        this.errorMessage = '';
      }).catch( err => {
        swal({
          title: 'Terjadi kesalahan',
          text: err.response.status + ' ' + err.response.statusText,
          icon: 'error',
          timer: 5000,
          dangerMode: true
        });
      });
      this.forms.submit = 'Ubah Data';
    }
  },
  mounted() {
    this.getProvinsi('all'); this.getKabupaten('all'); this.getKecamatan('all');
  }
}
</script>
