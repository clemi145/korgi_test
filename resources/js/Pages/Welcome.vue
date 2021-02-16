<template>
    <!--  <div id="page-wrapper">-->
    <!--    <div-->
    <!--      v-if="canLogin"-->
    <!--      class="hidden fixed top-0 right-0 px-6 py-4 sm:block"-->
    <!--      id="navigation"-->
    <!--    >-->
    <!--      <inertia-link-->
    <!--        v-if="$page.props.user"-->
    <!--        href="/gruppen"-->
    <!--        class="text-sm text-gray-700 underline"-->
    <!--      >-->
    <!--        Gruppen-->
    <!--      </inertia-link>-->

<!--          <template v-else>-->
<!--            <inertia-link-->
<!--              :href="route('login')"-->
<!--              class="text-sm text-gray-700 underline"-->
<!--            >-->
<!--              Login-->
<!--            </inertia-link>-->

    <!--        <inertia-link-->
    <!--          v-if="canRegister"-->
    <!--          :href="route('register')"-->
    <!--          class="ml-4 text-sm text-gray-700 underline"-->
    <!--        >-->
    <!--          Register-->
    <!--        </inertia-link>-->
    <!--      </template>-->
    <!--    </div>-->
    <!--    <div id="header">-->
    <!--      <h1>-->
    <!--        <span class="accentText">K</span><span class="primaryText">ORG</span-->
    <!--        ><span class="accentText">I</span>-->
    <!--      </h1>-->
    <!--    </div>-->
    <!--  </div>-->
    <div id="welcome">
        <div id="navigation">
            <img id="logo" src="/images/korgi_full_l.svg" alt="Logo">
            <div id="link-container">
                <a @click="scrollToId('header')">Home</a>
                <a @click="scrollToId('login')"">Anmelden</a>
                <a @click="scrollToId('about')">Über uns</a>
            </div>
        </div>
        <div id="header">
            <div id="header-content">
                <div id="header-content-left">
                    <h1 class="slogan">Organisation leicht gemacht.</h1>
                    <div class="separator"></div>
                    <div class="text">Weil Kommunikation und Organisation
                        auch im Kindergarten nicht kompliziert
                        sein muss, setzt KORGI genau hier an. </div>
                    <a @click="scrollToId('login')" class="btn primary-background">Anmelden</a>
                </div>
                <div id="header-content-right">
                    <img id="app-preview" src="/images/app_vorschau_hr.png" alt="App Vorschau">
                </div>
            </div>
        </div>
        <div id="login">
            <h2 class="headline">Anmeldung</h2>
            <div id="login-content">
                <login></login>
                <div class="separator"></div>
                <div id="register">
                    <img id="logo-msg" src="/images/dog_message.svg" alt="KORGI">
                    <div id="register-info">Registriere dich jetzt und genieße
                        alle Vorteile von KORGI.
                        Absolut kostenlos.</div>
                    <div class="btn secondary-background">Registrieren</div>
                </div>
            </div>
        </div>
        <div id="about">
            <h2 class="headline">Über uns</h2>
            <div id="about-content">
                <div id="about-content-left">
                    <h2 class="section-headline">Die Idee</h2>
                    <div class="text">Die Idee ist es, die Komplexität der Verwaltung mehrere
                        Kindergartengruppen, hinsichtlich Organisation und
                        Terminplanung für diverse alltägliche Ereignisse, für Eltern sowie
                        Personal, auf ein Minimum zu reduzieren. </div>
                    <h2 class="section-headline">Wieso KORGI?</h2>
                    <div class="text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed
                        diam nonumy eirmod tempor invidunt ut labore et dolore magna
                        aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo. </div>
                    <h2 class="section-headline">Was kann die App?</h2>
                    <div class="text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed
                        diam nonumy eirmod tempor invidunt ut labore et dolore magna
                        aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo. </div>
                </div>
                <div id="about-content-right">
                    <img src="/images/korgi_red.svg">
                </div>
            </div>
        </div>
        <div id="footer">
            <div id="footer-content">
                <a class="footer-link">Impressum</a>
                <a class="footer-link">Datenschutzerklärung</a>
                <div class="footer-cr">© 2021 KORGI</div>
            </div>
        </div>
    </div>
</template>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Comfortaa:wght@700&display=swap");

#welcome {
    font-family: "Montserrat", sans-serif;
}

#navigation {
    z-index: 10;
    background-color: #ffffff;
    width: 100%;
    position: fixed;
    height: 7vh;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    padding-left: 15%;
    padding-right: 15%;
    -webkit-box-shadow: 5px 5px 40px 0px rgba(44, 47, 51, 0.1);
    -moz-box-shadow: 5px 5px 40px 0px rgba(44, 47, 51, 0.1);
    box-shadow: 5px 5px 40px 0px rgba(44, 47, 51, 0.1);
}

