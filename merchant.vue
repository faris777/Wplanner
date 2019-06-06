<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
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
        <v-icon>avatar</v-icon>
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


    <template>



      <template  >
        <template>
          <v-layout row >

          </v-layout>
        </template>
        <v-data-table style="margin-top: 2%"
                      :headers="headers2"
                      :items="orders"
                      class="elevation-1"
        >

          <template v-slot:items="props">
            <td class="text-xs-left">{{ props.item.user_id }}</td>
            <td class="text-xs-left">{{ props.item.phone }}</td>
            <td class="text-xs-left" style="width: 35%">{{ props.item.service_name }}</td>
            <td class="text-xs-left">{{ props.item.start_date }}</td>
            <td class="text-xs-left">{{ props.item.end_date }}</td>
            <td> <v-btn  @click="deleteM(props.item.description)" color="info blue">FINALIZE</v-btn>  </td>

          </template>
        </v-data-table>
      </template>
    </template>





    <v-snackbar
      v-model="snackbar"
      :bottom="y === 'bottom'"
      :left="x === 'left'"
      :multi-line="mode === 'multi-line'"
      :right="x === 'right'"
      :timeout="timeout"
      :top="y === 'top'"
      :vertical="mode === 'vertical'"
    >
      {{ text }}
      <v-btn
        color="pink"
        flat
        @click="snackbar = false"
      >
        Close
      </v-btn>
    </v-snackbar>
  </div>
</template>


<script>
  import { validationMixin } from 'vuelidate'
  import { required, maxLength, email } from 'vuelidate/lib/validators'

  export default {
    mixins: [validationMixin],

    validations: {
      name: { required, maxLength: maxLength(10) },
      email: { required, email },
      select: { required },
      checkbox: {
        checked (val) {
          return val
        }
      }
    },

    data () {
      return {

        snackbar: false,
        y: 'top',
        x: null,
        mode: '',
        timeout: 6000,
        text: 'Hello, I\'m a snackbar',
        dialog: false,
        title:'',
        description: '',
        price: '',

        headers2: [

          { text: 'user_id', value: 'user_id'  },
          { text: 'phone', value: 'phone'  },
          { text: 'service_name', value: 'service_name' },
          { text: 'start_date', value: 'start_date' },
          { text: 'end_date', value: 'end_date' },

          { text: 'action', value: 'action' },
        ],
        orders:[],
      }
    },
    mounted:function(){

      this.getOrders();

    },
    methods: {
      isValidUser(){
        if( localStorage.getItem('user_id')!= null && localStorage.getItem('type') == 'Merchant'){

        }else {
          window.location.href ="/login"
        }
      },
      getOrders(){
        this.axios.get(process.env.VUE_APP_SECRET +'orders')

          .then((response)=> {

            this.loadArrayOrders(response.data);
          })

          .catch(function (error) {
            console.log(error)
          });
      },
      loadArrayOrders(value){
        this.orders = value;
        console.log(this.orders[0].title);
      },
      loadArray(value){
        this.desserts = value;
        console.log(this.desserts);
      },
      deleteM (value) {
        console.log('deleteee');
        this.snackbar = true;
        this.text = "deleted successfully"
        this.axios.delete(process.env.VUE_APP_SECRET +'feeds/'+ value )

          .then((response) =>{
            this.snackbar = true;
            console.log(response);

          })

          .catch(function (error) {

            console.log(error)
          });
      },
      clear () {
        this.$v.$reset()
        this.password = ''
        this.email = ''
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
