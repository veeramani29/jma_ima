import Vue from 'vue';
import '@/assets/notifications.js'
import '@/assets/notifications.css'
import VueRouter from "vue-router";
import axios from 'axios';
import NotFound from "@/components/NotFound/404";
import Login from "@/components/Login/Login";
import PostList from "@/components/Post/PostList";
import PostAdd from "@/components/Post/PostAdd";
import PostEdit from "@/components/Post/PostEdit";
import ArchiveList from "@/components/Post/ArchiveList";
import ArchiveEdit from "@/components/Post/ArchiveEdit";
import CategoryList from "@/components/Category/CategoryList";
import CategoryAdd from "@/components/Category/CategoryAdd";
import CategoryEdit from "@/components/Category/CategoryEdit";
import SeoList from "@/components/Seo/SeoList";
import SeoAdd from "@/components/Seo/SeoAdd";
import MediaList from "@/components/Media/MediaList";
import MediaAdd from "@/components/Media/MediaAdd";
import MediaEdit from "@/components/Media/MediaEdit";
// import MaterialList from "@/components/Material/MaterialList";
// import MaterialAdd from "@/components/Material/MaterialAdd";
// import MaterialEdit from "@/components/Material/MaterialEdit";
import BriefSeriesList from "@/components/BriefSeries/BriefSeriesList";
import BriefSeriesAdd from "@/components/BriefSeries/BriefSeriesAdd";
// import MetaList from "@/components/Meta/MetaList";
// import MetaAdd from "@/components/Meta/MetaAdd";
import GraphList from "@/components/Graph/GraphList";
import GraphAdd from "@/components/Graph/GraphAdd";
import GraphEdit from "@/components/Graph/GraphEdit";
import GraphView from "@/components/Graph/GraphView";
import MapList from "@/components/Map/MapList";
import MapAdd from "@/components/Map/MapAdd";
import MapEdit from "@/components/Map/MapEdit";
import MapView from "@/components/Map/MapView";
import UserList from "@/components/User/UserList";
import UserAdd from "@/components/User/UserAdd";
import UserEdit from "@/components/User/UserEdit";
import CompaniesList from "@/components/Companies/CompaniesList";
import CompaniesAdd from "@/components/Companies/CompaniesAdd";
import CompaniesEdit from "@/components/Companies/CompaniesEdit";
import EmailList from "@/components/Email/EmailList";
import EmailAdd from "@/components/Email/EmailAdd";
import EmailEdit from "@/components/Email/EmailEdit";
import CacheSettings from "@/components/MoreSettings/CacheSettings";
import IndexGraph from "@/components/MoreSettings/IndexGraph";
import IPAddress from "@/components/MoreSettings/IPAddress";
import IndexGraphEdit from "@/components/MoreSettings/IndexGraphEdit"
import ChangePassword from "@/components/Login/ChangePassword"
// import Loader from "@/components/loader";
//import { createStore } from '../store'
//For Post method cookie passing





//const instance = axios.create(); // instance.get('http://localhost:5000/api/v1/sessions'); 

axios.interceptors.request.use((config) => {
    document.getElementById("loader-overlay").style.display = "block";
    return config
})

axios.interceptors.response.use((response) => {
        document.getElementById("loader-overlay").style.display = "none";

        // Vue.Loading = Vue.prototype.Loading = "true";
        // window.console.log(response.config.url == http: //localhost:5000/api/v1/login/login);
        var nodejsServer = "";
        if (Vue.env('NODE_ENV') == 'development')
            nodejsServer = Vue.env('VUE_APP_ROOT_API') + ":" + Vue.env('VUE_APP_NODE_PORT') + "/api/v1/";
        else
            nodejsServer = Vue.prototype.nodejsServer = Vue.env('VUE_APP_ROOT_API') + "/api/v1/";
        if (!response.headers['logged-in'] && response.config.url != nodejsServer + "login/login" && response.config.url != nodejsServer + "post/saveFile") window.location = Vue.env('VUE_APP_BASE_URL');
        return response;

    },
    (error) => {
        // handle error
        if (error) {
            window.createNotification({
                closeOnClick: true,
                displayCloseButton: false,
                positionClass: "Top Right",
                showDuration: 3000,
                theme: "error"
            })({
                title: "Error",
                message: JSON.stringify(error.message)
            });
            document.getElementById("loader-overlay").style.display = "none";
            // window.console.log(error);
        }
    });



/*axios.interceptors.response.use((response)=>{
    window.console.log(response);
    return response;
 });*/


Vue.env = Vue.prototype.env = function (value) {
    return (process.env[value] != '') ? process.env[value] : '';

}
//const store = createStore()
//store.dispatch("session");

