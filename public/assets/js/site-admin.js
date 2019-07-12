var app = new Vue({
  el: '#app',
  data: {
    message:    'Bienvenue',
    nbPost:     php.nbPost,
    loginUser:  php.loginUser,
    idUser:     php.idUser,
    popupClass: { active: false }
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