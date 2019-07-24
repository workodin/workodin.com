// MONACO EDITOR
var moned = {};
moned.htmlModel = null;
moned.editorUpdate = function () {
    if (app && moned.htmlModel) {
        // synchro du code entre monaco editor et vuejs
        app.codeFile = moned.htmlModel.getValue();
    }
};

moned.start = function () {
    // https://github.com/Microsoft/monaco-editor-samples/blob/master/sample-editor/index.html
    require.config({ paths: { 'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.17.1/min/vs' }});
    window.MonacoEnvironment = {
      getWorkerUrl: function(workerId, label) {
          // TODO: better URL by variable fromm PHP
        return 'https://workodin.com/assets/js/monaco-editor-worker-loader-proxy.js';
      }
    };
    require(['vs/editor/editor.main'], function() {
        // on crée l'éditeur après le textarea  
        var editor = monaco.editor.create(document.querySelector('.monaco-editor'), {
            theme: "vs-dark"
        });
        // on remplit le code vuejs dans monaco editor
        moned.htmlModel = monaco.editor.createModel(app.codeFile);
        editor.setModel(moned.htmlModel);
        editor.onDidChangeModelContent(moned.editorUpdate);

    });

}



// création des composants Vue
Vue.component('tr-dyn', {
  // camelCase en JavaScript
  props: { 
    post: Object
  },
  methods: {
  },
  template: `
    <tr>
      <td v-for="(colVal, colName) in post" :class="colName">
        <img v-if="colName == 'urlMedia'" :src="colVal" :title="colVal">
        <pre v-else>{{ colVal }}</pre>
      </td>
      <td><a href="#" v-on:click="$emit('post-update', post)">modifier</a></td>
      <td><a href="#" v-on:click="$emit('post-delete', post)">supprimer</a></td>
    </tr>
  `
});

// création des composants Vue
Vue.component('monaco-editor', {
    // camelCase en JavaScript
    props: { 
      post: Object
    },
    mounted: function () {    
        // MONACO EDITOR
        moned.start();
    },
    methods: {
    },
    template: `
        <div class="monaco-editor"></div>
    `
});
  

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
    tabFile:    [],
    tabHeadFile:[],
    tabResult:  [],
    tabHead:    [],
    mustConfirmDelete:  true,
    formKey:    "",
    formCode:   ""
    /* attention, pas de virgule sur la dernière propriété */
  },
  computed: {
      showEditor: function() {
        // debug
        return "editor";
      }
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
    actDelete: function(targetTable, targetLine, targetMethod) {
      var checkAction = true;
      var curId = targetLine.id;
      if (app.mustConfirmDelete)
        checkAction = confirm('VOUS ALLEZ SUPPRIMER UNE LIGNE:'+curId);

      if(checkAction) {
        formData = new FormData;
        formData.append('formKey', php.formKey);
        formData.append('formTag', 'Admin');
        formData.append('formTagMethod', targetMethod);
        formData.append('table', targetTable);
        formData.append('id', curId);
        wk.sendAjaxForm(formData, null);  
      }
    },
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
    actPostDelete: function(post) {
      this.curPost = post;
      this.actDelete('Post', post, 'Delete');
    },
    actFileDelete: function(post) {
      this.curPost = post;
      this.actDelete('File', post, 'FileDelete');
    },
    actFileCacheReset: function(event) {
      this.popupClass.active = false;

      /* on récupère la liste des Post au chargement de la page */
      formData = new FormData;
      formData.append('formKey', this.formKey);
      formData.append('formTag', 'Admin');
      formData.append('formTagMethod', 'FileCacheReset');
      wk.sendAjaxForm(formData, null);  
    },
    actPopupHide: function(event) {
      // on cache la popup
      this.popupClass.active = false;
    }
    /* attention, pas de virgule sur la dernière propriété */
  }
})

