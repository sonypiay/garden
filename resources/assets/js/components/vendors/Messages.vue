<template lang="html">
  <div v-if="pages === 'messagelist'">
    <messagelist :url="url" />
  </div>
  <div v-else>
    <readmessage :url="url" />
  </div>
</template>

<script>
import messagelist from './MessagesList.vue';
import readmessage from './ReadMessage.vue';

export default {
  props: ['url', 'pages'],
  components: {
    messagelist
  }
}
</script>
