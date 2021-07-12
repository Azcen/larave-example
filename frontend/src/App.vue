<template lang="pug">
v-app
  .fill-height(v-if='!$auth.check()')
    auth-component
  div(v-if='$auth.check()')
    v-app-bar(app, color='primary', dark)
      .d-flex.align-center
        v-img.shrink.mr-2(
          alt='Vuetify Logo',
          contain,
          src='https://cdn.vuetifyjs.com/images/logos/vuetify-logo-dark.png',
          transition='scale-transition',
          width='40'
        )
        v-img.shrink.mt-1.hidden-sm-and-down(
          alt='Vuetify Name',
          contain,
          min-width='100',
          src='https://cdn.vuetifyjs.com/images/logos/vuetify-name-dark.png',
          width='100'
        )
      v-spacer
    v-main
      router-view
      <!-- set progressbar -->
    vue-progress-bar
</template>

<script>
const AuthComponent = () => import('@/components/AuthComponent.vue')

export default {
  name: 'App',
  components: {
    AuthComponent
  },
  data: () => ({}),
  created() {
    this.$router.beforeEach((to, from, next) => {
      if (!this.$auth.check()) {
        console.log('Login')
        next({ name: 'Login' })
      } else {
        console.log('Current')
        next()
      }
    })
  }
}
</script>
