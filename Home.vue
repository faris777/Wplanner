<style xmlns:v-slot="http://www.w3.org/1999/XSL/Transform" xmlns:v-slot="props" >
  .v-toolbar  > div{
    background-color: #fff9f5;
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

      <v-btn @click="toAdmin" class="black--text" icon>
        <v-icon>apps</v-icon>
      </v-btn>

      <v-btn to="/person" class="black--text" icon>
        <v-icon>person</v-icon>
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


    <v-container grid-list-md text-xs-center>
      <v-layout row wrap>


        <v-flex v-for="post in posts" :key="`4${post}`" xs4>
          <template>
            <v-layout>
              <v-flex xs12 sm10 offset-sm1>
                <v-card>
                  <v-img
                    :src=post.image
                    aspect-ratio="2.75"
                  ></v-img>

                  <v-card-title primary-title>
                    <div>
                      <h3 class="headline mb-0">{{post.title}}</h3>
                      <div> {{ post.description }} </div>
                    </div>
                  </v-card-title>

                  <v-card-actions>
                    <v-btn flat color="orange">Share</v-btn>
                    <v-btn :to="/explore/+ post.id" flat color="orange">Explore</v-btn>
                  </v-card-actions>
                </v-card>
              </v-flex>
            </v-layout>
          </template>
        </v-flex>

      </v-layout>
    </v-container>
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
        posts : [],
        card_text: 'Lorem ipsum dolor sit amet, brute iriure accusata ne mea. Eos suavitate referrentur ad, te duo agam libris qualisque, utroque quaestio accommodare no qui. Et percipit laboramus usu, no invidunt verterem nominati mel. Dolorem ancillae an mei, ut putant invenire splendide mel, ea nec propriae adipisci. Ignota salutandi accusamus in sed, et per malis fuisset, qui id ludus appareat.'
      }
    },

    mounted:function(){
      this.getPosts();

    },
    methods: {

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

      loadArray(value){
        this.posts = value;
        console.log(this.posts);
      },
      isLogged(){
        console.log('user ----'+localStorage.getItem('user_id'));
        return localStorage.getItem('user_id')!= null;
      },
      logOut(){
        localStorage.clear();
        window.location.href ="/login";
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
