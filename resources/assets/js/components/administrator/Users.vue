<template>
  <div class="uk-margin-large-top uk-margin-large-bottom">
    <!-- modal -->
    <div id="addOrUpdateUser" uk-modal>
      <div class="uk-modal-dialog modal-dialog">
        <a class="uk-modal-close-default" uk-close></a>
        <div class="uk-modal-body modal-body">
          <div class="modal-heading">
            <span v-if="forms.edit">Edit User</span>
            <span v-else>Tambah User</span>
          </div>
          <div class="uk-margin-top">
            <form class="uk-form-stacked" @submit.prevent="addOrUpdateUser">
              <div class="uk-margin">
                <label class="uk-form-label form-label-modal">Nama</label>
                <div class="uk-form-controls">
                  <input type="text" v-model="forms.fullname" class="uk-input form-action-custom-modal" placeholder="Nama Lengkap...">
                  <span v-if="errors.fullname">
                    <div class="uk-alert-warning uk-margin-small-top" uk-alert>{{ errors.fullname }}</div>
                  </span>
                </div>
              </div>
              <div class="uk-margin">
                <label class="uk-form-label form-label-modal">Email</label>
                <div class="uk-form-controls">
                  <input type="email" v-model="forms.email" class="uk-input form-action-custom-modal" placeholder="Alamat Email...">
                  <span v-if="errors.email">
                    <div class="uk-alert-warning uk-margin-small-top" uk-alert>{{ errors.email }}</div>
                  </span>
                </div>
              </div>
              <div class="uk-margin">
                <label class="uk-form-label form-label-modal">Username</label>
                <div class="uk-form-controls">
                  <input type="text" v-model="forms.username" class="uk-input form-action-custom-modal" placeholder="Username...">
                  <span v-if="errors.username">
                    <div class="uk-alert-warning uk-margin-small-top" uk-alert>{{ errors.username }}</div>
                  </span>
                </div>
              </div>
              <div class="uk-margin">
                <label class="uk-form-label form-label-modal">Password</label>
                <div class="uk-form-controls">
                  <input type="password" v-model="forms.password" class="uk-input form-action-custom-modal" placeholder="Password...">
                  <span v-if="errors.password">
                    <div class="uk-alert-warning uk-margin-small-top" uk-alert>{{ errors.password }}</div>
                  </span>
                </div>
              </div>
              <div class="uk-margin">
                <label class="uk-form-label form-label-modal">Privilege</label>
                <div class="uk-form-controls">
                  <select class="uk-select form-action-select-modal" v-model="forms.privilege">
                    <option value="full">Full Access</option>
                    <option value="write">Write &amp; Read</option>
                    <option value="read">Read Only</option>
                  </select>
                </div>
              </div>
              <div class="uk-margin">
                <button v-html="forms.submitButton" id="submitButton" class="uk-button uk-button-default button-action-modal">
                  <!--<span v-if="forms.edit">Simpan</span>
                  <span v-else>Tambah</span>-->
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- modal -->
    <div class="uk-grid-small uk-grid-margin" uk-grid>
      <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-width-1-1@s">
        <select v-model="selectedRows" class="uk-width-1-1 uk-select form-select" @change="getUsersList( pagination.path + '?page=' + pagination.current )">
          <option value="" :disabled="true">Tampilkan</option>
          <option value="10">10 baris</option>
          <option value="15">15 baris</option>
          <option value="20">20 baris</option>
        </select>
      </div>
      <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-width-1-1@s">
        <div class="uk-width-1-1 uk-inline">
          <a @click="getUsersList( pagination.path + '?page=' + pagination.current )" class="uk-form-icon" uk-icon="search"></a>
          <input @keyup.enter="getUsersList( pagination.path + '?page=' + pagination.current )" type="search" v-model="searchuser" placeholder="Cari user..." class="uk-width-1-1 uk-input form-search">
        </div>
      </div>
      <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-width-1-1@s">
        <button @click="btnAddOrUpdate()" class="uk-button uk-button-default button-custom-action">Tambah</button>
      </div>
    </div>
    <div v-if="users.total == 0">
      <div class="uk-alert-warning uk-margin-top" uk-alert>Tidak ada data</div>
    </div>
    <div class="uk-overflow-auto uk-margin-top">
      <table class="uk-table uk-table-small uk-table-divider uk-table-middle table-rows">
        <thead>
          <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Privileges</th>
            <th>Blocked</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users.results">
            <td>
              <a @click="btnAddOrUpdate(user)" class="uk-button uk-button-text" uk-tooltip title="Sunting"><span uk-icon="pencil"></span></a>
              <a @click="btnAddOrUpdate()" class="uk-button uk-button-text" uk-tooltip title="Hapus"><span uk-icon="trash"></span></a>
            </td>
            <td>{{ user.fullname }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.privileges_user }}</td>
            <td>No</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
