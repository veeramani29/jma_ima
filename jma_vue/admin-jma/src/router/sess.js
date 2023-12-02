import Vue from 'vue';
import axios from "axios";
import VueRouter from "vue-router";
//For Post method cookie passing
axios.defaults.withCredentials=true

    export default {

      
        data() {
            return {

                Adminid: ""
            };
        },
        async beforeCreate() {
             console.log('Nothing gets called before me!')
            await axios({ method: "GET", "url": "http://localhost:5000/api/v1/session"}).then(result => {
              
                 console.log('v'+result);
                return this.Adminid = 1;
            }, error => {
                console.log(error.result);
            });

      
        }
      
    }