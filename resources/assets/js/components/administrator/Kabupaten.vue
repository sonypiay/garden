<template lang="html">
<div class="uk-margin-large-top uk-margin-large-bottom">
  <div id="modal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
      <a class="uk-modal-close-default" uk-close></a>
      <h3>
        <span v-if="forms.edit">Ubah Kabupaten</span>
        <span v-else>Tambah Kabupaten</span>
      </h3>
      <div v-if="errorMessage" class="uk-alert-danger" uk-alert>{{ errorMessage }}</div>
      <form class="uk-form-stacked" @submit.prevent="addOrUpdateKabupaten">
        <div class="uk-margin">
          <label class="uk-form-label">Kode Kabupaten</label>
          <div class="uk-form-controls">
            <input type="text" class="uk-width-1-1 uk-input form-action-custom-modal" v-model="forms.kode">
          </div>
          <div v-if="forms.errors.kode" class="uk-text-small uk-text-danger">{{ forms.errors.kode }}</div>
        </div>
        <div class="uk-margin">
          <label class="uk-form-label">Nama Kabupaten</label>
          <div class="uk-form-controls">
            <input type="text" class="uk-width-1-1 uk-input form-action-custom-modal" v-model="forms.nama">
          </div>
          <div v-if="forms.errors.nama" class="uk-text-small uk-text-danger">{{ forms.errors.nama }}</div>
        </div>
        <div class="uk-margin">
          <label class="uk-form-label">Provinsi</label>
          <div class="uk-form-controls">
            <select class="uk-width-1-1 uk-select form-action-select-modal" v-model="forms.provinsi">
              <option value="" selected>-- Pilih Provinsi --</option>
              <option v-for="prov in provinsi" :value="prov.id_provinsi">{{ prov.nama_provinsi }}</option>
            </select>
          </div>
          <div v-if="forms.errors.provinsi" class="uk-text-small uk-text-danger">{{ forms.errors.provinsi }}</div>
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
          <a class="uk-form-icon" uk-icon="search" @click="getKabupatenList( pagination.path + '?page=' + pagination.current )"></a>
          <input @keyup.enter="getKabupatenList( pagination.path + '?page=' + pagination.current )" type="keywords" class="uk-input form-search uk-width-1-1" v-model="keywords" placeholder="Search...">
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
            <th>Kode Kabupaten</th>
            <th>Nama Kabupaten</th>
            <th>Provinsi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="kab in kabupaten.results">
            <td class="uk-width-small">
              <a @click="addOrUpdateModal(kab)" uk-icon="pencil" class="uk-button uk-button-text" uk-tooltip title="Ubah" href="#"></a>
              <a @click="deleteKabupaten(kab.id_kab, kab.nama_kab)" uk-icon="trash" class="uk-button uk-button-text" uk-tooltip title="Hapus" href="#"></a>
            </td>
            <td class="uk-width-small">{{ kab.kode_kab }}</td>
            <td>{{ kab.nama_kab }}</td>
            <td>{{ kab.nama_provinsi }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
</template>

<script>
export default {
  props: ['url', 'provinsi'],
  data() {
    return {
      keywords: '',
      pagination: {
        current: 1,
        prev: '',
        next: '',
        last: '',
        path: this.url + '/kabupaten/data_kabupaten'
      },
      kabupaten: {
        total: 0,
        results: []
      },
      forms: {
        id: 0,
        kode: '',
        nama: '',
        provinsi: '',
        edit: false,
        errors: {},
        submit: 'Tambah'
      },
      errorMessage: ''
    }
  },
  methods: {
    addOrUpdateModal(kab)
    {
      if( kab === undefined || kab === '' )
      {
        this.forms.id = 0;
        this.forms.kode = '';
        this.forms.nama = '';
        this.forms.provinsi = '';
        this.forms.edit = false;
        this.forms.errors = {};
        this.forms.submit = 'Tambah';
      }
      else
      {
        this.forms.id = kab.id_kab;
        this.forms.kode = kab.kode_kab;
        this.forms.nama = kab.nama_kab;
        this.forms.provinsi = kab.id_provinsi;
        this.forms.edit = true;
        this.forms.errors = {};
        this.forms.submit = 'Simpan';
      }
      this.errorMessage = '';
      UIkit.modal('#modal').show();
    },
    getKabupatenList(pages)
    {
      var params = '&keywords=' + this.keywords;
      if( pages === undefined )
        pages = this.url + '/kabupaten/data_kabupaten?page=' + this.pagination.current + params;
      else
        pages = pages + params;

      axios({
        method: 'get',
        url: pages
      }).then( res => {
        let result = res.data;
        this.kabupaten.total = result.total;
        this.kabupaten.results = result.data;
      }).catch( err => {
        console.log(err.response.status);
      })
    },
    addOrUpdateKabupaten()
    {
      this.forms.errors = {};
      if( this.forms.kode === '' )
      {
        this.forms.errors.error = true;
        this.forms.errors.kode = 'Kode kabupaten wajib diisi.';
      }
      if( this.forms.nama === '' )
      {
        this.forms.errors.error = true;
        this.forms.errors.nama = 'Nama kabupaten wajib diisi.';
      }
      if( this.forms.provinsi === '' )
      {
        this.forms.errors.error = true;
        this.forms.errors.provinsi = 'Provinsi wajib diisi.';
      }
      if( this.forms.errors.error === true )
      {
        this.forms.errors.error = false;
        return false;
      }

      var method, url;
      if( this.forms.edit === false )
      {
        method = 'post'; url = this.url + '/kabupaten/add';
      }
      else
      {
        method = 'put'; url = this.url + '/kabupaten/update/' + this.forms.id;
      }

      this.forms.submit = '<span uk-spinner></span>';
      axios({
        method: method,
        url: url,
        params: {
          kode_kab: this.forms.kode,
          nama_kabupaten: this.forms.nama,
          provinsi: this.forms.provinsi
        }
      }).then( res => {
        swal({
          title: 'Berhasil',
          text: res.data.statusText,
          icon: 'success',
          timer: 5000
        });
        this.errorMessage = '';
        this.getKabupatenList();
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
    deleteKabupaten(id, val)
    {
      swal({
        title: 'Konfirmasi',
        text: 'Apakah anda ingin menghapus kabupaten ' + val + '?',
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
            url: this.url + '/kabupaten/delete/' + id
          }).then( res => {
            swal({
              title: 'Berhasil',
              text: res.data.statusText,
              icon: 'success'
            });
            this.getKabupatenList();
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
    this.getKabupatenList();
  }
}
</script>