#navigation #logo {

}

#navigation #link-container {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
}

#navigation #link-container a {
    margin-left: 1.5vh;
    margin-right: 1.5vh;
    font-weight: 600;
    cursor: pointer;
}

#logo {
    width: 18vh;
}

#header {
    height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

#app-preview {
    width: 100%;
}

#header #header-content {
    display: flex;
    flex-direction: row;
    justify-content: space-around;
    width: 90%;
    align-self: center;
}

#header-content-left {
    width: 40%;
    display: flex;
    flex-direction: column;
}

#header-content-left .separator {
    width: 55%;
    height: 6px;
    background-color: var(--primary);
    margin-top: 6vh;
    margin-bottom: 6vh;
}

#header-content-left .text {
    font-size: 1.5rem;
    width: 80%;
}

#header-content-left .btn {
    margin-top: 6vh;
    width: fit-content;
    align-self: center;
    font-size: 1.5rem;
    height: 4rem;
    border-radius: 2rem;
}


#header-content-right {
    width: 50%;
}

#login {
    height: 100vh;
    display: flex;
    background-color: var(--primary);
    flex-direction: column;
    align-items: flex-start;
    justify-content: flex-start;
}
 #login-content {
     width: 90%;
     display: flex;
     justify-content: space-around;
     align-items: center;
     flex-direction: row;
     align-self: center;
 }

 #register {
     width: 30%;
     display: flex;
     flex-direction: column;
     justify-content: center;
     align-items: center;
 }

 #logo-msg {
     margin-bottom: 4vh;
 }

 #register-info {
     color: white;
     font-size: 1.5rem;
     font-weight: 800;
     text-align: center;
     margin-bottom: 4vh;
 }

 #register .btn {
     width: fit-content;
     font-size: 1.5rem;
     height: 4rem;
     border-radius: 2rem;
 }

 .separator {
     height: 60vh;
     background-color: white;
     width: 6px;
     border-radius: 10px;
 }

#about {
    height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: flex-start;
}

#about-content {
    width: 90%;
    display: flex;
    flex-direction: row;
    justify-content: space-around;
    align-self: center;
    align-items: center;
}

#about-content-left {
    width: 40%;
}

#about-content-left .text {
    font-size: 1rem;
}

#about-content-left .section-headline {
    font-size: 1.5rem;
    font-weight: 600;
    margin-top: 4vh;
    margin-bottom: 1vh;
}

#about-content-right {
    width: 40%;
    display: flex;
    justify-content: center;
}

#about-content-right img {
    width: 60vh;
}

#footer {
    height: 10vh;
    background-color: var(--primary);
    display: flex;
    justify-content: flex-start;
}

#footer-content {
    display: flex;
    flex-direction: row;
    justify-content: flex-start;
    align-items: center;
    width: 100%;
}

.footer-link {
    font-size: 1.2rem;
    color: var(--white);
    margin-left: 6vh;
    text-decoration: underline;
    font-weight: 600;
    cursor: pointer;
}

.footer-cr {
    margin-left: auto;
    font-size: 1.2rem;
    color: var(--white);
    margin-right: 6vh;
}

.headline {
    color: var(--secondary);
    font-size: 3rem;
    margin-left: 10vh;
    margin-top: 10vh;
    margin-bottom: 5vh;
}

.slogan {
    font-size: 4.5rem;
    font-weight: 500;
    line-height: 5rem;
}

/*idc über das da unten*/

/*#page-wrapper {*/
/*    width: 100vw;*/
/*    height: 100vh;*/
/*}*/

/*body p {*/
/*    font-family: "Montserrat", sans-serif;*/
/*    font-weight: 500;*/
/*    line-height: 2.5em;*/
/*    font-size: 2em;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    body p {*/
/*        line-height: 1.7em;*/
/*        font-size: 1.2em;*/
/*    }*/
/*}*/

/*body a {*/
/*    text-decoration: none;*/
/*    transition: color 0.25s ease;*/
/*}*/

/*body a:hover,*/
/*body a:focus {*/
/*    color: #ffcb8e;*/
/*}*/

/*body li {*/
/*    font-family: "Montserrat", sans-serif;*/
/*    font-weight: 500;*/
/*    line-height: 2.5em;*/
/*    font-size: 2em;*/
/*    margin-left: 3em;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    body li {*/
/*        line-height: 1.7em;*/
/*        font-size: 1.2em;*/
/*    }*/
/*}*/

/*body h1 {*/
/*    font-family: "Comfortaa", sans-serif;*/
/*    font-weight: 700;*/
/*    font-size: 20em;*/
/*}*/

/*body h2 {*/
/*    font-family: "Montserrat", sans-serif;*/
/*    font-weight: 700;*/
/*    font-size: 5em;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    body h2 {*/
/*        font-size: 3em;*/
/*    }*/
/*}*/

