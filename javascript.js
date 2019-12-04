/* Funksjonen som åpner og lukker gardinmenyen, bruker height for at den skal gå over hele siden */
$gjort = false;



function hamburgerMeny() {
  if ($gjort == false) {
    /* Når hamburgermenyen er åpen får menyinnholdet tabIndex for å kunne gå igjennom dette uten mus */
    document.getElementById("navMeny").style.height = "100%";
    $gjort = true;
    document.getElementById("menytab1").tabIndex = "5";
    document.getElementById("menytab2").tabIndex = "6";
    document.getElementById("menytab3").tabIndex = "7";
    document.getElementById("menytab4").tabIndex = "8";
    document.getElementById("menytab5").tabIndex = "9";
  } else {
    /* Når hamburgermenyen er lukket setter vi tabIndex for innholdet til -1 for å ikke tabbe inn i denne */
    document.getElementById("navMeny").style.height = "0%";
    $gjort = false;
    document.getElementById("menytab1").tabIndex = "-1";
    document.getElementById("menytab2").tabIndex = "-1";
    document.getElementById("menytab3").tabIndex = "-1";
    document.getElementById("menytab4").tabIndex = "-1";
    document.getElementById("menytab5").tabIndex = "-1";
  }
}
/* funksjon for å lukke hamburger-meny'en om man trykker utenfor dropdown'en */
/* Når hamburgermenyen er lukket setter vi tabIndex for innholdet til -1 for å ikke tabbe inn i denne */
function lukkHamburgerMeny() {
  if ($gjort == true) {
    document.getElementById("navMeny").style.height = "0%";
    $gjort = false;
    document.getElementById("menytab1").tabIndex = "-1";
    document.getElementById("menytab2").tabIndex = "-1";
    document.getElementById("menytab3").tabIndex = "-1";
    document.getElementById("menytab4").tabIndex = "-1";
    document.getElementById("menytab5").tabIndex = "-1";
  }
}


function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
      mybutton.style.display = "block";
  } else {
      mybutton.style.display = "none";
  }
  }


function topFunction() {
document.body.scrollTop = 0;
document.documentElement.scrollTop = 0;
}

/* Tilsvarende bool for 'endre passord'-gardinen */
$endrePassord = false;

/* Funksjonen åpner og lukker rullgardinen ved trykk på knappen */
function endrePassordMeny() {
  if ($endrePassord == false) {
    document.getElementById("endrePassordMeny").style.height = "100%";
    $endrePassord = true;
  } else {
    document.getElementById("endrePassordMeny").style.height = "0%";
    $endrePassord = false;
  }
}


/* Denne blir kjørt når konto_rediger.php blir lastet inn, legger til en eventlistener */
function kontoRullegardin() {
  /* Funksjonen åpner og lukker rullegardinen innenfor passord endring ved klikk */
  var element = document.getElementsByClassName("kontoRullegardin");
  var i;

  for (i = 0; i < element.length; i++) {
      element[i].addEventListener("click", function() {
          this.classList.toggle("aktiv");
          var innholdRullegardin = this.nextElementSibling;
          if (innholdRullegardin.style.display == "block") {
              innholdRullegardin.style.display = "none";
          } else {
              innholdRullegardin.style.display = "block";
          }
      });
  }
}




/* Denne siden er utviklet av Robin Kleppang, sist endret 13.11.2019 */
/* Denne siden er kontrollert av Glenn Petter Pettersen, siste gang 11.10.2019 */