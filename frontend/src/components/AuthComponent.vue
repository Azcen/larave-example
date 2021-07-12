<template lang="pug">
v-container(fill-height)
  v-row(no-gutter)
    v-col(cols='12') 
      router-view
</template>
<script>
export default {
  name: 'AuthComponent'
}
</script>