/*body h3 {*/
/*    font-family: "Montserrat", sans-serif;*/
/*    font-size: 3.5em;*/
/*    font-weight: 700;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    body h3 {*/
/*        font-size: 2em;*/
/*    }*/
/*}*/

/*body h4 {*/
/*    font-family: "Montserrat", sans-serif;*/
/*    color: #ffa88e;*/
/*    font-weight: 700;*/
/*    font-size: 2.5em;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    body h4 {*/
/*        font-size: 1.5em;*/
/*    }*/
/*}*/

/*body .primaryText {*/
/*    color: #ffa88e;*/
/*}*/

/*body .accentText {*/
/*    color: #ffcb8e;*/
/*}*/

/*body .whiteText {*/
/*    color: #ffffff;*/
/*}*/

/*body .darkText {*/
/*    color: #2c2f33;*/
/*}*/

/*body #navigation {*/
/*    z-index: 10;*/
/*    background-color: #ffffff;*/
/*    width: 100%;*/
/*    position: fixed;*/
/*    height: 7vh;*/
/*    display: flex;*/
/*    flex-direction: row;*/
/*    justify-content: space-between;*/
/*    align-items: center;*/
/*    padding-left: 15%;*/
/*    padding-right: 15%;*/
/*    -webkit-box-shadow: 5px 5px 40px 0px rgba(44, 47, 51, 0.1);*/
/*    -moz-box-shadow: 5px 5px 40px 0px rgba(44, 47, 51, 0.1);*/
/*    box-shadow: 5px 5px 40px 0px rgba(44, 47, 51, 0.1);*/
/*}*/

/*body #navigation #hamburgerContainer {*/
/*    color: red;*/
/*    height: 4em;*/
/*    width: 4em;*/
/*    position: relative;*/
/*    cursor: pointer;*/
/*}*/

/*body #navigation #hamburgerContainer #hamburger,*/
/*body #navigation #hamburgerContainer #hamburger:before,*/
/*body #navigation #hamburgerContainer #hamburger:after {*/
/*    content: "";*/
/*    position: absolute;*/
/*    height: 0.5em;*/
/*    width: 4em;*/
/*    background: #2c2f33;*/
/*    transition: all 0.25s ease;*/
/*    border-radius: 0.2em;*/
/*}*/

/*body #navigation #hamburgerContainer #hamburger {*/
/*    top: 1.8em;*/
/*}*/

/*body #navigation #hamburgerContainer #hamburger:before {*/
/*    top: -1em;*/
/*}*/

/*body #navigation #hamburgerContainer #hamburger:after {*/
/*    top: 1em;*/
/*}*/

/*body #navigation #hamburgerContainer .hamburgerActive#hamburger {*/
/*    background: transparent;*/
/*    transform: rotate(-135deg);*/
/*}*/

/*body #navigation #hamburgerContainer .hamburgerActive#hamburger:before,*/
/*body #navigation #hamburgerContainer .hamburgerActive#hamburger:after {*/
/*    top: 0;*/
/*}*/

/*body #navigation #hamburgerContainer .hamburgerActive#hamburger:before {*/
/*    transform: rotate(90deg);*/
/*}*/

/*@media (min-width: 992px) {*/
/*    body #navigation #hamburgerContainer {*/
/*        display: none;*/
/*    }*/
/*}*/

/*body #navigation #linkContainer {*/
/*    display: none;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    body #navigation #linkContainer {*/
/*        display: flex;*/
/*    }*/
/*}*/

/*body #navigation #linkContainer a {*/
/*    font-family: "Montserrat", sans-serif;*/
/*    font-weight: 500;*/
/*    font-size: 1.2em;*/
/*    padding-left: 1.5em;*/
/*}*/

/*body .logo {*/
/*    font-family: "Comfortaa", sans-serif;*/
/*    font-weight: 700;*/
/*    font-size: 4em;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    body .logo {*/
/*        font-size: 2.5em;*/
/*    }*/
/*}*/

/*body #navigationContainer {*/
/*    display: flex;*/
/*}*/

/*#sliderBackground {*/
/*    position: fixed;*/
/*    width: 100vw;*/
/*    height: 100vh;*/
/*    z-index: -1;*/
/*    transition: all 0.25s ease;*/
/*}*/

/*#sliderBackground.sliderActive {*/
/*    z-index: 3;*/
/*}*/

/*#slider {*/
/*    -webkit-box-shadow: 5px 5px 40px -11px rgba(44, 47, 51, 0.61);*/
/*    -moz-box-shadow: 5px 5px 40px -11px rgba(44, 47, 51, 0.61);*/
/*    box-shadow: 5px 5px 40px -11px rgba(44, 47, 51, 0.61);*/
/*    display: flex;*/
/*    position: fixed;*/
/*    width: 80vw;*/
/*    height: 100vh;*/
/*    left: 100vw;*/
/*    z-index: 5;*/
/*    background-color: #ffffff;*/
/*    transition: all 0.25s ease;*/
/*    align-items: center;*/
/*    justify-content: center;*/
/*}*/

