<style xmlns:v-slot="http://www.w3.org/1999/XSL/Transform" xmlns:v-slot="props" >
  .v-toolbar  > div{
    background-color: #fff9f5;
  }
  .v-badge__badge{}
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

      <v-btn @click="toAdmin" class="black--text" icon>
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

    <v-carousel>
    <v-carousel-item
      v-for="(item,i) in items"
      :key="i"
      :src="item"
    ></v-carousel-item>
  </v-carousel>
    <v-container style="position: relative; bottom: 125px;">

      <!--dialogue-->
      <v-dialog v-model="bigModal" persistent max-width="600px">
        <template v-slot:activator="{ on }">
          <v-btn style = "background-color: #e57373; " @click="checkLogging" v-on="on" class="white--text"> <b>Set up and pay</b></v-btn>

        </template>
        <v-card>
          <v-card-title>
            <span class="headline">Order Item</span>
          </v-card-title>
          <v-card-text>
            <v-container grid-list-md>
              <v-layout wrap>
                <template>
                  <form style="width: 100%;">

                    <template>


                      <template>
                        <v-layout row>
                          <v-flex
                            grow
                            pa-1
                          >
                            <div class="text-xs-center">
                              <v-dialog
                                v-model="dialog1"
                                width="500"
                              >
                                <template v-slot:activator="{ on }">
                                  <v-flex xs12 sm6 md12>
                                    <v-text-field
                                      label="Event"
                                      v-model="stDatePicker"
                                      placeholder="End date"
                                      v-on="on"
                                    ></v-text-field>
                                  </v-flex>

                                </template>

                                <v-card>
                                  <v-card-title
                                    class="headline grey lighten-2"
                                    primary-title
                                  >
                                    End date
                                  </v-card-title>

                                  <v-card-text>
                                    <div>
                                      <v-date-picker v-model="stDatePicker" :landscape="landscape" ></v-date-picker>
                                    </div>
                                  </v-card-text>

                                  <v-divider></v-divider>

                                  <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn
                                      color="primary"
                                      flat
                                      @click="dialog = false"
                                    >
                                      Done
                                    </v-btn>
                                  </v-card-actions>
                                </v-card>
                              </v-dialog>
                            </div>
                          </v-flex>

                            <v-flex
                              grow
                              pa-1
                            >
                        <div class="text-xs-center">
                          <v-dialog
                            v-model="dialog2"
                            width="500"
                          >
                            <template v-slot:activator="{ on }">
                              <v-flex xs12 sm6 md12>
                                <v-text-field
                                  label="Event"
                                  v-model="endDatePicker"
                                  placeholder="End date"
                                  v-on="on"
                                ></v-text-field>
                              </v-flex>

                            </template>

                            <v-card>
                              <v-card-title
                                class="headline grey lighten-2"
                                primary-title
                              >
                                End date
                              </v-card-title>

                              <v-card-text>
                                <div>
                                  <v-date-picker v-model="endDatePicker" :landscape="landscape" ></v-date-picker>
                                </div>
                              </v-card-text>

                              <v-divider></v-divider>

                              <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn
                                  color="primary"
                                  flat
                                  @click="dialog = false"
                                >
                                  Done
                                </v-btn>
                              </v-card-actions>
                            </v-card>
                          </v-dialog>
                        </div>
                            </v-flex>
                          </v-layout>
                      </template>






                    </template>





                  </form>
                </template>

              </v-layout>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" flat  @click="bigModal = false">Close</v-btn>
            <v-btn color="blue darken-1" flat @click="submit" >Save</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>




      <v-btn> report </v-btn>

      <v-badge right >
        <template v-slot:badge>
          <span style="position: relative; right: 20px; top:15px; padding: 3px; padding-top: 0px; padding-bottom: 0px; background-color: white; color: black; border-radius: 50px;" >6</span>
        </template>
        <v-btn flat icon color="pink">
          <v-icon>favorite</v-icon>
        </v-btn>
      </v-badge>



    </v-container>
  <v-container style="position:  relative ; bottom: 40px;">
   <h2 black--text >{{post.title}}</h2>
    <p style="margin-top: 1%">{{post.description}}</p>
  </v-container>

