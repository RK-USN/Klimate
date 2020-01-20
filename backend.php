<?php
session_start();
// Ved adminside IF ($_SESSION['bruker'] and $_SESSION['brukertype'] == 1) {}
if ($_SESSION['brukernavn']) {
    // OK
} else {
    header("Location: default.php?error=1");
}

try {
    include("klimate_pdo.php");
    $db = new mysqlPDO();
} 
catch (Exception $ex) {
    // Disse feilmeldingene leder til samme tilbakemelding for bruker, dette kan ønskes å utvide i senere tid, så beholder alle for nå.
    if ($ex->getCode() == 1049) {
        // 1049, Fikk koblet til men databasen finnes ikke
        header('location: default.php?error=3');
    }
    if ($ex->getCode() == 2002) {
        // 2002, Kunne ikke koble til server
        header('location: default.php?error=3');
    }
    if ($ex->getCode() == 1045) {
        // 1045, Bruker har ikke tilgang
        header('location: default.php?error=3');
    }
}

//-----------------------------------//
// Henter arrangementer fra database //
//-----------------------------------//

// Denne sorterer og henter ut det nyeste arrangementet
$hentArrangement = "select * from event order by tidspunkt DESC limit 1";
$stmtArrangement = $db->prepare($hentArrangement);
$stmtArrangement->execute();
$sisteArrangement = $stmtArrangement->fetch(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="no">

    <head>
        <!-- Setter riktig charset -->
        <meta charset="UTF-8">
        <!-- Legger til viewport -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Setter tittelen på prosjektet -->
        <title>Klimate</title>
        <!-- Henter inn ekstern stylesheet -->
        <link rel="stylesheet" type="text/css" href="stylesheet.css">
        <!-- Henter inn favicon, bildet som dukker opp i fanene i nettleseren -->
        <link rel='icon' href='bilder/favicon.png' type='image/x-icon'>
        <!-- Henter inn JavaScript -->
        <script language="JavaScript" src="javascript.js"></script>
    </head>


    <body>
        <article class="innhold">   
            <!-- Begynnelse på øvre navigasjonsmeny -->
            <nav class="navTop">
                <!-- Bruker et ikon som skal åpne gardinmenyen, henviser til funksjonen hamburgerMeny i javascript.js -->
                <!-- javascript:void(0) blir her brukt så siden ikke scroller til toppen av seg selv når du trykker på hamburger-ikonet -->
                <a class="bildeKontroll" href="javascript:void(0)" onclick="hamburgerMeny()" tabindex="4">
                    <img src="bilder/hamburgerIkon.svg" alt="Hamburger-menyen" class="hamburgerKnapp">
                </a>
                <!-- <img src="bilder/</?php echo($_SESSION['profilbilde']) ?>" -->
                <a class="bildeKontroll" href="javascript:void(0)" onClick="location.href='konto.php'" tabindex="3">
                    <img src="bilder/profil.png" alt="Profilbilde" class="profil_navmeny">
                </a>
                <!-- Legger til en knapp for å logge ut når man er innlogget -->
                <form method="POST" action="default.php">
                    <button name="loggUt" id="backendLoggUt" tabindex="2" value="true">LOGG UT</button>
                </form>

                <!-- Logoen øverst i venstre hjørne, denne leder alltid tilbake til default.php -->
                <a class="bildeKontroll" href="default.php" tabindex="1">
                    <img src="bilder/klimateNoText.png" alt="Klimate logo" class="Logo_navmeny">
                </a> 
            <!-- Slutt på navigasjonsmeny-->
            </nav>

            <!-- Gardinmenyen, denne går over alt annet innhold ved bruk av z-index -->
            <section id="navMeny" class="hamburgerMeny">

                <!-- innholdet i hamburger-menyen -->
                <!-- -1 tabIndex som standard, man tabber ikke inn i menyen når den er lukket -->
                <section class="hamburgerInnhold">
                    <a class = "menytab" tabIndex = "-1" href="arrangement.php">Arrangementer</a>
                    <a class = "menytab" tabIndex = "-1" href="artikkel.php">Artikler</a>
                    <a class = "menytab" tabIndex = "-1" href="#">Diskusjoner</a>
                    <a class = "menytab" tabIndex = "-1" href="backend.php">Oversikt</a>
                    <a class = "menytab" tabIndex = "-1" href="konto.php">Konto</a>
                </section>
            </section>
            
            <!-- Profilbilde med planlagt "Velkommen *Brukernavn hentet fra database*" -->
            <header class="backend_header" onclick="lukkHamburgerMeny()">
                <img src="bilder/profil.png" alt="Profilbilde" class="profil_backend">
                <h1 class="velkomst">Velkommen <?php if($_SESSION['fornavn'] != "") { echo($_SESSION['fornavn']); } else { echo($_SESSION['brukernavn']); } ?></h1>
            </header>

            <main id="backend_main" onclick="lukkHamburgerMeny()">
                <!-- Innholdet på siden -->
                <!-- IDene brukes til å splitte opp kolonnene i queries -->
                <article id="bgcont1">
                    <h2>Siste arrangement</h2>
                    <p><?php echo($sisteArrangement['eventnavn'])?></p>
                    <a href="arrangement.php?arrangement=<?php echo($sisteArrangement['idevent']) ?>">Trykk her for å se dette arrangementet</a>
                </article>
                <article id="bgcont2">
                    <h2>Diskusjoner</h2>
                    <!-- Dette vil da være resultat av en spørring mot database, bruk av echo for å vise -->
                    <p>Bruk av gressklipper, bensin eller elektrisk?</p>
                    <a href="#">Trykk her for å lese videre</a>
                </article>
                <article id="bgcont3">
                    <h2>Artikler</h2>
                    <!-- Dette vil da være resultat av en spørring mot database, bruk av echo for å vise -->
                    <p>Hundretusener demonstrerer for klima over hele verden</p>
                    <a href="#">Trykk her for å lese videre</a>
                </article>
            </main>

            <!-- Knapp som vises når du har scrollet i vinduet, tar deg tilbake til toppen -->
            <button onclick="tilbakeTilTopp()" id="toppKnapp" title="Toppen"><img src="bilder/pilopp.png" alt="Tilbake til toppen"></button>

            <!-- Footer, epost er for øyeblikket på en catch-all, videresendes til RK -->
            <footer>
                <p class=footer_beskrivelse>&copy; Klimate 2019 | <a href="mailto:kontakt@klimate.no">Kontakt oss</a>
                    <!-- Om brukeren ikke er administrator eller redaktør, vis link for søknad til å bli redaktør -->
                    <?php if ($_SESSION['brukertype'] == "3") { ?> | <a href="soknad.php">Søknad om å bli redaktør</a><?php } ?>
                </p>
            </footer>
        </article>   
    </body>

    <!-- Denne siden er utviklet av Glenn Petter Pettersen, Robin Kleppang & Aron Snekkestad, siste gang endret 05.12.2019 -->
    <!-- Denne siden er kontrollert av Glenn Petter Pettersen, Robin Kleppang siste gang 08.12.2019 -->

</html>