/*#slider #sliderContainer {*/
/*    display: flex;*/
/*    flex-direction: column;*/
/*    align-items: center;*/
/*    justify-content: space-between;*/
/*    height: 40%;*/
/*}*/

/*#slider #sliderContainer a {*/
/*    font-family: "Montserrat", sans-serif;*/
/*    font-weight: 500;*/
/*    font-size: 2em;*/
/*}*/

/*#slider.sliderActive {*/
/*    transform: translateX(-80vw);*/
/*}*/

/*#header {*/
/*    height: 100%;*/
/*    display: flex;*/
/*    justify-content: center;*/
/*    background-color: #ffffff;*/
/*    align-items: center;*/
/*}*/

/*#idea {*/
/*    position: relative;*/
/*    height: 100vh;*/
/*    width: 100%;*/
/*    background-color: #ffa88e;*/
/*    display: flex;*/
/*    flex-direction: column;*/
/*    align-items: center;*/
/*    justify-content: space-evenly;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    #idea {*/
/*        position: relative;*/
/*        display: block;*/
/*    }*/
/*}*/

/*@media (min-width: 992px) {*/
/*    #idea #ideaMobileHeader {*/
/*        display: none;*/
/*    }*/
/*}*/

/*#idea #ideaTextContainer {*/
/*    -webkit-box-shadow: 5px 5px 40px -11px rgba(44, 47, 51, 0.61);*/
/*    -moz-box-shadow: 5px 5px 40px -11px rgba(44, 47, 51, 0.61);*/
/*    box-shadow: 5px 5px 40px -11px rgba(44, 47, 51, 0.61);*/
/*    display: flex;*/
/*    flex-direction: column;*/
/*    justify-content: center;*/
/*    background-color: #ffffff;*/
/*    border-radius: 3em;*/
/*    width: 90%;*/
/*    height: 70%;*/
/*    padding: 5%;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    #idea #ideaTextContainer {*/
/*        position: relative;*/
/*        left: 10%;*/
/*        top: 15%;*/
/*        padding: 5vh;*/
/*        width: 60%;*/
/*        height: 70%;*/
/*        padding-right: 20%;*/
/*    }*/
/*}*/

/*#idea #ideaTextContainer #ideaHeader {*/
/*    display: none;*/
/*    justify-self: flex-start;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    #idea #ideaTextContainer #ideaHeader {*/
/*        display: flex;*/
/*    }*/
/*}*/

/*#idea #ideaImgContainer {*/
/*    display: none;*/
/*    width: 40%;*/
/*    height: 60%;*/
/*    position: relative;*/
/*    right: -50%;*/
/*    top: -50%;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    #idea #ideaImgContainer {*/
/*        display: block;*/
/*    }*/
/*}*/

/*#idea #ideaImgContainer img {*/
/*    width: 100%;*/
/*    height: 100%;*/
/*}*/

/*#team {*/
/*    background-color: #ffffff;*/
/*    height: 100vh;*/
/*    width: 100%;*/
/*    display: flex;*/
/*    flex-direction: column;*/
/*    align-items: center;*/
/*    justify-content: space-evenly;*/
/*}*/

/*#team #teamContainer {*/
/*    display: flex;*/
/*    flex-direction: column;*/
/*    align-items: center;*/
/*    width: 90%;*/
/*    height: 70%;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    #team #teamContainer {*/
/*        width: 70%;*/
/*        height: 50%;*/
/*        flex-direction: row;*/
/*        justify-content: space-between;*/
/*    }*/
/*}*/

/*#team #teamContainer .personContainerRow {*/
/*    width: 100%;*/
/*    height: 40%;*/
/*    display: flex;*/
/*    flex-direction: row;*/
/*    align-items: center;*/
/*    justify-content: space-around;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    #team #teamContainer .personContainerRow {*/
/*        width: 50%;*/
/*        height: 100%;*/
/*    }*/
/*}*/

/*#team #teamContainer .personContainerRow .personContainer {*/
/*    display: flex;*/
/*    flex-direction: column;*/
/*    justify-content: center;*/
/*    align-items: center;*/
/*    width: 30%;*/
/*    height: 100%;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    #team #teamContainer .personContainerRow .personContainer {*/
/*        width: 36%;*/
/*    }*/
/*}*/

/*#team #teamContainer .personContainerRow .personContainer .personSvg {*/
/*    width: 100%;*/
/*    border-radius: 50%;*/
/*    height: auto;*/
/*}*/

