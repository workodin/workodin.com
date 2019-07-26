
  <div id="app">
    <v-app>
      <v-content>
        <v-container>
        <h3>Parcours de formation</h3>
        </v-container>
        <v-container>
            <v-timeline dense>
                <v-timeline-item v-for="item in tabItem">{{ item }}</v-timeline-item>
            </v-timeline>
        </v-container>
      </v-content>
    </v-app>
  </div>

       </main>
        <footer class="row">
        <div class="col col50 footer1">
            <nav class="menu-footer-1">
                <ul>
                    <?php Site::Get("View")->showMenu("menu-footer-membre-1") ?>
                </ul>
            </nav>
        </div>    
        <div class="col col50 footer2">
        <nav class="menu-footer-2">
                <ul>
                    <?php Site::Get("View")->showMenu("menu-footer-membre-2") ?>
                </ul>
            </nav>
            <p><small>(page publiée le <?php echo date("d/m/Y - H:i:s") ?>)</small></p>
        </div>    
        </footer>
    </div>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-143142316-1"></script>
    <script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());

gtag('config', 'UA-143142316-1');
    </script>
 
 
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify"></script>
    <script>

    /* on prépare avec PHP les infos nécessaires pour JS */
    /* on utilise PHP pour créer du code JS */
    var php = {};
    php.formKey    = '<?php $form->show("formKeyPublic") ?>';

    <?php require_once("$baseDir/public/assets/js/site.js") ?>

    new Vue({
      el: '#app',
      vuetify: new Vuetify(),
      data: {
          tabItem: [ "HTML", "CSS", "JS", "PHP", "SQL" ]
      }
    })
  </script>

</body>
</html>
