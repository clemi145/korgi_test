<template>
    <div id="verify-email">
        <inertia-link id="logo" :href="route('home')">
            <img src="/images/korgi_yellow_only.svg" alt="Logo">
        </inertia-link>
        <div id="form-container">
            <div id="verify-email-content">
                <h2 id="greeting">Hey!</h2>
                <div class="text">
                    Wir freuen uns, dass du auch dabei bist! Du musst nur noch den Link in der E-Mail anklicken, welche
                    wir dir soeben geschickt haben, und schon kann es losgehen! Falls du die E-Mail nicht erhalten haben
                    solltest, senden wir dir gerne noch eine.
                </div>

                <div v-if="verificationLinkSent">
                    Ein neuer Link wurde an die E-Mail Adresse, welche du bei der Registrierung angegeben hast,
                    verschickt.
                </div>

                <form id="button-container" @submit.prevent="submit">
                    <jet-button class="btn secondary-background" :disabled="form.processing">
                        E-Mail erneut senden
                    </jet-button>

                    <inertia-link :href="route('logout')" method="post" as="button"
                                  class="logout-link">Abmelden
                    </inertia-link>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo'
import JetButton from '@/Jetstream/Button'

export default {
    components: {
        JetAuthenticationCard,
        JetAuthenticationCardLogo,
        JetButton,
    },

    props: {
        status: String
    },

    data() {
        return {
            form: this.$inertia.form()
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('verification.send'))
        },
    },

    computed: {
        verificationLinkSent() {
            return this.status === 'verification-link-sent';
        }
    }
}
</script>

<style scoped>
#verify-email {
    background-color: #ffa88e;
    width: 100%;
    height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: center;
}

::selection {
    background-color: var(--secondary);
    color: white;
}

#logo {
    width: 18vh;
    align-self: flex-start;
    margin-top: 4vh;
    margin-left: 4vh;
}

#greeting {
    color: #000000;
    text-align: center;
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 4vh;
}

#verify-email-content {
    background-color: #ffffff;
    border-radius: 30px;
    padding: 4vh;
    width: 25%;
}

#form-container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 80%;
}

.text {
    margin-bottom: 4vh;
}

.btn {
    justify-content: center;
    width: fit-content;
    align-self: center;
}

#button-container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.logout-link {
    align-self: flex-start;
    text-decoration: underline;
    margin-top: 2vh;
}

.logout-link:focus {
    outline: 0;
}

.btn:focus  {
    outline: 0;
}


@media (max-width: 576px) {
    .btn {
        height: 3rem;
        font-size: 1rem;
    }

    #verify-email-content {
        width: 85%;
    }
}
</style>