/*#team #teamContainer .personContainerRow .personContainer .personText {*/
/*    height: 60%;*/
/*    display: flex;*/
/*    flex-direction: column;*/
/*    align-items: center;*/
/*    justify-content: center;*/
/*}*/

/*#downloads {*/
/*    background-color: #ffa88e;*/
/*    height: 100vh;*/
/*    width: 100%;*/
/*    display: flex;*/
/*    flex-direction: column;*/
/*    align-items: center;*/
/*    justify-content: space-evenly;*/
/*}*/

/*#downloads #downloadContainer {*/
/*    display: flex;*/
/*    flex-direction: column;*/
/*    justify-content: space-between;*/
/*    width: 90%;*/
/*    height: 70%;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    #downloads #downloadContainer {*/
/*        flex-direction: row;*/
/*        width: 70%;*/
/*        height: 50%;*/
/*    }*/
/*}*/

/*#downloads #downloadContainer .downloadCard {*/
/*    background-color: #ffffff;*/
/*    display: flex;*/
/*    flex-direction: row;*/
/*    align-items: center;*/
/*    justify-content: space-evenly;*/
/*    width: 100%;*/
/*    height: 25%;*/
/*    border-radius: 3em;*/
/*    -webkit-box-shadow: 5px 5px 40px -11px rgba(44, 47, 51, 0.61);*/
/*    -moz-box-shadow: 5px 5px 40px -11px rgba(44, 47, 51, 0.61);*/
/*    box-shadow: 5px 5px 40px -11px rgba(44, 47, 51, 0.61);*/
/*    transition: all 0.25s ease;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    #downloads #downloadContainer .downloadCard {*/
/*        height: 100%;*/
/*        width: 25%;*/
/*        flex-direction: column;*/
/*    }*/
/*}*/

/*#downloads #downloadContainer .downloadCard i {*/
/*    font-size: 8em;*/
/*    color: #2c2f33;*/
/*    transition: color 0.25s ease;*/
/*}*/

/*#downloads #downloadContainer .downloadCard a {*/
/*    font-family: "Montserrat", sans-serif;*/
/*    font-weight: 700;*/
/*    font-size: 2em;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    #downloads #downloadContainer .downloadCard a {*/
/*        line-height: 1.7em;*/
/*        font-size: 1.2em;*/
/*    }*/
/*}*/

/*#downloads #downloadContainer .downloadCard:hover,*/
/*#downloads #downloadContainer .downloadCard:focus-within {*/
/*    cursor: pointer;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    #downloads #downloadContainer .downloadCard:hover,*/
/*    #downloads #downloadContainer .downloadCard:focus-within {*/
/*        transform: scale(1.03);*/
/*        -webkit-box-shadow: 6px 6px 45px -11px rgba(44, 47, 51, 0.8);*/
/*        -moz-box-shadow: 6px 6px 45px -11px rgba(44, 47, 51, 0.8);*/
/*        box-shadow: 6px 6px 45px -11px rgba(44, 47, 51, 0.8);*/
/*    }*/
/*}*/

/*#downloads #downloadContainer .downloadCard:hover i,*/
/*#downloads #downloadContainer .downloadCard:focus-within i {*/
/*    color: #ffcb8e;*/
/*}*/

/*#downloads #downloadContainer .downloadCard:hover a,*/
/*#downloads #downloadContainer .downloadCard:focus-within a {*/
/*    color: #ffcb8e;*/
/*}*/

/*#sponsors {*/
/*    background-color: #ffffff;*/
/*    height: 100vh;*/
/*    width: 100%;*/
/*    display: flex;*/
/*    flex-direction: column;*/
/*    align-items: center;*/
/*    justify-content: space-evenly;*/
/*}*/

/*#sponsors #sponsorContainer {*/
/*    display: flex;*/
/*    flex-direction: column;*/
/*    justify-content: space-evenly;*/
/*    align-items: center;*/
/*    width: 90%;*/
/*    height: 70%;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    #sponsors #sponsorContainer {*/
/*        justify-content: space-between;*/
/*        flex-direction: row;*/
/*        width: 70%;*/
/*        height: 50%;*/
/*    }*/
/*}*/

/*#sponsors #sponsorContainer .sponsorSvgContainer {*/
/*    width: 80%;*/
/*    height: auto;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    #sponsors #sponsorContainer .sponsorSvgContainer {*/
/*        width: 40%;*/
/*    }*/
/*}*/

/*#sponsors #sponsorContainer .sponsorSvgContainer .sponsorSvg {*/
/*    width: 100%;*/
/*    height: 100%;*/
/*}*/

/*#contact {*/
/*    background-color: #ffa88e;*/
/*    height: 100vh;*/
/*    width: 100%;*/
/*    display: flex;*/
/*    flex-direction: column;*/
/*    align-items: center;*/
/*    justify-content: space-evenly;*/
/*}*/

