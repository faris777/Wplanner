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

          <v-tab @click="step1 = false; step2 =true; " >
            Orders
          </v-tab>
        </v-tabs>
      <v-dialog v-model="dialog" persistent max-width="600px">
        <template v-slot:activator="{ on }">
          <v-btn style="margin-top: 1%" color="info blue"  dark v-on="on">Add post</v-btn>
        </template>
        <v-card>
          <v-card-title>
            <span class="headline">wedding post</span>
          </v-card-title>
          <v-card-text>
            <v-container grid-list-md>
              <v-layout wrap>
                <template>
                  <form style="width: 100%;">
                    <v-text-field
                      v-model="title"
                      :error-messages="nameErrors"
                      :counter="10"
                      label="title"
                      required
                    ></v-text-field>

                    <v-textarea
                      v-model="description"
                      label="description"
                      required
                    ></v-textarea>

                    <v-text-field
                      v-model="price"
                      label="price"
                      :type = "number"
                      required
                    ></v-text-field>




                    <v-flex xs12 class="text-xs-center text-sm-center text-md-center text-lg-center">
                      <img :src="imageUrl" height="150" v-if="imageUrl"/>
                      <v-text-field label="Select Image" @click='pickFile' v-model='imageName' prepend-icon='attach_file'></v-text-field>
                      <input
                        multiple
                        type="file"
                        style="display: none"
                        ref="image"
                        accept="image/*"
                        @change="onFilePicked"
                      >
                    </v-flex>


  </form>
                </template>

              </v-layout>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" flat  @click="dialog = false">Close</v-btn>
            <v-btn color="blue darken-1" flat @click="submit" >Save</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
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


                    <td>
                      <v-dialog v-model="dialog2" persistent max-width="600px">
                      <template v-slot:activator="{ on }">
                        <v-btn @click="checkVal(props.item.title ,  props.item.description , props.item.price )"  color="info blue"  dark v-on="on">Edit post</v-btn>
                      </template>
                      <v-card>
                        <v-card-title>
                          <span class="headline">Edit post</span>
                        </v-card-title>
                        <v-card-text>
                          <v-container grid-list-md>
                            <v-layout wrap>
                              <template>
                                <form style="width: 100%;">
                                  <v-text-field
                                    v-model="title2"
                                    :error-messages="nameErrors"
                                    :counter="10"
                                    label="title"
                                    required
                                  ></v-text-field>

                                  <v-textarea
                                    v-model="description2"
                                    label="description"
                                    required
                                  ></v-textarea>

                                  <v-text-field
                                    v-model="price2"
                                    label="price"
                                    :type = "number"
                                    required
                                  ></v-text-field>




                                  <v-flex xs12 class="text-xs-center text-sm-center text-md-center text-lg-center">
                                    <img :src="imageUrl" height="150" v-if="imageUrl"/>
                                    <v-text-field label="Select Image" @click='pickFile' v-model='imageName' prepend-icon='attach_file'></v-text-field>
                                    <input
                                      multiple
                                      type="file"
                                      style="display: none"
                                      ref="image"
                                      accept="image/*"
                                      @change="onFilePicked"
                                    >
                                  </v-flex>


                                </form>
                              </template>

                            </v-layout>
                          </v-container>
                        </v-card-text>
                        <v-card-actions>
                          <v-spacer></v-spacer>
                          <v-btn color="blue darken-1" flat  @click="dialog2 = false">Close</v-btn>
                          <v-btn color="blue darken-1" flat @click="submit2 (props.item.id)" >Save</v-btn>
                        </v-card-actions>
                      </v-card>
                    </v-dialog>


                      <v-btn  @click="deleteM(props.item.id)" color="info red">Delete</v-btn>  </td>

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
        title2: "",
        dialog: false,
        dialog2: false,
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
        description2: '',
        price: '',
        price2: '',
        headers: [
          { text: 'title', value: 'title'  },
          { text: 'description', value: 'description' },
          { text: 'price', value: 'price' },,
          { text: 'action', value: 'action' },
        ],
        headers2: [

          { text: 'title', value: 'title'  },
          { text: 'phone', value: 'phone' },
          { text: 'price', value: 'price' },,
          { text: 'action', value: 'action' },
        ],
        desserts:[],
        orders:[],
      }
    },
    mounted:function(){
      this.getPosts();
      this.getOrders();
      this.isValidUser();


    },
    methods: {
        checkVal(titlev , descriptionv , pricev){
          this.title2 = titlev;
          this.description2 = descriptionv;
          this.price2 = pricev;
        },

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
        this.axios.get(process.env.VUE_APP_SECRET+'provider/feeds'+ '?user='+localStorage.getItem('user_id'))

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
      submit () {
        console.log(process.env.FOO);
        this.dialog =false;

          let currentObj = this;
          console.log( {

            title: this.title,
            description: this.description,
            price: this.price

          });
          this.axios.post(process.env.VUE_APP_SECRET + 'feeds', {

            title: this.title,
            description: this.description,
            price: this.price,
            user_id: localStorage.getItem("user_id"),
            image: this.imageUrl
          })

            .then((response) =>{

              currentObj.output = response.data;
              console.log(currentObj.output);
              this.mounted;
              this.getPosts();
            })

            .catch(function (error) {

              currentObj.output = error;
              console.log(error)
            });

      },
      submit2 (id) {
        console.log(process.env.FOO);
        this.dialog2 =false;

        let currentObj = this;
        console.log( {

          title: this.title2,
          description: this.description2,
          price: this.price2

        });
        this.axios.put(process.env.VUE_APP_SECRET + 'feeds/'+id , {

          title: this.title2,
          description: this.description2,
          price: this.price2,
          user_id: localStorage.getItem("user_id"),
          image: this.imageUrl
        })

          .then((response) =>{

            currentObj.output = response.data;
            console.log(currentObj.output);
            this.mounted;
            this.getPosts();
          })

          .catch(function (error) {

            currentObj.output = error;
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
