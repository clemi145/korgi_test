<template>
    <div id="login-container">
        <jet-validation-errors id="error"/>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit" id="login-form">
            <h2 id="greeting">Willkommen!</h2>
            <div>
                <jet-input
                    id="email"
                    type="email"
                    class="input"
                    v-model="form.email"
                    placeholder="E-Mail"
                    required
                    autofocus
                />
            </div>

            <div class="mt-4">
                <jet-input
                    id="password"
                    type="password"
                    class="input"
                    v-model="form.password"
                    placeholder="Passwort"
                    required
                    autocomplete="current-password"
                />
            </div>

            <div id="password-container">
                <label class="checkbox-container">
                    Passwort merken
                    <jet-checkbox name="remember" v-model="form.remember"/>
                    <span class="checkbox"></span>
                </label>
                <inertia-link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="underline text-sm text-gray-600 hover:text-gray-900"
                >
                    Passwort vergessen?
                </inertia-link>
            </div>

            <div id="login-button-container">
                <jet-button
                    class="btn secondary-background"
                    :disabled="form.processing"
                >
                    Anmelden
                </jet-button>
            </div>
        </form>
        <div id="google-button-container">
            <inertia-link id="google-login" :href="route('auth.google')">
                <img class="google-icon" src="/images/google-icon.svg">
                <span id="google-button-text">Login With Google</span>
            </inertia-link>
        </div>
    </div>
</template>

<script>
// import JetAuthenticationCard from "@/Jetstream/AuthenticationCard";
import JetButton from "@/Jetstream/Button";
import JetInput from "@/Jetstream/Input";
import JetCheckbox from "@/Jetstream/Checkbox";
import JetLabel from "@/Jetstream/Label";
import JetValidationErrors from "@/Jetstream/ValidationErrors";

export default {
    components: {
        // JetAuthenticationCard,
        JetButton,
        JetInput,
        JetCheckbox,
        JetLabel,
        JetValidationErrors,
    },

    props: {
        // canResetPassword: Boolean,
        status: String,
    },

    data() {
        return {
            form: this.$inertia.form({
                email: "",
                password: "",
                remember: false,
            }),
            canResetPassword: 1
        };
    },

    methods: {
        submit() {
            this.form
                .transform((data) => ({
                    ...data,
                    remember: this.form.remember ? "on" : "",
                }))
                .post(this.route("login"), {
                    onFinish: () => this.form.reset("password"),
                });
        },
    },
};
</script>


<style scoped>

#google-button-text {
    font-weight: 700;
}

#google-login {
    padding: 1rem;
    background-color: #FFFFFF;
    -webkit-box-shadow: 5px 5px 40px 0px rgba(92, 86, 86, 0.3);
    -moz-box-shadow: 5px 5px 40px 0px rgba(92, 86, 86, 0.3);
    box-shadow: 5px 5px 40px 0px rgba(92, 86, 86, 0.3);
    border-radius: 30px;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    width: 60%;
}

.google-icon {
    width: 8%;
    margin-right: 1rem;
}

#google-login:hover {
    background-color: #F3F3F3;
}

::selection {
    background-color: var(--secondary);
    color: white;
}

#login-container {
    font-family: "Montserrat", sans-serif;
    display: flex;
    flex-direction: column;
    width: 100%;
}

#greeting {
    color: #000000;
    text-align: center;
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 2vh;
}

#login-form {
    background-color: #FFFFFF;
    border-radius: 30px;
    padding: 4vh;
    -webkit-box-shadow: 5px 5px 40px 0px rgba(92, 86, 86, 0.3);
    -moz-box-shadow: 5px 5px 40px 0px rgba(92, 86, 86, 0.3);
    box-shadow: 5px 5px 40px 0px rgba(92, 86, 86, 0.3);
}

.btn {
    justify-content: center;
    margin-top: 2vh;
    width: 50%;
    font-size: 1.5rem;
    height: 4rem;
    border-radius: 2rem;
}

.btn:focus {
    outline: 0;
}

#login-button-container {
    display: flex;
    flex-direction: row;
    justify-content: center;
    width: 100%;
}

#google-button-container {
    margin-top: 3vh;
    display: flex;
    flex-direction: row;
    justify-content: center;
}

#password-container {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    margin-top: 2vh;
}

.input {
    width: 100%;
    border: none;
    background-color: #F3F3F3;
    color: black;
}

.input:focus {
    outline: 0;
    border: none;
    background-color: #eaeaea;
    box-shadow: none;
}

/*Checkbox*/
.checkbox-container {
    margin: 0;
    display: flex;
    align-items: center;
    position: relative;
    padding-left: 35px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    cursor: pointer;
}

.checkbox-container input, .checkbox-container input {
    opacity: 0;
    position: absolute;
    cursor: pointer;
    height: 0;
    width: 0;
}

.checkbox {
    position: absolute;
    top: 0;
    left: 0;
    border-radius: 30%;
    height: 20px;
    width: 20px;
    background-color: #ffffff;
    border: 2px solid #000000;
}

input:checked ~ .checkbox {
    background-color: var(--primary);
    border: 2px solid var(--primary);
}

.checkbox:after {
    content: "";
    position: absolute;
    display: none;
}

input:checked ~ .checkbox:after {
    display: block;
}

.checkbox:after {
    left: 6px;
    top: 3px;
    width: 5px;
    height: 10px;
    border: solid #ffffff;
    border-width: 0 3px 3px 0;
    border-radius: 1px;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
}

@media (max-width: 576px) {
    .btn {
        height: 3rem;
        font-size: 1rem;
    }

    #google-login {
        width: 80%;
    }
}
</style>
