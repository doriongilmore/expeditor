<!-- Début menu -->

<div id="MainNavigation">
    <div class="wrap">
        <ul class="mainMenu cssonly" id="Menu1">
            <li><a href="accueil" class="home">Accueil</a></li>
               
	    <?php
	if (isset($user) && !is_null($user)) {
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
	}
            ?>
			
        </ul>
    </div>
</div>
<!-- Fin menu -->
<div id="Content">