<div style="height: 100px;"></div>
    <template>
      <v-footer
        dark
        height="auto"
        style="background-color: #fff9f5 !important;"
      >
        <v-card
          flat
          tile
          style="background-color: #fff9f5 !important;"
          class="indigo lighten-1 black--text text-xs-center"
        >
          <v-card-text>
            <v-btn
              v-for="icon in icons"
              :key="icon"
              class="mx-3 black--text"
              icon
            >
              <v-icon size="24px">{{ icon }}</v-icon>
            </v-btn>
          </v-card-text>

          <v-card-text class="black--text pt-0">
            Phasellus feugiat arcu sapien, et iaculis ipsum elementum sit amet. Mauris cursus commodo interdum. Praesent ut risus eget metus luctus accumsan id ultrices nunc. Sed at orci sed massa consectetur dignissim a sit amet dui. Duis commodo vitae velit et faucibus. Morbi vehicula lacinia malesuada. Nulla placerat augue vel ipsum ultrices, cursus iaculis dui sollicitudin. Vestibulum eu ipsum vel diam elementum tempor vel ut orci. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
          </v-card-text>

          <v-divider></v-divider>

          <v-card-text class="black--text">
            &copy;2018 — <strong>Vuetify</strong>
          </v-card-text>
        </v-card>
      </v-footer>
    </template>
  </div>
</template>


<script>
  export default {
    data () {
      return {

        landscape: true,
        dialog: false,
        dialog1: false,
        dialog2: false,
        bigModal: false,
        startDatePicker: new Date().toISOString().substr(0, 10),
        stDatePicker: new Date().toISOString().substr(0, 10),
        endDatePicker: new Date().toISOString().substr(0, 10),
        post:{},
        items: [

        ]
      }

    },
    mounted:function(){
      this.getPost();
      console.log(this.$router.currentRoute.params.id);
    },
    methods: {
      submit(){
        let currentObj = this;
        console.log({

          user_id: Number(localStorage.getItem('user_id')),
          service_id: this.post.id,
          start_date: this.stDatePicker,
          end_date: this.endDatePicker

        })

        this.axios.post(process.env.VUE_APP_SECRET+'orders', {

          user_id: Number(localStorage.getItem('user_id')),
          user_name:  localStorage.getItem('name'),
          phone : (localStorage.getItem('phone')!= ""    ? localStorage.getItem('phone') : "not set"),
          service_id: this.post.id,
          service_name: this.post.title,
          start_date: this.stDatePicker,
          end_date: this.endDatePicker

        }).then(function (response) {

            currentObj.output = response.data;
            window.location.href ="/merchant";
            if(localStorage.getItem('type') == 'admin'){
              window.location.href ="/admin"
            }else if(localStorage.getItem('type') == 'Service provider'){
              window.location.href ="/provider"
            }else if(localStorage.getItem('type')== 'Merchant'){
              window.location.href ="/merchant"
            }

          })

          .catch(function (error) {

            currentObj.output = error;
            console.log(error)
          });
      },

      getPost(){
        console.log(process.env.VUE_APP_SECRET+'feeds/' +this.$router.currentRoute.params.id);
        this.axios.get(process.env.VUE_APP_SECRET+'feeds/' +this.$router.currentRoute.params.id)

          .then((response)=> {
            console.log(response.data);
            this.loadArray(response.data);
          })

          .catch(function (error) {
            console.log(error)
          });
      },

      loadArray(value){
        this.post = value;
        this.items = [this.post.image];
        console.log(this.post.image);
      }
      ,
      isLogged(){
        console.log('user ----'+localStorage.getItem('user_id'));
        return localStorage.getItem('user_id')!= null;
      },
      logOut(){
        localStorage.clear();
        window.location.href ="/login";
      },
      checkLogging(){
        if(!this.isLogged()){
          window.location.href ="/login"
        }
      },
      toAdmin(){

        if(localStorage.getItem('type') == 'admin'){
          window.location.href ="/admin"
        }else if(localStorage.getItem('type') == 'Service provider'){
          window.location.href ="/provider"
        }else if(localStorage.getItem('type') == 'Merchant'){
          window.location.href ="/merchant"
        }
      }
    }
  }
</script>