<script>
export default {
  props: ['url'],
  data() {
    return {
      selectedRows: 10,
      searchuser: '',
      users: {
        total: 0,
        results: []
      },
      pagination: {
        current: 1,
        prev: '',
        next: '',
        last: '',
        path: this.url + '/users/datausers',
        perpage: 0
      },
      forms: {
        id: '',
        username: '',
        password: '',
        fullname: '',
        email: '',
        privilege: 'full',
        edit: false
      },
      errors: {}
    }
  },
  methods: {
    btnAddOrUpdate(user) {
      if( user === undefined || user === '' )
      {
        this.forms = {
          id: '',
          username: '',
          password: '',
          fullname: '',
          email: '',
          privilege: 'full',
          edit: false,
          submitButton: 'Tambah'
        };
        this.errors = {};
      }
      else
      {
        this.forms = {
          id: user.uid,
          username: user.username_panel,
          password: '',
          fullname: user.fullname,
          email: user.email,
          privilege: user.privileges_user,
          edit: true,
          submitButton: 'Simpan'
        };
      }

      UIkit.modal('#addOrUpdateUser').show();
    },
    getUsersList(pages)
    {
      let url = this.url + '/users/datausers?page=1&limit=' + this.selectedRows + '&searchuser=' + this.searchuser;
      if( pages !== undefined )
        url = pages + '&limit=' + this.selectedRows + '&searchuser=' + this.searchuser;

      axios({
        url: url,
        method: 'get'
      }).then(res => {
        let results = res.data;
        this.users = {
          total: results.results.total,
          results: results.results.data
        };

        this.pagination = {
          current: results.results.current_page,
          prev: results.results.prev_page_url,
          next: results.results.next_page_url,
          last: results.results.last_page_url,
          path: results.results.path,
          perpage: results.results.per_page
        };
      }).catch(err => {
        console.log(err.response);
      });
    },
    addOrUpdateUser() {
      this.errors = {};
      this.errors.iserror = false;
      if( this.forms.fullname === '' )
      {
        this.errors.fullname = 'Nama harap diisi.';
        this.errors.iserror = true;
      }
      if( this.forms.username === '' )
      {
        this.errors.username = 'Username harap diisi.';
        this.errors.iserror = true;
      }
      if( this.forms.email === '' )
      {
        this.errors.email = 'Email harap diisi.';
        this.errors.iserror = true;
      }
      if( this.forms.password === '' && this.forms.edit === false )
      {
        this.errors.password = 'Password harap diisi.';
        this.errors.iserror = true;
      }

      if( this.errors.iserror === true ) return false;
      var method, url = '';
      if( this.forms.edit === false )
      {
        url = this.url + '/users/add';
        method = 'post';
        if( this.countLength( this.forms.password ) < 8 )
        {
          this.errors.password = 'Password terlalu pendek. Minimal 8 karakter.';
          return false;
        }
      }
      else
      {
        url = this.url + '/users/update/' + this.forms.id;
        method = 'put';
        if( this.forms.password !== '' )
        {
          if( this.countLength( this.forms.password ) < 8 )
          {
            this.errors.password = 'Password terlalu pendek. Minimal 8 karakter.';
            return false;
          }
        }
      }

      this.forms.submitButton = '<span uk-spinner></span>';
      axios({
        url: url,
        method: method,
        headers: {'Content-Type': 'application/json' },
        params: {
          fullname: this.forms.fullname,
          username: this.forms.username,
          password: this.forms.password,
          email: this.forms.email,
          privilege: this.forms.privilege
        }
      }).then(res => {
        let result = res.data;
        swal({
          title: 'Berhasil',
          text: result.statusText,
          icon: 'success',
          timer: 3000
        });
        $('#submitButton').html('Tambah');
        this.getUsersList();
        setTimeout(function(){ UIkit.modal('#addOrUpdateUser').hide(); },3000);
        if( this.forms.edit === false )
        {
          this.forms = {
            id: '',
            username: '',
            password: '',
            fullname: '',
            email: '',
            privilege: 'full',
            edit: false,
            submitButton: 'Tambah'
          };
          this.errors = {};
        }
        else
        {
          this.forms.submitButton = 'Simpan';
        }
      }).catch(err => {
        let status = err.response.status;
        let message = err.response.data;
        if( status === 422 )
        {
          swal({
            title: 'Whoops',
            text: message.statusText,
            icon: 'warning',
            dangerMode: true
          });
        }
      });
    },
    countLength: function(str) {
      return str.length;
    }
  },
  computed: {

  },
  mounted() {
    this.getUsersList();
  }
}
</script>
