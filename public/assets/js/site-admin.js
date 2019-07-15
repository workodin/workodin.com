// création des composants Vue
Vue.component('tr-dyn', {
  // camelCase en JavaScript
  props: { 
    post: Object
  },
  template: '<tr><td v-for="(colVal, colName) in post" :class="colName"><pre>{{ colVal }}</pre></td></tr>'
})

// ensuite, on cére l'instance de Vue
var app = new Vue({
  el: '#app',
  data: {
    message:    'Bienvenue',
    nbPost:     php.nbPost,
    loginUser:  php.loginUser,
    idUser:     php.idUser,
    popupClass: { active: false },
    codeSQL:    "",
    tabResult:  []
    /* attention, pas de virgule sur la dernière propriété */
  },
  methods: {
    actSQL: function(event) {
      // on affiche la popup
      this.popupClass.active = true;
    },
    actPopupHide: function(event) {
      // on cache la popup
      this.popupClass.active = false;
    }
    /* attention, pas de virgule sur la dernière propriété */
  }
})