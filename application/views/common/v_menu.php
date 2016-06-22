<!-- Début menu -->

<div id="MainNavigation">
    <div class="wrap">
        <ul class="mainMenu cssonly" id="Menu1">
            <li><a href="" class="">Accueil</a></li>
               
	    <?php
	if (isset($user) && !is_null($user)) {
                if ($user->checkProfil(PROFIL_MANAGER)) {
            ?>
                    <li><a href="c_manager/affichageStatistique">Commandes</a>
<!--                        <ul class="col">
                            <li><span></span>
                                <ul>
                                    <li><a href="export">Export des données</a></li>
                                    <li><a href="statistiques">Statistiques</a></li>
                                </ul>
                            </li>
                        </ul>-->
                    </li>
                    <li><a href="c_article/affichage">Articles</a></li>
                    <li><a href="c_gestion_employe/affichage">Employés</a></li>
                    
	    <?php
            }
        }
            ?>
			
        </ul>
    </div>
</div>
<!-- Fin menu -->
<div id="Content">