const isAuthenticated = function () {
    var seesionDate = localStorage.getItem('time');
    var currentDate = Math.round(new Date().getTime() / 1000);
    if (localStorage.getItem('token') && seesionDate > currentDate) {
        return true;
    }
    return false;
};
Vue.use(VueRouter)
const Vrouter = new VueRouter({
    base: Vue.env('VUE_APP_BASE_URL'),
    routes: [{
            path: '*',
            name: 'not-found',
            component: NotFound,
        },

        {
            path: "/",
            name: "Login",
            component: Login
        },
        {
            path: "/PostList",
            name: "PostList",
            component: PostList,
        },
        {
            path: "/PostAdd",
            name: "AddPost",
            component: PostAdd
        },
        {
            path: "/PostEdit/:id",
            name: "PostEdit",
            component: PostEdit
        },
        {
            path: "/ArchiveList",
            name: "ArchiveList",
            component: ArchiveList,
        },
        {
            path: "/ArchiveEdit/:id",
            name: "ArchiveEdit",
            component: ArchiveEdit,
        },
        {
            path: "/CategoryList",
            name: "CategoryList",
            component: CategoryList
        },
        {
            path: "/CategoryAdd",
            name: "AddCategory",
            component: CategoryAdd
        },
        {
            path: "/CategoryEdit/:id",
            name: "CategoryEdit",
            component: CategoryEdit
        },
        {
            path: "/SeoList",
            name: "SeoList",
            component: SeoList
        },
        {
            path: "/SeoAdd",
            name: "AddSeo",
            component: SeoAdd
        },
        {
            path: "/MediaList",
            name: "MediaList",
            component: MediaList
        },
        {
            path: "/MediaAdd",
            name: "AddMedia",
            component: MediaAdd
        },
        {
            path: "/MediaEdit/:id",
            name: "MediaEdit",
            component: MediaEdit
        },
        // {
        //     path: "/MaterialList",
        //     name: "MaterialList",
        //     component: MaterialList
        // },
        // {
        //     path: "/MaterialAdd",
        //     name: "AddMaterial",
        //     component: MaterialAdd
        // },
        // {
        //     path: "/MaterialEdit",
        //     name: "EditMaterial",
        //     component: MaterialEdit
        // },
        {
            path: "/BriefSeriesList",
            name: "BriefSeriesList",
            component: BriefSeriesList
        },
        {
            path: "/BriefSeriesAdd",
            name: "AddBriefSeries",
            component: BriefSeriesAdd
        },
        // {
        //     path: "/MetaList",
        //     name: "MetaList",
        //     component: MetaList
        // },
        // {
        //     path: "/MetaAdd",
        //     name: "AddMeta",
        //     component: MetaAdd
        // },
        {
            path: "/GraphList",
            name: "GraphList",
            component: GraphList
        },
        {
            path: "/GraphAdd",
            name: "AddGraph",
            component: GraphAdd
        },
        {
            path: "/GraphEdit/:id",
            name: "EditGraph",
            component: GraphEdit
        },
        {
            path: "/GraphView/:id",
            name: "ViewGraph",
            component: GraphView
        },
        {
            path: "/MapList",
            name: "MapList",
            component: MapList
        },
        {
            path: "/MapAdd",
            name: "AddMap",
            component: MapAdd
        },
        {
            path: "/MapEdit/:id",
            name: "EditMap",
            component: MapEdit
        },
        {
            path: "/MapView/:id",
            name: "ViewMap",
            component: MapView
        },
        {
            path: "/UserList",
            name: "UserList",
            component: UserList
        },
        {
            path: "/UserAdd",
            name: "AddUser",
            component: UserAdd
        },
        {
            path: "/UserEdit/:id",
            name: "EditUser",
            component: UserEdit
        },
        {
            path: "/CompaniesList",
            name: "CompaniesList",
            component: CompaniesList
        },
        {
            path: "/CompaniesAdd",
            name: "AddCompanies",
            component: CompaniesAdd
        },
        {
            path: "/CompaniesEdit/:id",
            name: "EditCompanies",
            component: CompaniesEdit
        },
        {
            path: "/EmailList",
            name: "EmailList",
            component: EmailList
        },
        {
            path: "/EmailAdd",
            name: "AddEmail",
            component: EmailAdd
        },
        {
            path: "/EmailEdit/:id",
            name: "EditEmail",
            component: EmailEdit
        },
        {
            path: "/CacheSettings",
            name: "CacheSettings",
            component: CacheSettings
        },
        {
            path: "/IndexGraph",
            name: "IndexGraph",
            component: IndexGraph
        },
        {
            path: "/IPAddress",
            name: "IPAddress",
            component: IPAddress
        },
        {
            path: "/IndexGraphEdit",
            name: "IndexGraphEdit",
            component: IndexGraphEdit
        },
        {
            path: "/ChangePassword",
            name: "ChangePassword",
            component: ChangePassword
        }
    ],
    mode: 'history'
});


//console.log(vueRouter);
Vrouter.beforeEach((to, from, next) => {
    // console.log(new Date().toISOString().slice(0, 10));
    if (to.path != '/' && !isAuthenticated()) window.location.href = Vue.env('VUE_APP_BASE_URL');
    else next()
})
export default Vrouter;