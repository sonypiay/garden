<template lang="html">
<div>
  <div id="modal_rekeningbank" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-padding-large modal-body">
      <a class="uk-modal-close-default" uk-close></a>
      <div class="uk-text-center modal_heading">
        <h4 class="modal_textheading">Tambah Rekening</h4>
        <div class="modal_subtextheading">
          Pastikan Nomor Rekening &amp; Nama Pemilik Rekening sesuai buku tabungan.
        </div>
      </div>
      <div v-if="errors.errorMessage" class="uk-alert-danger" uk-alert>{{ errors.errorMessage }}</div>
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
    <h3 class="content_headingsettingprofile">Rekening Bank</h3>
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
          <tr>
            <td>
              <a class="uk-button uk-button-text" href="#" uk-tooltip="title: Ubah"><span uk-icon="pencil"></span></a>
              <a class="uk-button uk-button-text" href="#" uk-tooltip="title: Hapus"><span uk-icon="trash"></span></a>
            </td>
            <td>BCA</td>
            <td>Sony Darmawan</td>
            <td>83138179</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
</template>

<script>
export default {
  props: ['url', 'customers', 'bankcustomer'],
  data() {
    return {
      errors: {},
      forms: {
        edit: false,
        btnsubmit: 'Tambah',
        id: '',
        bank: '',
        namapemilik: '',
        rekening: '',
        error: false
      }
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
        this.forms.edit = false;
      }
      else
      {
        this.forms.id = bank.bank_id;
        this.forms.bank = bank.bank_code;
        this.forms.namapemilik = bank.ownername;
        this.forms.rekening = bank.account_number;
        this.forms.edit = true;
      }
      UIkit.modal('#modal_rekeningbank').show();
    },
    addOrUpdateRekening()
    {
      this.errors = {};
      if( this.forms.bank === '' )
      {
        this.errors.error = true;
        this.errors.bank = 'Silahkan pilih bank';
      }

      if( this.forms.namapemilik === '' )
      {
        this.errors.error = true;
        this.errors.namapemilik = 'Nama pemilik rekening wajib diisi';
      }

      if( this.forms.rekening === '' )
      {
        this.errors.error = true;
        this.errors.rekening = 'Nomor rekening wajib diisi';
      }

      if( this.errors.error === true )
      {
        this.errors.error = false;
        return this.errors.error;
      }

      var method, url;
      if( this.forms.edit === true )
      {
        method = 'put';
        url = this.url + '/customers/account/rekeningbank/' + this.forms.id;
      }
      else
      {
        method = 'post';
        url = this.url + '/customers/account/addrekeningbank';
      }
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
        console.log(res.data);
      }).catch( err => {
        if( err.response.status === 422 )
        {
          this.errors.errorMessage = err.response.data.statusText;
        }
        else
        {
          this.errors.errorMessage = err.response.statusText;
        }
      });
    }
  }
}
</script>