/*#contact #contactContainer {*/
/*    -webkit-box-shadow: 5px 5px 40px -11px rgba(44, 47, 51, 0.61);*/
/*    -moz-box-shadow: 5px 5px 40px -11px rgba(44, 47, 51, 0.61);*/
/*    box-shadow: 5px 5px 40px -11px rgba(44, 47, 51, 0.61);*/
/*    background-color: #ffffff;*/
/*    border-radius: 3em;*/
/*    width: 90%;*/
/*    height: 80%;*/
/*    display: flex;*/
/*    flex-direction: column;*/
/*    align-items: center;*/
/*    justify-content: space-between;*/
/*    padding: 5%;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    #contact #contactContainer {*/
/*        width: 60vh;*/
/*        height: 80vh;*/
/*        padding: 5vh;*/
/*    }*/
/*}*/

/*#contact #contactContainer #submit {*/
/*    height: 3.5em;*/
/*    width: 100%;*/
/*    background-color: #ffcb8e;*/
/*    border-radius: 3em;*/
/*    font-family: "Montserrat", sans-serif;*/
/*    font-weight: 700;*/
/*    font-size: 2em;*/
/*    color: #ffffff;*/
/*    outline: 0;*/
/*    border: none;*/
/*    transition: background-color 0.25s ease;*/
/*    webkit-appearance: none;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    #contact #contactContainer #submit {*/
/*        height: 3em;*/
/*        font-size: 1.2em;*/
/*    }*/
/*}*/

/*#contact #contactContainer #submit:hover {*/
/*    cursor: pointer;*/
/*    background-color: #ffa88e;*/
/*}*/

/*#contact #contactContainer #submit:focus {*/
/*    cursor: pointer;*/
/*    background-color: #ffa88e;*/
/*}*/

/*#contact #contactContainer #inputGroup {*/
/*    height: 80%;*/
/*    width: 100%;*/
/*    display: flex;*/
/*    flex-direction: column;*/
/*    align-items: center;*/
/*    justify-content: space-between;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    #contact #contactContainer #inputGroup {*/
/*        height: 50vh;*/
/*    }*/
/*}*/

/*#contact #contactContainer #inputGroup textarea {*/
/*    flex-grow: 1;*/
/*    width: 100%;*/
/*    background-color: #e3e3e3;*/
/*    border-radius: 1.5em;*/
/*    padding-top: 0.9em;*/
/*    padding-left: 5%;*/
/*    padding-right: 5%;*/
/*    font-family: "Montserrat", sans-serif;*/
/*    font-weight: 700;*/
/*    font-size: 2em;*/
/*    color: #2c2f33;*/
/*    border: none;*/
/*    outline: 0;*/
/*    resize: none;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    #contact #contactContainer #inputGroup textarea {*/
/*        font-size: 1.2em;*/
/*        height: 15em;*/
/*    }*/
/*}*/

/*#contact #contactContainer #inputGroup .inputContainer {*/
/*    height: 5em;*/
/*    width: 100%;*/
/*    background-color: #e3e3e3;*/
/*    border-radius: 1.5em;*/
/*    display: flex;*/
/*    flex-direction: row;*/
/*    align-items: center;*/
/*    justify-content: space-evenly;*/
/*    margin-bottom: 2.5em;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    #contact #contactContainer #inputGroup .inputContainer {*/
/*        height: 3em;*/
/*    }*/
/*}*/

/*#contact #contactContainer #inputGroup .inputContainer i {*/
/*    color: #2c2f33;*/
/*    font-size: 2.5em;*/
/*    transition: color 0.25s ease;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    #contact #contactContainer #inputGroup .inputContainer i {*/
/*        font-size: 1.5em;*/
/*    }*/
/*}*/

/*#contact #contactContainer #inputGroup .inputContainer input {*/
/*    height: 100%;*/
/*    width: 80%;*/
/*    background-color: #e3e3e3;*/
/*    border: none;*/
/*    font-family: "Montserrat", sans-serif;*/
/*    font-weight: 700;*/
/*    font-size: 2em;*/
/*    color: #2c2f33;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    #contact #contactContainer #inputGroup .inputContainer input {*/
/*        font-size: 1.2em;*/
/*    }*/
/*}*/

/*#contact #contactContainer #inputGroup .inputContainer input:focus {*/
/*    outline: 0;*/
/*}*/

/*#contact #contactContainer #inputGroup .inputContainer:focus-within i {*/
/*    color: #ffcb8e;*/
/*}*/

/*#impressum {*/
/*    background-color: #ffa88e;*/
/*    height: 100vh;*/
/*    width: 100%;*/
/*    display: flex;*/
/*    flex-direction: column;*/
/*    align-items: center;*/
/*    justify-content: space-evenly;*/
/*}*/

