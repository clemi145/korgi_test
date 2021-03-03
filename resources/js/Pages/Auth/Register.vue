<template>
    <div id="registration">
        <inertia-link id="logo" :href="route('home')">
            <img src="/images/korgi_yellow_only.svg" alt="Logo">
        </inertia-link>
        <jet-validation-errors id="error"/>

        <form @submit.prevent="submit" id="registration-form">
            <h2 id="greeting">Registrierung</h2>

            <div id="input-container">
                <jet-input id="name" type="text" class="input" v-model="form.name" required autofocus
                           autocomplete="name"
                           placeholder="Name"/>

                <jet-input id="email" type="email" class="input" v-model="form.email" required placeholder="E-Mail"/>

                <jet-input id="password" type="password" class="input" v-model="form.password" required
                           autocomplete="new-password" placeholder="Passwort"/>

                <jet-input id="password_confirmation" type="password" class="input" v-model="form.password_confirmation"
                           required autocomplete="new-password" placeholder="Passwort wiederholen"/>
            </div>

            <div class="mt-4" v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature">
                <jet-label for="terms">
                    <div class="flex items-center">
                        <jet-checkbox name="terms" id="terms" v-model="form.terms"/>

                        <div class="ml-2">
                            I agree to the <a target="_blank" :href="route('terms.show')"
                                              class="underline text-sm text-gray-600 hover:text-gray-900">Terms of
                            Service</a> and <a target="_blank" :href="route('policy.show')"
                                               class="underline text-sm text-gray-600 hover:text-gray-900">Privacy
                            Policy</a>
                        </div>
                    </div>
                </jet-label>
            </div>

            <div id="button-container">

                <inertia-link class="btn warn-background" :href="route('home')">
                    Abbrechen
                </inertia-link>


                <jet-button class="btn secondary-background"
                            :disabled="form.processing">
                    Registrieren
                </jet-button>
            </div>
        </form>
        <div id="link-container">
            <a>Impressum</a>
            <a>Datenschutzerklärung</a>
        </div>
    </div>
</template>

<script>
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo'
import JetButton from '@/Jetstream/Button'
import JetInput from '@/Jetstream/Input'
import JetCheckbox from "@/Jetstream/Checkbox";
import JetLabel from '@/Jetstream/Label'
import JetValidationErrors from '@/Jetstream/ValidationErrors'

export default {
    components: {
        JetAuthenticationCard,
        JetAuthenticationCardLogo,
        JetButton,
        JetInput,
        JetCheckbox,
        JetLabel,
        JetValidationErrors
    },

    data() {
        return {
            form: this.$inertia.form({
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                terms: false,
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('register'), {
                onFinish: () => this.form.reset('password', 'password_confirmation'),
            })
        }
    }
}
</script>
<style scoped>

::selection {
    background-color: #ffcb8e;
    color: white;
}

img {
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

#logo {
    width: 18vh;
    align-self: flex-start;
    margin-top: 4vh;
    margin-left: 4vh;
}

#registration {
    font-family: "Montserrat", sans-serif;
    display: flex;
    flex-direction: column;
    align-items: center;
    background-color: #ffa88e;
    height: 100vh;
    justify-content: space-between;
}

#link-container {
    display: flex;
    flex-direction: row;
    width: 30%;
    justify-content: flex-start;
    align-self: flex-start;
    margin-bottom: 4vh;
    margin-left: 4vh;
}

#link-container a {
    color: white;
    margin-right: 4vh;
    font-size: 1.2rem;
    text-decoration: underline;
    font-weight: 500;
    cursor: pointer;
}

#registration-form {
    font-family: "Montserrat", sans-serif;
    background-color: #FFFFFF;
    border-radius: 30px;
    padding: 4vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 25%;
    -webkit-box-shadow: 5px 5px 40px 0px rgba(92, 86, 86, 0.3);
    -moz-box-shadow: 5px 5px 40px 0px rgba(92, 86, 86, 0.3);
    box-shadow: 5px 5px 40px 0px rgba(92, 86, 86, 0.3);
}

#greeting {
    color: #000000;
    text-align: center;
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 4vh;
}

#input-container {
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
}

#button-container {
    width: 100%;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    margin-top: 2vh;
}

.input {
    width: 100%;
    margin-bottom: 2vh;
    border: none;
    background-color: #F3F3F3;
    color: black;
}

.input:focus {
    outline: 0;
    box-shadow: none;
    background-color: #eaeaea;
    transition: 0.2s;
}

.btn {
    justify-content: center;
    width: 45%;
}

@media (max-width: 576px) {
    .btn {
        height: 3rem;
        font-size: 1rem;
    }

    #registration-form {
        width: 85%;
    }

    #link-container {
        flex-direction: column;
    }

    #link-container a {
        margin-top: 1vh;
    }
}

</style>
