<template lang="html">
  <div class="uk-margin-large-top">
    <div id="modal" uk-modal>
      <div class="uk-modal-dialog view_withdraw">
        <a class="uk-modal-close-default" uk-close></a>
        <div class="uk-modal-header">
          <div class="view_withdraw_header">Ticket {{ withdraw.ticket_id }}</div>
        </div>
        <div class="uk-modal-body view_withdraw_body" uk-overflow-auto>
          <div class="uk-grid-small" uk-grid>
            <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-1@s">
              <div class="view_withdraw_title">Vendor</div>
              <div class="view_withdraw_value">{{ withdraw.vendor.name }}</div>
            </div>
            <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-1@s">
              <div class="view_withdraw_title">Dana saat ini</div>
              <div class="view_withdraw_value">Rp. {{ formatCurrency( withdraw.balances.current ) }}</div>
            </div>
            <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-1@s">
              <div class="view_withdraw_title">Nominal Penarikan</div>
              <div class="view_withdraw_value">Rp. {{ formatCurrency( withdraw.balances.amount ) }}</div>
            </div>
            <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-1@s">
              <div class="view_withdraw_title">Tanggal Pengajuan</div>
              <div class="view_withdraw_value">{{ formatDate( withdraw.timestamp.created_at, 'DD MMMM YYYY, HH:mm' ) }}</div>
            </div>
          </div>
          <hr>
          <div class="uk-grid-small" uk-grid>
            <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-width-1-1@s">
              <div class="view_withdraw_title">Nama Pemilik Rekening</div>
              <div class="view_withdraw_value">{{ withdraw.bank.ownername }}</div>
            </div>
            <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-width-1-1@s">
              <div class="view_withdraw_title">Nomor Rekening</div>
              <div class="view_withdraw_value">{{ withdraw.bank.account_number }}</div>
            </div>
            <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-width-1-1@s">
              <div class="view_withdraw_title">Dana</div>
              <div class="view_withdraw_value">{{ withdraw.bank.name }}</div>
            </div>
          </div>
        </div>
        <div class="uk-modal-footer">
          <button v-if="withdraw.status_withdraw === 'pending'" class="uk-button uk-button-primary view_withdraw_approved" @click="onApprovalWithdraw('approve')">Approve</button>
          <button v-else class="uk-button uk-button-primary view_withdraw_approved">Approve</button>

          <button v-if="withdraw.status_withdraw === 'pending'" class="uk-button uk-button-danger view_withdraw_rejected" @click="onApprovalWithdraw('reject')">Reject</button>
          <button v-else class="uk-button uk-button-danger view_withdraw_rejected">Reject</button>
        </div>
      </div>
    </div>

    <h3>Daftar Transaksi</h3>
    <div class="uk-card uk-card-body uk-card-default">
      <div class="uk-grid-small" uk-grid>
        <div class="uk-width-1-4@xl uk-width-1-4@l uk-width-1-3@m uk-width-1-1@s">
          <div class="uk-inline">
            <span class="uk-form-icon" uk-icon="search"></span>
            <input @keyup.enter="withdrawList( pagination.path + '?page=' + pagination.current )" type="text" class="uk-input form-search uk-width-1-1" v-model="keywords" placeholder="Cari...">
          </div>
        </div>
        <div class="uk-width-1-4@xl uk-width-1-4@l uk-width-1-3@m uk-width-1-2@s">
          <select class="uk-select form-select" v-model="selectedRows" @change="withdrawList( pagination.path + '?page=' + pagination.current )">
            <option value="10">10 ditampilkan</option>
            <option value="20">20 ditampilkan</option>
            <option value="30">30 ditampilkan</option>
            <option value="50">50 ditampilkan</option>
          </select>
        </div>
        <div class="uk-width-1-4@xl uk-width-1-4@l uk-width-1-3@m uk-width-1-2@s">
          <select class="uk-select form-select" v-model="statusWithdraw" @change="withdrawList( pagination.path + '?page=' + pagination.current )">
            <option value="all">-- Semua Status --</option>
            <option value="pending">Pending</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
          </select>
        </div>
      </div>

      <div class="uk-margin-top">
        <div class="uk-label">{{ withdraws.total }} Ticket</div>
        <div class="uk-overflow-auto uk-margin-top">
          <table class="uk-table uk-table-small uk-table-divider uk-table-middle uk-table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>No. Ticket</th>
                <th>Vendor</th>
                <th>Status</th>
                <th>Tanggal Pesan</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="wd in withdraws.results">
                <td>
                  <button @click="viewDetailWithdraw(wd)" class="uk-button uk-button-text" uk-icon="forward" uk-tooltip="title: Lihat Rincian; pos: right"></button>
                </td>
                <td class="uk-text-truncate" :title="wd.ticket_id">{{ wd.ticket_id }}</td>
                <td>{{ wd.vendor_name }}</td>
                <td>
                  <span v-if="wd.status_withdraw === 'pending'" class="uk-label uk-label-warning">Pending</span>
                  <span v-else-if="wd.status_withdraw === 'approved'" class="uk-label uk-label-success">Approved</span>
                  <span v-else class="uk-label uk-label-danger">Rejected</span>
                </td>
                <td>{{ formatDate( wd.created_at, 'MMM DD, YYYY HH:mm' ) }}</td>
              </tr>
            </tbody>
          </table>
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
      withdraws: {
        total: 0,
        results: []
      },
      pagination: {
        current: 1,
        next: '',
        prev: '',
        last: 1,
        path: this.url + '/withdraw/list'
      },
      withdraw: {
        ticket_id: 0,
        vendor: {
          name: '',
          id: ''
        },
        balances: {
          current: 0,
          amount: 0
        },
        status_withdraw: '',
        timestamp: {
          created_at: new Date(),
          updated_at: new Date()
        },
        bank: {
          name: '',
          account_number: '',
          ownername: ''
        }
      },
      keywords: '',
      statusWithdraw: 'all',
      selectedRows: 10
    }
  },
  methods: {
    formatDate(str, format) {
      var res = moment(str).locale('id').format(format);
      return res;
    },
    formatCurrency(price) {
      price = Number( price );
      var numberformat = new Intl.NumberFormat('en-ID').format( price );
      return numberformat;
    },
    withdrawList(pages) {
      var param = '&keywords=' + this.keywords + '&status=' + this.statusWithdraw + '&rows=' + this.selectedRows;
      if( pages === undefined || pages === null )
        pages = this.url + '/withdraw/list?page=' + this.pagination.current + param;
      else
        pages = pages + param;

      axios({
        method: 'get',
        url: pages
      }).then( res => {
        let result = res.data;
        this.withdraws.total = result.result.total;
        this.withdraws.results = result.result.data;
        console.log( this.withdraws );
      }).catch( err => {
        console.log( err.response.statusText );
      });
    },
    viewDetailWithdraw(withdraw) {
      this.withdraw = {
        ticket_id: withdraw.ticket_id,
        vendor: {
          name: withdraw.vendor_name,
          id: withdraw.vendor_id
        },
        balances: {
          current: withdraw.credits_balance,
          amount: withdraw.nominal
        },
        status_withdraw: withdraw.status_withdraw,
        timestamp: {
          created_at: withdraw.created_at,
          updated_at: withdraw.updated_at
        },
        bank: {
          name: withdraw.bank_name,
          account_number: withdraw.account_number,
          ownername: withdraw.ownername
        }
      };
      UIkit.modal('#modal').show();
      console.log( this.withdraw );
    },
    onApprovalWithdraw(approval)
    {
      var notif_message;
      if( approval === 'approve' )
        notif_message = 'Apakah anda ingin menyetujui pengajuan ini?';
      else
        notif_message = 'Apakah anda ingin menolak pengajuan ini?';

      swal({
        title: 'Konfirmasi',
        text: notif_message,
        icon: 'warning',
        buttons: {
          cancel: 'Batal',
          confirm: {
            text: 'Konfirmasi',
            value: true
          }
        }
      }).then( value => {
        if( value )
        {
          axios({
            method: 'put',
            url: this.url + '/withdraw/approval/' + this.withdraw.ticket_id,
            params: {
              approval: approval
            }
          }).then( res => {
            swal({
              title: 'Berhasil',
              text: res.data.statusText,
              icon: 'success',
              timer: 3000
            });
            this.withdrawList();
            setTimeout(function(){
              UIkit.modal('#modal').hide();
            }, 2000);
          }).catch( err => {
            swal({
              title: 'Whoops',
              text: err.response.status + ' ' + err.response.statusText,
              icon: 'danger',
              dangerMode: true,
              timer: 3000
            });
          });
        }
      });
    }
  },
  mounted() {
    this.withdrawList();
  }
}
</script>
