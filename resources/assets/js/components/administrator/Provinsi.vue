<template lang="html">
<div class="uk-margin-large-top uk-margin-large-bottom">
  <div id="modal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
      <a class="uk-modal-close-default" uk-close></a>
      <h3>
        <span v-if="forms.edit">Ubah Provinsi</span>
        <span v-else>Tambah Provinsi</span>
      </h3>
      <div v-if="errorMessage" class="uk-alert-danger" uk-alert>{{ errorMessage }}</div>
      <form class="uk-form-stacked" @submit.prevent="addOrUpdateProvinsi">
        <div class="uk-margin">
          <label class="uk-form-label">Kode Provinsi</label>
          <div class="uk-form-controls">
            <input type="text" class="uk-width-1-1 uk-input form-action-custom-modal" v-model="forms.kode">
          </div>
          <div v-if="forms.errors.kode" class="uk-text-small uk-text-danger">{{ forms.errors.kode }}</div>
        </div>
        <div class="uk-margin">
          <label class="uk-form-label">Nama Provinsi</label>
          <div class="uk-form-controls">
            <input type="text" class="uk-width-1-1 uk-input form-action-custom-modal" v-model="forms.nama">
          </div>
          <div v-if="forms.errors.nama" class="uk-text-small uk-text-danger">{{ forms.errors.nama }}</div>
        </div>
        <div class="uk-margin">
          <button class="uk-button uk-button-default button-action-modal" v-html="forms.submit"></button>
        </div>
      </form>
    </div>
  </div>

  <div class="uk-card uk-card-body uk-card-default">
    <div class="uk-grid-small" uk-grid>
      <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-2-3@m uk-width-1-2@s">
        <div class="uk-width-1-1 uk-inline">
          <a class="uk-form-icon" uk-icon="search" @click="getProvinsiList( pagination.path + '?page=' + pagination.current )"></a>
          <input @keyup.enter="getProvinsiList( pagination.path + '?page=' + pagination.current )" type="keywords" class="uk-input form-search uk-width-1-1" v-model="keywords" placeholder="Search...">
        </div>
      </div>
      <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-2-3@m uk-width-1-2@s">
        <a class="uk-button button-custom-action" @click="addOrUpdateModal()">Tambah</a>
      </div>
    </div>

    <div class="uk-overflow-auto uk-margin-top">
      <table class="uk-table uk-table-small uk-table-divider uk-table-middle table-rows">
        <thead>
          <tr>
            <th>#</th>
            <th>Kode Provinsi</th>
            <th>Nama Provinsi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="prov in provinsi.results">
            <td class="uk-width-small">
              <a @click="addOrUpdateModal(prov)" uk-icon="pencil" class="uk-button uk-button-text" uk-tooltip title="Ubah" href="#"></a>
              <a @click="deleteProvinsi(prov.id_provinsi, prov.nama_provinsi)" uk-icon="trash" class="uk-button uk-button-text" uk-tooltip title="Hapus" href="#"></a>
            </td>
            <td class="uk-width-small">{{ prov.kode_provinsi }}</td>
            <td>{{ prov.nama_provinsi }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
</template>

<script>
export default {
  props: ['url'],
  data() {
    return {
      keywords: '',
      pagination: {
        current: 1,
        prev: '',
        next: '',
        last: '',
        path: this.url + '/provinsi/data_provinsi'
      },
      provinsi: {
        total: 0,
        results: []
      },
      forms: {
        id: 0,
        kode: '',
        nama: '',
        edit: false,
        errors: {},
        submit: 'Tambah'
      },
      errorMessage: ''
    }
  },
  methods: {
    addOrUpdateModal(prov)
    {
      if( prov === undefined || prov === '' )
      {
        this.forms.id = 0;
        this.forms.kode = '';
        this.forms.nama = '';
        this.forms.edit = false;
        this.forms.errors = {};
        this.forms.submit = 'Tambah';
      }
      else
      {
        this.forms.id = prov.id_provinsi;
        this.forms.kode = prov.kode_provinsi;
        this.forms.nama = prov.nama_provinsi;
        this.forms.edit = true;
        this.forms.errors = {};
        this.forms.submit = 'Simpan';
      }
      this.errorMessage = '';
      UIkit.modal('#modal').show();
    },
    getProvinsiList(pages)
    {
      var params = '&keywords=' + this.keywords;
      if( pages === undefined )
        pages = this.url + '/provinsi/data_provinsi?page=' + this.pagination.current + params;
      else
        pages = pages + params;

      axios({
        method: 'get',
        url: pages
      }).then( res => {
        let result = res.data;
        this.provinsi.total = result.total;
        this.provinsi.results = result.data;
      }).catch( err => {
        console.log(err.response.status);
      })
    },
    addOrUpdateProvinsi()
    {
      this.forms.errors = {};
      if( this.forms.kode === '' )
      {
        this.forms.errors.error = true;
        this.forms.errors.kode = 'Kode provinsi wajib diisi.';
      }
      if( this.forms.nama === '' )
      {
        this.forms.errors.error = true;
        this.forms.errors.nama = 'Nama provinsi wajib diisi.';
      }
      if( this.forms.errors.error === true )
      {
        this.forms.errors.error = false;
        return false;
      }

      var method, url;
      if( this.forms.edit === false )
      {
        method = 'post'; url = this.url + '/provinsi/add';
      }
      else
      {
        method = 'put'; url = this.url + '/provinsi/update/' + this.forms.id;
      }

      this.forms.submit = '<span uk-spinner></span>';
      axios({
        method: method,
        url: url,
        params: {
          kode_provinsi: this.forms.kode,
          nama_provinsi: this.forms.nama
        }
      }).then( res => {
        swal({
          title: 'Berhasil',
          text: res.data.statusText,
          icon: 'success',
          timer: 5000
        });
        this.errorMessage = '';
        this.getProvinsiList();
        setTimeout(function(){ UIkit.modal('#modal').hide(); }, 3000);
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
        swal({
          title: 'Terjadi kesalahan',
          text: this.errorMessage,
          icon: 'warning',
          dangerMode: true
        });
      });

      if( this.forms.edit === true ) this.forms.submit = 'Simpan';
    },
    deleteProvinsi(id, val)
    {
      swal({
        title: 'Konfirmasi',
        text: 'Apakah anda ingin menghapus provinsi ' + val + '?',
        icon: 'warning',
        dangerMode: true,
        buttons: {
          cancel: true,
          confirm: { text: 'Hapus', value: true }
        }
      }).then( value => {
        if( value )
        {
          axios({
            method: 'delete',
            url: this.url + '/provinsi/delete/' + id
          }).then( res => {
            swal({
              title: 'Berhasil',
              text: res.data.statusText,
              icon: 'success'
            });
            this.getProvinsiList();
          }).catch( err => {
            swal({
              title: 'Terjadi kesalahan',
              text: err.response.statusText,
              icon: 'warning',
              dangerMode: true
            });
          });
        }
      });
    }
  },
  mounted() {
    this.getProvinsiList();
  }
}
</script>
