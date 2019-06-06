<style>
  .v-messages__message{
    color: red;
  }
</style>
<template>
  <div>
    <v-toolbar dark color="primary">
      <v-toolbar-side-icon></v-toolbar-side-icon>

      <v-toolbar-title class="black--text" to="/">WDPlanner</v-toolbar-title>

      <v-spacer></v-spacer>

      <v-btn class="black--text" icon>
        <v-icon>search</v-icon>
      </v-btn>

      <v-btn class="black--text" icon>
        <v-icon>apps</v-icon>
      </v-btn>

      <v-btn class="black--text" icon>
        <v-icon>refresh</v-icon>
      </v-btn>

      <div v-if="isLogged()">
        <v-btn class="white black--text" @click="logOut" >
          logout
        </v-btn>
      </div>

      <div v-if="!isLogged()">
        <v-btn class="white black--text" to="/login" >
          login
        </v-btn>
        <v-btn class="white black--text" to="/register" >
          register
        </v-btn>
      </div>

    </v-toolbar>

  <v-layout style="margin-top: 3%" justify-center>
    <v-card>
  <form style="width: 700px;margin: 20px;">

    <v-text-field
      v-model="email"
      :error-messages="emailErrors"
      label="E-mail"
      required
      @input="$v.email.$touch()"
      @blur="$v.email.$touch()"
    ></v-text-field>

    <v-text-field
      v-model="password"
      :append-icon="show1 ? 'visibility' : 'visibility_off'"
      :rules="[rules.required, rules.min]"
      :type="show1 ? 'text' : 'password'"
      name="input-10-1"
      label="password"
      counter
      @click:append="show1 = !show1"
    ></v-text-field>

    <v-checkbox
      v-model="checkbox"
      :error-messages="checkboxErrors"
      label="Do you agree?"
      required

    ></v-checkbox>

    <v-btn @click="submit">submit</v-btn>
    <v-btn @click="clear">clear</v-btn>
  </form>
    </v-card>
  </v-layout>
  </div>
</template>


<script>
  import { validationMixin } from 'vuelidate'
  import { required, email } from 'vuelidate/lib/validators'


  export default {
    mixins: [validationMixin],

    validations: {
      password: { required },
      email: { required, email },
      checkbox: {
        checked (val) {
          return val
        }
      }
    },

    data: () => ({

      show1: false,
      error :0,
      password: '',
      rules: {
        required: value => !!value || 'Required.',
        min: v => v.length >= 6 || 'Min 8 characters'
      },
      name: '',
      email: '',
      select: null,
      checkbox: false
    }),

    computed: {
      checkboxErrors () {
        const errors = []
        if (!this.$v.checkbox.$dirty) return errors
        !this.$v.checkbox.checked && errors.push('You must agree to continue!')
        this.error = this.error + 1
        return errors
      },

      emailErrors () {
        const errors = []
        if (!this.$v.email.$dirty) return errors
        !this.$v.email.email && errors.push('Must be valid e-mail')
        !this.$v.email.required && errors.push('E-mail is required')
        this.error = this.error + 1
        return errors
      }
    },

    methods: {

    isLogged(){
      console.log('user ----'+localStorage.getItem('user_id'));
      return localStorage.getItem('user_id')!= null;
    },
    logOut(){
      localStorage.clear();
      window.location.href ="/login";
    },
      submit () {
        if(this.$v.password != '' && this.$v.email != '' ){


          let currentObj = this;
          console.log("log " +  this.email + this.password )
          this.axios.post(process.env.VUE_APP_SECRET+'login', {

            email: this.email,

            password: this.password

          })

            .then(function (response) {

              currentObj.output = response.data;
              console.log(currentObj.output)
              localStorage.setItem("user_id" ,currentObj.output.id )
              localStorage.setItem("name" ,currentObj.output.name )
              localStorage.setItem("email" ,currentObj.output.email )
              localStorage.setItem("type" ,currentObj.output.type )
              localStorage.setItem("phone" ,currentObj.output.phone )

              if(currentObj.output.type == 'admin'){
                window.location.href ="/admin"
              }else if(currentObj.output.type == 'Service provider'){
                window.location.href ="/provider"
              }else if(currentObj.output.type == 'Merchant'){
                window.location.href ="merchant"
              }
            })

            .catch(function (error) {

              currentObj.output = error;
              console.log(error)
            });
        }
      },
      clear () {
        this.$v.$reset()
        this.password = ''
        this.email = ''
        this.checkbox = false
      }
    }
  }
</script>
