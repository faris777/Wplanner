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


    <template>


      <v-tabs fixed-tabs color="cyan" style="margin-top: 2%;">
        <v-tab @click="step1 = true; step2 =false; " style="border: 3px;">
          Services
        </v-tab>


      </v-tabs>
      <template v-if="step1" >
        <template>
          <v-layout row >

          </v-layout>
        </template>
        <v-data-table style="margin-top: 1%"
                      :headers="headers"
                      :items="desserts"
                      class="elevation-1"
        >

          <template v-slot:items="props">
            <td class="text-xs-left">{{ props.item.title }}</td>
            <td class="text-xs-left" style="width: 50%">{{ props.item.description }}</td>
            <td class="text-xs-left">{{ props.item.price }} ETB</td>
            <td class="text-xs-left" >{{ props.item.report }}</td>
            <td> <v-btn  color="info blue">Approve</v-btn> <v-btn  @click="deleteM(props.item.id)" color="info red">Decline</v-btn>  </td>

          </template>
        </v-data-table>
      </template>
      <template v-if="step2">
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
        title: "Image Upload",
        dialog: false,
        imageName: '',
        imageUrl: '',
        imageFile: '',
        step1: true,
        step2: false,
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
        headers: [
          { text: 'title', value: 'title'  },
          { text: 'description', value: 'description' },
          { text: 'price', value: 'price' },
          { text: 'report', value: 'report' },
          { text: 'action', value: 'action' },
        ],
        desserts:[],
      }
    },
    mounted:function(){
      this.getPosts();


    },
    methods: {
      isValidUser(){
        if( localStorage.getItem('user_id')!= null && localStorage.getItem('type') == 'Service provider'){

        }else {
          window.location.href ="/login"
        }
      },
      pickFile () {
        console.log("pick pcik")
        this.$refs.image.click ()
      },

      onFilePicked (e) {
        const files = e.target.files
        if(files[0] !== undefined) {
          this.imageName = files[0].name
          if(this.imageName.lastIndexOf('.') <= 0) {
            return
          }
          const fr = new FileReader ()
          fr.readAsDataURL(files[0])
          fr.addEventListener('load', () => {
            this.imageUrl = fr.result
            this.imageFile = files[0]
            let formData = new FormData();
            console.log(files)// this is an image file that can be sent to server...


            for( var i = 0; i < files.length; i++ ){
              let file = files[i];
              formData.append('photo', file);
            }


            this.axios.post( process.env.VUE_APP_SECRET+'file/image_list',
              formData,
              {
                headers: {
                  'Content-Type': 'multipart/form-data'
                }
              }
            ).then((response)=>{
              this.loadImage(response.data.url)
              console.log(response.data.url)
            })
              .catch(function(){
                console.log('FAILURE!!');
              });

          })
        } else {
          this.imageName = ''
          this.imageFile = ''
          this.imageUrl = ''
        }


      },
      loadImage(val){
        this.imageUrl = val;
      }
      ,

      getPosts(){
        console.log(process.env.VUE_APP_SECRET);
        this.axios.get(process.env.VUE_APP_SECRET+'feeds')

          .then((response)=> {

            this.loadArray(response.data);
          })

          .catch(function (error) {
            console.log(error)
          });
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
      },
      loadArray(value){
        this.desserts = value;
        console.log(this.desserts);
      },
      deleteM (value) {
        console.log(process.env.FOO);
        console.log('deleteee');
        this.snackbar = true;
        this.text = "deleted successfully"
        this.axios.delete(process.env.VUE_APP_SECRET+'feeds/'+ value )

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
