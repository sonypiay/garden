<template lang="html">
  <div v-if="pages === 'messagelist'">
    <messagelist :url="url" />
  </div>
</template>

<script>
import messagelist from './MessagesList.vue';

export default {
  props: ['url', 'pages'],
  components: {
    messagelist
  }
}
</script>
