<template>
  <div id="app">
  <router-view/>
  </div>
</template>
<style lang="stylus">
@import 'assets/style/main.styl'

</style>

<script>
  import Home from '@/views/Home'
  export default {
  name: 'app'
}
</script>
