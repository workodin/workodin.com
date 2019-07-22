// création des composants Vue
Vue.component('tr-dyn', {
  // camelCase en JavaScript
  props: { 
    post: Object
  },
  methods: {
    actDelete: function(event, curId) {
      var checkAction = true;

      if (app.mustConfirmDelete)
        checkAction = confirm('VOUS ALLEZ SUPPRIMER UNE LIGNE:'+curId);

      if(checkAction) {
        formData = new FormData;
        formData.append('formKey', php.formKey);
        formData.append('formTag', 'Admin');
        formData.append('formTagMethod', 'Delete');
        formData.append('id', curId);
        wk.sendAjaxForm(formData, null);  
      }
    }
  },
  template: `
    <tr>
      <td v-for="(colVal, colName) in post" :class="colName">
        <img v-if="colName == 'urlMedia'" :src="colVal" :title="colVal">
        <pre v-else>{{ colVal }}</pre>
      </td>
      <td><a href="#" v-on:click="$emit('post-update', post)">modifier</a></td>
      <td><a href="#" v-on:click="actDelete($event, post.id)">supprimer</a></td>
    </tr>
  `
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
    panelActive: "",
    panelFeedback: "",
    curPost:    null,
    codeSQL:    "",
    codeFile:   "",
    tabResult:  [],
    tabHead:    [],
    mustConfirmDelete:  true,
    formKey:    "",
    formCode:   ""
    /* attention, pas de virgule sur la dernière propriété */
  },
  mounted: function () {
    /* on mémorise formKey pour les formulaires en Ajax */
    this.formKey = php.formKey;

    /* on récupère la liste des Post au chargement de la page */
    formData = new FormData;
    formData.append('formKey', php.formKey);
    formData.append('formTag', 'Admin');
    formData.append('formTagMethod', 'Read');
    wk.sendAjaxForm(formData, null);  
  },
  methods: {
    actSQL: function(event) {
      // on affiche la popup
      this.panelActive = "formSQL";
      this.popupClass.active = true;
    },
    actFileCreate: function(event) {
      // on affiche la popup
      this.panelActive = "formFileCreate";
      this.popupClass.active = true;
    },
    actPostCreate: function(event) {
      // on affiche la popup
      this.panelActive = "formPostCreate";
      this.popupClass.active = true;
    },
    actPostRead: function(event) {
      this.popupClass.active = false;

      /* on récupère la liste des Post au chargement de la page */
      formData = new FormData;
      formData.append('formKey', this.formKey);
      formData.append('formTag', 'Admin');
      formData.append('formTagMethod', 'Read');
      wk.sendAjaxForm(formData, null);  
    },
    actPostUpdate: function(post) {
      this.curPost = post;
      // on affiche la popup
      this.panelActive = "formPostUpdate";
      this.panelFeedback = "";
      this.popupClass.active = true;
    },
    actPopupHide: function(event) {
      // on cache la popup
      this.popupClass.active = false;
    }
    /* attention, pas de virgule sur la dernière propriété */
  }
})