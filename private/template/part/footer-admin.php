
       </main>
        <footer class="row">
        <div class="col col50 footer1">
            <nav class="menu-footer-1">
                <ul>
                    <?php Site::Get("View")->showMenu("menu-footer-1") ?>
                </ul>
            </nav>
        </div>    
        <div class="col col50 footer2">
        <nav class="menu-footer-2">
                <ul>
                    <?php Site::Get("View")->showMenu("menu-footer-2") ?>
                </ul>
            </nav>
            <p><small>(page publiée le <?php echo date("d/m/Y - H:i:s") ?>)</small></p>
        </div>    
        </footer>
    </div>

    <script>
<?php require_once("$baseDir/public/assets/js/site.js") ?>
    </script>

</body>
</html>
