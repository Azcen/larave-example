<template lang="pug">
v-container(fill-height)
  v-row(no-gutter)
    v-col(cols='4', offset-md='4')
      v-card
        v-card-title
          span.text-h5 Login
        v-card-text
          v-container
            v-row
              v-col(cols='12')
                v-text-field(
                  label='Email*',
                  :error-messages='emailErrors',
                  required,
                  v-model='form.email',
                  @input='$v.form.email.$touch()',
                  @blur='$v.form.email.$touch()'
                )
              v-col(cols='12')
                v-text-field(
                  label='Password*',
                  :error-messages='passwordErrors',
                  type='password',
                  required,
                  v-model='form.password',
                  @input='$v.form.password.$touch()',
                  @blur='$v.form.password.$touch()'
                )
          small *indicates required field
        v-card-actions
          v-spacer
          v-btn(color='blue darken-1', text) Register
          v-btn(color='blue darken-1', text, @click='doLogin') Login
</template>
<script>
import { validationMixin } from 'vuelidate'
import { required, email } from 'vuelidate/lib/validators'
import { mapActions } from 'vuex'

export default {
  name: 'Login',
  mixins: [validationMixin],
  data() {
    return {
      form: {
        email: '',
        password: ''
      },
      authError: false
    }
  },
  validations: {
    form: {
      email: {
        required,
        email
      },
      password: {
        required
      }
    }
  },
  computed: {
    emailErrors() {
      const errors = []
      if (!this.$v.form.email.$dirty) return errors
      !this.$v.form.email.email && errors.push('Must be valid e-mail')
      !this.$v.form.email.required && errors.push('E-mail is required')
      return errors
    },
    passwordErrors() {
      const errors = []
      if (!this.$v.form.password.$dirty) return errors
      !this.$v.form.password.required && errors.push('Password is required')
      return errors
    }
  },
  methods: {
    ...mapActions({
      loadData: 'loadData'
    }),
    async doLogin() {
      if (this.$v.$invalid) {
        this.$v.$touch()
      } else {
        await this.$auth
          .login({
            data: this.form,
            success(response) {
              const { status } = response
              console.log('res:' + response)
              console.log('status:' + status)
              if (status === 401) {
                this.authError = true
              } else {
                this.loadData()
                console.log('login')
              }
            },
            redirect: { name: 'Home' }
          })
          .catch((e) => {
            console.log('error:' + e)
          })
      }
    }
  }
}
</script>
<style lang="scss">
.v-card > .v-card__text {
  padding: 0 24px 20px;
}
.v-card > .v-card__title {
  font-size: 1.25rem;
  font-weight: 500;
  letter-spacing: 0.0125em;
  padding: 16px 24px 10px;
}
</style>
