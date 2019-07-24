// MONACO EDITOR
var moned           = {};
moned.htmlModel     = null;
moned.editor        = null;
moned.editorUpdate  = function () {
    // synchro du code entre monaco editor et vuejs
    if (app && moned.htmlModel) {
        if (app.panelActive == "formFileCreate")
        {
            app.codeFile = moned.htmlModel.getValue();            
        }
        else if (app.panelActive == "formPostCreate")
        {
            app.formCode = moned.htmlModel.getValue();            
        }
        else if (app.panelActive == "formPostUpdate")
        {
            app.curPost.code = moned.htmlModel.getValue();            
        }
    }
};

moned.start         = function (targetClass) {

    // https://github.com/Microsoft/monaco-editor-samples/blob/master/sample-editor/index.html
    require.config({ paths: { 'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.17.1/min/vs' }});
    window.MonacoEnvironment = {
      getWorkerUrl: function(workerId, label) {
          // TODO: better URL by variable fromm PHP
        return 'https://workodin.com/assets/js/monaco-editor-worker-loader-proxy.js';
      }
    };
    require(['vs/editor/editor.main'], function() {
        if (moned.editor == null) {
            // on crée l'éditeur après le textarea  
            // ne pas oublier de rajouter le prefixe . pour sélectionner une classe
            moned.editor = monaco.editor.create(document.querySelector('.' + targetClass), {
                theme: "vs-dark"
            });
            // resize
            window.addEventListener('resize', function(){
                moned.editor.layout(); 
            });

            // on remplit le code vuejs dans monaco editor
            // synchro du code entre monaco editor et vuejs
            if (moned.htmlModel == null) {
                moned.htmlModel = monaco.editor.createModel("", "php");
                moned.editor.setModel(moned.htmlModel);
                moned.editor.onDidChangeModelContent(moned.editorUpdate);
            }

        }
    });

}

moned.actShowPopup = function () {
    if (app && (moned.htmlModel != null)) {
        if (app.panelActive == "formFileCreate")
        {
            moned.htmlModel.setValue(app.codeFile);
        }
        else if (app.panelActive == "formPostCreate")
        {
            moned.htmlModel.setValue(app.formCode);
        }
        else if (app.panelActive == "formPostUpdate")
        {
            moned.htmlModel.setValue(app.curPost.code);
        }
    }
}

// création des composants Vue
Vue.component('tr-dyn', {
  // camelCase en JavaScript
  props: { 
    post: Object
  },
  methods: {
      filter: function (colVal) {
          if ('string' == typeof colVal) {
              return colVal.substring(0, app.maxLength);
          }
          else {
              return '...';
          }
      },
      doRowClass: function (post) {
        return 'tabline';
      }
  },
  template: `
    <tr :class="doRowClass(post)">
        <td>
            <div><a href="#" v-on:click="$emit('post-update', post)">modifier</a></div>
            <div><a href="#" v-on:click="$emit('post-delete', post)">supprimer</a></div>
        </td>
        <td v-for="(colVal, colName) in post" :class="colName" @click="$emit('post-td-click', post)">
            <img v-if="colName == 'urlMedia'" :src="colVal" :title="colVal">
            <pre v-else>{{ filter(colVal) }}</pre>
        </td>
    </tr>
  `
});

// création des composants Vue
Vue.component('monaco-editor', {
    // camelCase en JavaScript
    props: { 
      post: Object,
      config: Object,
    },
    mounted: function () {  
        // MONACO EDITOR
        moned.start(this.config.target);
    },
    methods: {
    },
    template: `
        <div class="monaco-editor" :class="config.target"></div>
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
    maxLength:  160,
    mustConfirmDelete:  true,
    formKey:    "",
    formCode:   ""
    /* attention, pas de virgule sur la dernière propriété */
  },
  computed: {
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
    actPostCreate: function(event) {
      // on affiche la popup
      this.panelActive = "formPostCreate";
      this.popupClass.active = true;
      moned.actShowPopup();
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
      console.log(this.curPost);
      // on affiche la popup
      this.panelActive = "formPostUpdate";
      this.panelFeedback = "";
      this.popupClass.active = true;
      moned.actShowPopup();
    },
    actPostCopy: function(post) {
        // on copie le code
        this.formCode = post.code;
        if (moned.htmlModel) {
            moned.htmlModel.setValue(post.code);
        }
        // on affiche la popup
        this.panelActive = "formPostCreate";
        this.popupClass.active = true;
        moned.actShowPopup();
    },
    actPostDelete: function(post) {
      this.curPost = post;
      this.actDelete('Post', post, 'Delete');
    },
    actFileCreate: function(event) {
        // on affiche la popup
        this.panelActive = "formFileCreate";
        this.popupClass.active = true;
        moned.actShowPopup();
    },
    actFileCopy: function(post) {
        // on copie le code
        if (moned.htmlModel)  {
            moned.htmlModel.setValue(post.code);
        }

        // on affiche la popup
        this.panelActive = "formFileCreate";
        this.popupClass.active = true;
        moned.actShowPopup();
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

