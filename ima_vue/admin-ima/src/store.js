// store.js
import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
Vue.use(Vuex)

// Assume we have a universal API that returns Promises
// and ignore the implementation details
//import { fetchItem } from './api'

export function createStore () {
  return new Vuex.Store({
     namespaced: true,
    // IMPORTANT: state must be a function so the module can be
    // instantiated multiple times
    state: {
      status: '',
      admin_id:0,
        token: localStorage.getItem('token') || '',
        users: {}
      },
      mutations: {
        auth_request(state) {
            state.status = 'loading'
          },
          auth_set(state,admin_id) {
            state.status = 'success',
             state.admin_id = admin_id
          },
          auth_success(state, user,token) {    console.log(user);   console.log(token);
          state.status = 'success'
          state.token = token
          state.users = user
       
           Vue.set(state.users, user)
          },
          auth_error(state) {
          state.status = 'error'
          },
          logout(state) {
          state.status = ''
          state.token = ''
          },
      },
      actions: {

         session({ commit }) {
           return new Promise((resolve, reject) => {

             
              axios({ url: 'http://localhost:5000/api/v1/sessions', method: 'GET' })
                .then(resp => {
                  console.log(resp.data[0]);
                    commit('auth_set', 1)
                });
            })
         },
        login({ commit }, user) {
            return new Promise((resolve, reject) => {

              commit('auth_request')
              axios({ url: 'http://localhost:5000/api/v1/login/login', data: user, method: 'POST' })
                .then(resp => {
                  console.log(resp.data[0]);
                  const token = 'vvvvvvvv'
                  const user = resp.data[0]
                  localStorage.setItem('token', token)
                  // Add the following line:
                  axios.defaults.headers.common['Authorization'] = token
                  commit('auth_success', token, user)
                  resolve(resp)
                })
                .catch(err => {
                  commit('auth_error')
                  localStorage.removeItem('token')
                  reject(err)
                })
            })
          },
          saveData({ commit }, userData){
              return new Promise((resolve, reject) => {
            const token = 'vvvvvvvv'
              const user_data = userData ;
              localStorage.setItem('token', token)
            commit('auth_request')
             commit('auth_success', user_data,token)
               resolve()
              })

          },
           logout({ commit }) {
            return new Promise((resolve, reject) => {
              commit('logout')
              localStorage.removeItem('token')
              delete axios.defaults.headers.common['Authorization']
              resolve()
            })
          }
      },
      getters: { 

    isLoggedIn: state => !!state.token,
    authStatus: state => state.status,
    authUsers: state => state.admin_id,

      }
    
  
  })
}