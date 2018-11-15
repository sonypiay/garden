<template lang="html" v-if="page === 'editprofile'">
<editprofile :url="url" :customers="customers"></editprofile>
</template>

<script>
import editprofile from './EditProfile.vue';
export default {
  props: ['url', 'page', 'customers'],
  data() {
    return {}
  },
  components: {
    editprofile
  }
}
</script>