/*#impressum #impressumContainer {*/
/*    display: flex;*/
/*    flex-direction: column;*/
/*    justify-content: space-evenly;*/
/*    width: 90%;*/
/*    height: 70%;*/
/*    background-color: #ffffff;*/
/*    padding: 5%;*/
/*    border-radius: 3em;*/
/*    -webkit-box-shadow: 5px 5px 40px -11px rgba(44, 47, 51, 0.61);*/
/*    -moz-box-shadow: 5px 5px 40px -11px rgba(44, 47, 51, 0.61);*/
/*    box-shadow: 5px 5px 40px -11px rgba(44, 47, 51, 0.61);*/
/*}*/

/*@media (min-width: 992px) {*/
/*    #impressum #impressumContainer {*/
/*        justify-content: space-between;*/
/*        flex-direction: row;*/
/*        width: 70%;*/
/*        height: 60%;*/
/*        padding: 7vh;*/
/*    }*/
/*}*/

/*#impressum #impressumContainer .impressumInformationContainer {*/
/*    width: 100%;*/
/*    height: 25%;*/
/*    display: flex;*/
/*    flex-direction: row;*/
/*    justify-content: space-around;*/
/*    align-items: center;*/
/*    padding-left: 5%;*/
/*    padding-right: 5%;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    #impressum #impressumContainer .impressumInformationContainer {*/
/*        width: 25%;*/
/*        height: 100%;*/
/*        flex-direction: column;*/
/*        justify-content: space-evenly;*/
/*    }*/
/*}*/

/*#impressum #impressumContainer .impressumInformationContainer i {*/
/*    color: #ffcb8e;*/
/*    font-size: 10em;*/
/*}*/

/*#impressum #impressumContainer .impressumInformationContainer div {*/
/*    flex-grow: 1;*/
/*    display: flex;*/
/*    flex-direction: column;*/
/*    align-items: flex-end;*/
/*    justify-content: center;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    #impressum #impressumContainer .impressumInformationContainer div {*/
/*        flex-grow: 0;*/
/*        width: 100%;*/
/*        height: 50%;*/
/*        align-items: center;*/
/*    }*/
/*}*/

/*#impressum #impressumContainer .impressumInformationContainer div div {*/
/*    width: 100%;*/
/*    display: flex;*/
/*    flex-direction: column;*/
/*    align-items: flex-end;*/
/*    justify-content: flex-start;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    #impressum #impressumContainer .impressumInformationContainer div div {*/
/*        align-items: center;*/
/*        height: 40%;*/
/*    }*/
/*}*/

/*#impressum #impressumContainer .impressumInformationContainer div div a {*/
/*    font-family: "Montserrat", sans-serif;*/
/*    font-size: 2em;*/
/*    font-weight: 500;*/
/*    color: #2c2f33;*/
/*    text-decoration: none;*/
/*    transition: color 0.25s ease;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    #impressum #impressumContainer .impressumInformationContainer div div a {*/
/*        line-height: 1.7em;*/
/*        font-size: 1.2em;*/
/*    }*/
/*}*/

/*#impressum #impressumContainer .impressumInformationContainer div div a:active,*/
/*#impressum #impressumContainer .impressumInformationContainer div div a:focus {*/
/*    color: #ffcb8e;*/
/*}*/

/*#privacy {*/
/*    background-color: #ffa88e;*/
/*    width: 100%;*/
/*    display: flex;*/
/*    flex-direction: column;*/
/*    align-items: center;*/
/*    justify-content: space-evenly;*/
/*    padding: 5%;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    #privacy {*/
/*        padding: 10vh;*/
/*    }*/
/*}*/

/*#privacy h2 {*/
/*    margin-top: calc(7vh + 5%);*/
/*    margin-bottom: 10%;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    #privacy h2 {*/
/*        margin-top: 5vh;*/
/*        margin-bottom: 10vh;*/
/*    }*/
/*}*/

/*#privacy #privacyContainer {*/
/*    width: 100%;*/
/*    background-color: #ffffff;*/
/*    padding: 5%;*/
/*    padding-bottom: 0;*/
/*    border-radius: 3em;*/
/*    -webkit-box-shadow: 5px 5px 40px -11px rgba(44, 47, 51, 0.61);*/
/*    -moz-box-shadow: 5px 5px 40px -11px rgba(44, 47, 51, 0.61);*/
/*    box-shadow: 5px 5px 40px -11px rgba(44, 47, 51, 0.61);*/
/*}*/

/*@media (min-width: 992px) {*/
/*    #privacy #privacyContainer {*/
/*        width: 70%;*/
/*        padding: 5vh;*/
/*    }*/
/*}*/

/*#privacy #privacyContainer section {*/
/*    margin-bottom: 5%;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    #privacy #privacyContainer section {*/
/*        margin-bottom: 5vh;*/
/*    }*/
/*}*/

