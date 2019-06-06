<style>
  .v-messages__message {
    color: red;
  }
  .v-menu__content{
    position: unset;
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

    <v-layout   style="margin-top: 3%; " justify-center >
      <v-card style="width: 700px;margin: 20px; padding: 2%; ">
        <form >
          <v-text-field
            v-model="name"
            :error-messages="nameErrors"
            :counter="10"
            label="Name"
            required
            @input="$v.name.$touch()"
            @blur="$v.name.$touch()"
          ></v-text-field>
          <v-text-field
            v-model="email"
            :error-messages="emailErrors"
            label="E-mail"
            required
            @input="$v.email.$touch()"
            @blur="$v.email.$touch()"
          ></v-text-field>
          <v-text-field
            v-model="phone"
            :counter="10"
            label="phone"
            required
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
          <v-select
            v-model="select"
            :items="items"
            :error-messages="selectErrors"
            label="type"
            required
            @change="$v.select.$touch()"
            @blur="$v.select.$touch()"
          ></v-select>
          <v-checkbox
            v-model="checkbox"
            :error-messages="checkboxErrors"
            label="Do you agree?"
            required
            @change="$v.checkbox.$touch()"
            @blur="$v.checkbox.$touch()"
          ></v-checkbox>

          <v-btn @click="submit">submit</v-btn>
          <v-btn @click="clear">clear</v-btn>
        </form>
      </v-card>
    </v-layout>



  </div>
</template>


<script>
  import {validationMixin} from 'vuelidate'
  import {required, maxLength, email} from 'vuelidate/lib/validators'

  export default {
    mixins: [validationMixin],

    validations: {
      name: {required, maxLength: maxLength(10)},
      email: {required, email},
      select: {required},
      checkbox: {
        checked(val) {
          return val
        }
      }
    },

    data: () => ({
      el :0,
      error :0,
      phone: '',
      password: '',
      rules: {
        required: value => !!value || 'Required.',
        min: v => v.length >= 6 || 'Min 8 characters'
      },
      name: '',
      email: '',
      select: null,
      items: [
        'Merchant',
        'Service provider'
      ],
      checkbox: false
    }),

    computed: {

      checkboxErrors() {
        const errors = []
        if (!this.$v.checkbox.$dirty) return errors
        !this.$v.checkbox.checked && errors.push('You must agree to continue!')
        return errors
      },
      selectErrors() {
        const errors = []
        if (!this.$v.select.$dirty) return errors
        !this.$v.select.required && errors.push('Item is required')
        return errors
      },
      nameErrors() {
        const errors = []
        if (!this.$v.name.$dirty) return errors
        !this.$v.name.maxLength && errors.push('Name must be at most 10 characters long')
        !this.$v.name.required && errors.push('Name is required.')
        return errors
      },
      emailErrors() {
        const errors = []
        if (!this.$v.email.$dirty) return errors
        !this.$v.email.email && errors.push('Must be valid e-mail')
        !this.$v.email.required && errors.push('E-mail is required')
        return errors
      }
    },

    methods: {
      submit() {
        //this.$v.$touch()
        if(this.$v.password != '' && this.$v.email != '' ){


          let currentObj = this;
          console.log({

            email: this.email,
            password: this.password,
            type: this.select,
            name: this.name,
            phone: this.phone


          } );
          this.axios.post(process.env.VUE_APP_SECRET+'register', {

            email: this.email,
            password: this.password,
            type: this.select,
            name: this.name,
            phone : this.phone

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
      clear() {
        this.$v.$reset()
        this.name = ''
        this.email = ''
        this.select = null
        this.password = ''
        this.checkbox = false
      },
      isLogged(){
        console.log('user ----'+localStorage.getItem('user_id'));
        return localStorage.getItem('user_id')!= null;
      },
      logOut(){
        localStorage.clear();
        window.location.href ="/login";
      }
    }
  }
</script>
