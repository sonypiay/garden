<template lang="html">
  <div class="uk-margin-top">
    <h3 class="message_heading">Pesan</h3>
    <div class="uk-card uk-card-body uk-card-default">
      <div class="uk-overflow-auto uk-height-large">
        <table class="uk-table uk-table-middle uk-table-hover uk-table-divider uk-table-small">
          <thead>
            <tr>
              <th>#</th>
              <th>Dari</th>
              <th>Pesan Terakhir</th>
              <th>Waktu</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="message in messages.results">
              <td>
                <a uk-tootlip="Lihat" class="uk-button uk-button-text" :href="url + '/vendor/message/readmessage/' + message.results.msg_id"><span uk-icon="forward"></span></a>
              </td>
              <td>{{ message.results.customer_name }}</td>
              <td class="uk-text-truncate">{{ message.lastmessage }}</td>
              <td>{{ formatDate( message.updated_at, 'LLL' ) }}</td>
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
      messages: {
        total: 0,
        results: []
      },
      selectedRows: ''
    }
  },
  methods: {
    formatDate(str, format)
    {
      var res = moment(str).locale('id').format(format);
      return res;
    },
    getMessagesList(pages)
    {
      axios({
        method: 'get',
        url: this.url + '/vendor/message/message_list'
      }).then( res => {
        let result = res.data;
        this.messages = {
          total: result.total,
          results: result.results
        };
        console.log(this.messages.results);
      }).catch( err => {
        this.getErrorMessage = err.response.status;
      })
    }
  },
  mounted() {
    this.getMessagesList();
  }
}
</script>
