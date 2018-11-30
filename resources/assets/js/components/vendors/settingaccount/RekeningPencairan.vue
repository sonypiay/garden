<template lang="html">
<div class="uk-margin-top">
  <div id="modal_rekeningbank" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-padding-large modal-body">
      <a class="uk-modal-close-default" uk-close></a>
      <div class="uk-text-center modal_heading">
        <h4 class="modal_textheading">
          <span v-if="forms.edit">Ubah Rekening Bank</span>
          <span v-else>Tambah Rekening Bank</span>
        </h4>
        <div class="modal_subtextheading">
          Pastikan Nomor Rekening &amp; Nama Pemilik Rekening sesuai buku tabungan.<br>
          Maksimal hanya 3 rekening bank.
        </div>
      </div>
      <span v-if="errorMessage">
        <div class="uk-margin-bottom uk-margin-top uk-alert-danger" uk-alert>{{ errorMessage }}</div>
      </span>
      <form class="uk-margin-top uk-form-stacked" @submit.prevent="addOrUpdateRekening">
        <div class="uk-margin">
          <label class="uk-form-label form-settinglabel">Nama Bank</label>
          <div class="uk-form-controls">
            <select class="uk-select form-settingaction" v-model="forms.bank">
              <option value="" selected>-- Pilih Bank --</option>
              <option v-for="bank in bankcustomer" :value="bank.bank_id">{{ '(' + bank.bank_code + ') ' + bank.bank_name }}</option>
            </select>
          </div>
          <div v-if="errors.bank" class="uk-text-small uk-text-danger">{{ errors.bank }}</div>
        </div>
        <div class="uk-margin">
          <label class="uk-form-label form-settinglabel">Nama Pemilik Rekening</label>
          <div class="uk-form-controls">
            <input type="text" class="uk-width-1-1 uk-input form-settingaction" v-model="forms.namapemilik">
          </div>
          <div v-if="errors.namapemilik" class="uk-text-small uk-text-danger">{{ errors.namapemilik }}</div>
        </div>
        <div class="uk-margin">
          <label class="uk-form-label form-settinglabel">No Rekening</label>
          <div class="uk-form-controls">
            <input type="text" class="uk-width-1-1 uk-input form-settingaction" v-model="forms.rekening">
          </div>
          <div v-if="errors.rekening" class="uk-text-small uk-text-danger">{{ errors.rekening }}</div>
        </div>
        <div class="uk-margin">
          <button class="uk-button btn_settingaction" v-html="forms.btnsubmit"></button>
        </div>
      </form>
    </div>
  </div>
  <div class="uk-card uk-card-body uk-card-default container-settingaccount">
    <h3 class="content_headingsettingprofile">Rekening Pencairan</h3>
    <a class="uk-margin-top uk-margin-bottom uk-button btn_settingaction" @click="addOrUpdateModal()">Tambah Rekening</a>
    <div class="uk-overflow-auto">
      <table class="uk-table uk-table-condensed uk-table-small uk-table-striped uk-table-divider uk-table-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>Nama Bank</th>
            <th>Nama Pemilik Rekening</th>
            <th>No. Rekening</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="rek in rekeningbank.results">
            <td>
              <a class="uk-button uk-button-text" @click="addOrUpdateModal(rek)" uk-tooltip="title: Ubah"><span uk-icon="pencil"></span></a>
              <a class="uk-button uk-button-text" @click="deleteRekening(rek.id)" uk-tooltip="title: Hapus"><span uk-icon="trash"></span></a>
            </td>
            <td>{{ rek.bank_name }}</td>
            <td>{{ rek.ownername }}</td>
            <td>{{ rek.account_number }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
</template>

<script>
export default {
  props: ['url', 'vendors', 'bankcustomer'],
  data() {
    return {
      forms: {
        edit: false,
        btnsubmit: 'Tambah',
        id: '',
        bank: '',
        namapemilik: '',
        rekening: '',
        error: false
      },
      rekeningbank: {
        total: 0,
        results: []
      },
      errors: {},
      errorMessage: ''
    }
  },
  methods: {
    addOrUpdateModal(bank) {
      if( bank === undefined || bank === '' )
      {
        this.forms.id = '',
        this.forms.bank = '';
        this.forms.namapemilik = '';
        this.forms.rekening = '';
        this.forms.btnsubmit = 'Tambah';
        this.forms.edit = false;
      }
      else
      {
        this.forms.id = bank.id;
        this.forms.bank = bank.bank_id;
        this.forms.namapemilik = bank.ownername;
        this.forms.rekening = bank.account_number;
        this.forms.btnsubmit = 'Simpan';
        this.forms.edit = true;
        this.forms.error = false;
      }
      this.errors = {};
      this.errorMessage = '';
      UIkit.modal('#modal_rekeningbank').show();
    },
    addOrUpdateRekening()
    {
      this.errors = {};
      if( this.forms.bank === '' )
      {
        this.forms.error = true;
        this.errors.bank = 'Silahkan pilih bank';
      }

      if( this.forms.namapemilik === '' )
      {
        this.forms.error = true;
        this.errors.namapemilik = 'Nama pemilik rekening wajib diisi';
      }

      if( this.forms.rekening === '' )
      {
        this.forms.error = true;
        this.errors.rekening = 'Nomor rekening wajib diisi';
      }

      if( this.forms.error === true )
      {
        this.forms.error = false;
        return this.forms.error;
      }

      var method, url;
      if( this.forms.edit === true )
      {
        method = 'put';
        url = this.url + '/vendor/account/edit_rekeningbank/' + this.forms.id;
      }
      else
      {
        method = 'post';
        url = this.url + '/vendor/account/addrekeningbank';
      }
      this.forms.btnsubmit = '<span uk-spinner></span>';
      axios({
        method: method,
        url: url,
        headers: { 'Content-Type': 'application/json' },
        params: {
          bank: this.forms.bank,
          pemilik: this.forms.namapemilik,
          rekening: this.forms.rekening
        }
      }).then( res => {
        this.errors = {};
        this.errorMessage = '';
        swal({
          title: 'Berhasil',
          text: res.data.statusText,
          icon: 'success'
        });
        this.getRekeningBank();
        setTimeout(function(){ UIkit.modal('#modal_rekeningbank').hide(); }, 2000);
      }).catch( err => {
        let status = err.response.status;
        if( status === 409 )
        {
          this.errorMessage = err.response.data.statusText;
        }
        else
        {
          this.errorMessage = err.response.statusText;
        }
      });

      if( this.forms.edit === true ) this.forms.btnsubmit = 'Simpan';
      else this.forms.btnsubmit = 'Tambah';
    },
    deleteRekening(id)
    {
      swal({
        title: 'Konfirmasi',
        text: 'Apakah anda ingin menghapus rekening ini?',
        icon: 'warning',
        dangerMode: true,
        buttons: {
          cancel: 'Batal',
          confirm: {
            value: true,
            text: 'Hapus'
          }
        }
      }).then( val => {
        if( val )
        {
          axios({
            method: 'delete',
            url: this.url + '/vendor/account/hapusbank/' + id
          }).then( res => {
            swal({
              title: 'Berhasil',
              text: res.data.statusText,
              icon: 'success'
            });
            this.getRekeningBank();
          }).catch( err => {
            swal({
              title: 'Terjadi kesalahan',
              text: err.response.statusText,
              icon: 'danger',
              dangerMode: true
            });
          });
        }
      })
    },
    getRekeningBank() {
      axios({
        method: 'get',
        url: this.url + '/vendor/account/listrekeningbank'
      }).then( res => {
        let result = res.data;
        this.rekeningbank.total = result.total;
        this.rekeningbank.results = result.data;
      }).catch( err => {
        console.log(err.response.statusText);
      });
    }
  },
  mounted() {
    this.getRekeningBank();
  }
}
</script>
