        </div> <!-- fin de #Content -->
        <div id="Footer">
            <div id="FooterLinks" class="footer png_fix">
                <ul>
                    <li>
                            <span>
                                    v<?php echo NUM_VERSION; ?>
                                    © DSI ENI 2016
                            </span>
                    </li>
                    <li>
                        <?php 
                        if($this->session->userdata('identifiant'))
                            echo '<a href="connexion/deconnexion">Se deconnecter</a>';
                        else
                            echo '<a href="connexion/authentification">Se connecter</a>';
                        ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>