/*#privacy #privacyContainer section p {*/
/*    margin-bottom: 1em;*/
/*}*/

/*@media (max-width: 991px) {*/
/*    #privacy #privacyContainer section p {*/
/*        font-size: 1em;*/
/*        line-height: 3em;*/
/*    }*/
/*}*/

/*@media (max-width: 991px) {*/
/*    #privacy #privacyContainer section li {*/
/*        font-size: 1em;*/
/*        line-height: 3em;*/
/*    }*/
/*}*/

/*#privacy #privacyContainer section h3 {*/
/*    color: #ffcb8e;*/
/*    margin-bottom: 2.5%;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    #privacy #privacyContainer section h3 {*/
/*        margin-bottom: 2.5vh;*/
/*    }*/
/*}*/

/*#footer {*/
/*    display: flex;*/
/*    justify-content: space-evenly;*/
/*    align-items: center;*/
/*    flex-direction: column;*/
/*    background-color: #2c2f33;*/
/*    color: #ffffff;*/
/*    height: 10vh;*/
/*    width: 100%;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    #footer {*/
/*        padding-left: 15%;*/
/*        padding-right: 15%;*/
/*        flex-direction: row;*/
/*        justify-content: space-between;*/
/*    }*/
/*}*/

/*#footer p {*/
/*    line-height: normal;*/
/*}*/

/*#footer #footer_right {*/
/*    display: flex;*/
/*    flex-direction: row;*/
/*    align-items: center;*/
/*    justify-content: space-evenly;*/
/*    width: 80%;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    #footer #footer_right {*/
/*        justify-content: space-between;*/
/*        width: 30%;*/
/*    }*/
/*}*/

/*#footer #footer_right a {*/
/*    font-family: "Montserrat", sans-serif;*/
/*    font-weight: 500;*/
/*    font-size: 2em;*/
/*}*/

/*@media (min-width: 992px) {*/
/*    #footer #footer_right a {*/
/*        line-height: 1.7em;*/
/*        font-size: 1.2em;*/
/*    }*/
/*}*/

/*body.disableScrolling {*/
/*    overflow: hidden;*/
/*}*/

/*.bg-gray-100 {*/
/*    background-color: #f7fafc;*/
/*    background-color: rgba(247, 250, 252, var(--tw-bg-opacity));*/
/*}*/

/*.border-gray-200 {*/
/*    border-color: #edf2f7;*/
/*    border-color: rgba(237, 242, 247, var(--tw-border-opacity));*/
/*}*/

/*.text-gray-400 {*/
/*    color: #cbd5e0;*/
/*    color: rgba(203, 213, 224, var(--tw-text-opacity));*/
/*}*/

/*.text-gray-500 {*/
/*    color: #a0aec0;*/
/*    color: rgba(160, 174, 192, var(--tw-text-opacity));*/
/*}*/

/*.text-gray-600 {*/
/*    color: #718096;*/
/*    color: rgba(113, 128, 150, var(--tw-text-opacity));*/
/*}*/

/*.text-gray-700 {*/
/*    color: #4a5568;*/
/*    color: rgba(74, 85, 104, var(--tw-text-opacity));*/
/*}*/

/*.text-gray-900 {*/
/*    color: #1a202c;*/
/*    color: rgba(26, 32, 44, var(--tw-text-opacity));*/
/*}*/

/*@media (prefers-color-scheme: dark) {*/
/*    .dark\:bg-gray-800 {*/
/*        background-color: #2d3748;*/
/*        background-color: rgba(45, 55, 72, var(--tw-bg-opacity));*/
/*    }*/

/*    .dark\:bg-gray-900 {*/
/*        background-color: #1a202c;*/
/*        background-color: rgba(26, 32, 44, var(--tw-bg-opacity));*/
/*    }*/

/*    .dark\:border-gray-700 {*/
/*        border-color: #4a5568;*/
/*        border-color: rgba(74, 85, 104, var(--tw-border-opacity));*/
/*    }*/

/*    .dark\:text-white {*/
/*        color: #fff;*/
/*        color: rgba(255, 255, 255, var(--tw-text-opacity));*/
/*    }*/

/*    .dark\:text-gray-400 {*/
/*        color: #cbd5e0;*/
/*        color: rgba(203, 213, 224, var(--tw-text-opacity));*/
/*    }*/
/*}*/
</style>

<script>
import Login from "@/Pages/Login";
export default {
    components: {Login},
    props: {
        canLogin: Boolean,
        canRegister: Boolean,
        laravelVersion: String,
        phpVersion: String,
    },
    methods: {
        scrollToId(id) {
            document.getElementById(id).scrollIntoView({
                behavior: "smooth"
            });
        }
    }
};
</script>
