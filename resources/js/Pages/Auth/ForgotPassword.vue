<template>
    <div id="forgot-password">
        <inertia-link id="logo" class="no-select" :href="route('home')">
            <img src="/images/korgi_yellow_only.svg" alt="Logo">
        </inertia-link>

        <div id="form-container">
            <div id="forgot-password-content">
                <h2 id="greeting">Passwort vergessen</h2>
                <div class="text">
                    Du hast dein Passwort vergessen? Kein Problem! Verrate uns einfach deine E-Mail Adresse und wir
                    schicken dir einen Link,
                    mit welchem du dein Passwort zurücksetzen kannst.
                </div>

                <!--                <div v-if="status" class="mb-4 font-medium text-sm text-green-600">-->
                <!--                    {{ status }}-->
                <!--                </div>-->

                <jet-validation-errors class="mb-4"/>

                <form @submit.prevent="submit">

                    <jet-input id="email" type="email" class="input" placeholder="E-Mail" v-model="form.email" required
                               autofocus/>


                    <div class="button-container">
                        <jet-button class="btn secondary-background" :disabled="form.processing">
                            Email Password Reset Link
                        </jet-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo'
import JetButton from '@/Jetstream/Button'
import JetInput from '@/Jetstream/Input'
import JetLabel from '@/Jetstream/Label'
import JetValidationErrors from '@/Jetstream/ValidationErrors'

export default {
    components: {
        JetAuthenticationCard,
        JetAuthenticationCardLogo,
        JetButton,
        JetInput,
        JetLabel,
        JetValidationErrors
    },

    props: {
        status: String
    },

    data() {
        return {
            form: this.$inertia.form({
                email: ''
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('password.email'))
        }
    }
}
</script>
<style scoped>
#forgot-password {
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

#form-container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 80%;
    width: 100%;
}

#forgot-password-content {
    background-color: #ffffff;
    border-radius: 30px;
    padding: 4vh;
    width: 25%;
}

.text {
    margin-bottom: 2vh;
}

#greeting {
    color: #000000;
    text-align: center;
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 4vh;
}
.input {
    width: 100%;
}

.button-container {
    display: flex;
    justify-content: flex-end;
}

.btn {
    width: fit-content;
    margin-top: 4vh;
}
</style>
