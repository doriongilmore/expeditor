        </div> <!-- fin de #Content -->
        <div id="Footer">
            <div id="FooterLinks" class="footer png_fix">
                <ul>
                    <li>
                            <span>
                                    v<?php echo NUM_VERSION; ?>
                                    © DCO 2011
                            </span>
                    </li>
                    <li>
                        <a href="<?php echo MAIL_BALMCO; ?>">
                                    Contact					</a>
                    </li>
                    <li>
                        <?php 
                        if($this->session->userdata('identifiant'))
                            echo '<a href="connexion/deconnexion">Se deconnecter</a>';
                        else
                            echo '<a href="connexion/authentification.html">Se connecter</a>';
                        ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>