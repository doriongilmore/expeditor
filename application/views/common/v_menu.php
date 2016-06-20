<!-- Début menu -->

<div id="MainNavigation">
    <div class="wrap">
        <ul class="mainMenu cssonly" id="Menu1">
            <li><a href="accueil" class="home">Accueil</a></li>
            <li><a href="#">Situations dangereuses</a>
                <ul class="col">
                    <li><span></span>
                        <ul>
                                <li><a href="formulaire">Signaler une nouvelle situation dangereuse</a></li>
                                <li><a href="liste_d">Consulter vos alertes précédentes</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
                    
	    <?php
                if ($user->checkProfil(array(PROFIL_CDT, PROFIL_EXPERT))) {
            ?>
            <li><a href="#">Chargé de traitement</a>
                <ul class="col">
                    <li><span></span>
                        <ul>
                            <?php if ($user->checkProfil(PROFIL_CDT))  ?>
                                <li><a href="liste_c">Liste Situations Dangereuses à traiter</a></li>
                            <?php if ($user->checkProfil(array(PROFIL_CDT, PROFIL_EXPERT)))  ?>
                                <li><a href="search">Moteur de recherche</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
	    <?php
                }
            ?>
	    <?php
                if ($user->checkProfil(PROFIL_EXPERT)) {
            ?>
            <li><a href="#">Expert</a>
                <ul class="col">
                    <li><span></span>
                        <ul>
                                <li><a href="export">Export des données</a></li>
                                <li><a href="statistiques">Statistiques</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
	    <?php
                }
            ?>
	    <?php
                if ($user->checkProfil(PROFIL_MANAGER)) {
            ?>
            <li><a href="#">Manager</a>
                <ul class="col">
                    <li><span></span>
                        <ul>
                                <li><a href="exportManager">Export des données</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
	    <?php
                }
            ?>
	    <?php
                if ($user->checkProfil(PROFIL_ADMIN)) {
            ?>
            <li><a href="#">Admin</a>
                <ul class="col">
                    <li><span></span>
                        <ul>
                                <li><a href="habilitation">Habilitations</a></li>
                                <li><a href="affect">Affectations</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
	    <?php
                }
            ?>
			
        </ul>
    </div>
</div>
<!--<div class="wrap">
    <div class="ariane">
        <?php
        $uri = $this->uri->segment_array();

        if (isset($uri[2]) && $uri[2] == 'accueil')
            $start = 2;
        else
        {
            $uri[1] = 'accueil';
            $start = 1;
        }
        $lg = count($uri);

        for ($i=$start; $i<=$lg; $i++)
        {
            $uri[$i] = preg_replace('/(_[0-9]+)$/', '', $uri[$i]);

            if ($uri[$i] != 'index')
            {
            echo '<a>'.humanize($uri[$i]).'</a>';

            if ($i !== $lg)
                echo ' > ';
            }
        }
        ?>
    </div>
</div>-->
<!-- Fin menu -->
<div id="Content">
