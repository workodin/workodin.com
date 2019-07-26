
          
    </div>

    <div class="right">
    <h3>Parcours de formation</h3>
        <v-timeline dense>
            <v-timeline-item v-for="item in tabItem">{{ item }}</v-timeline-item>
        </v-timeline>
    </div>

          </v-flex>
        </v-layout>
      </v-container>
    </v-content>
    <v-footer color="indigo" app>
        </v-app>
  </div>

       </main>
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
          drawer: null,
          tabItem: [ "HTML", "CSS", "JS", "PHP", "SQL" ]
      }
    })
  </script>

</body>
</html>
