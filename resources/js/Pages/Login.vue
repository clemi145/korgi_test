<template>

<!--    <div class="w-full max-w-xs container mx-auto">-->
<!--        <form @submit.prevent="submit" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">-->
<!--            <div class="mb-4">-->
<!--                <Input v-model="username" placeholder="Username" label="Username" type="text" :error="error.username"/>-->
<!--            </div>-->
<!--            <div class="mb-6">-->
<!--                <Input v-model="password" placeholder="Password" label="Password" type="password" :error="error.password"/>-->
<!--            </div>-->
<!--            <div class="flex items-center justify-between">-->
<!--                <button-->
<!--                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"-->
<!--                    type="button"-->
<!--                >-->
<!--                    Sign In-->
<!--                </button>-->
<!--                <a-->
<!--                    class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800"-->
<!--                    href="#"-->
<!--                >-->
<!--                    Forgot Password?-->
<!--                </a>-->
<!--            </div>-->
<!--        </form>-->
<!--        <p class="text-center text-gray-500 text-xs">-->
<!--            &copy;2020 Acme Corp. All rights reserved.-->
<!--        </p>-->
<!--    </div>-->


    <div id="login-container">
        <form @submit.prevent="submit" id="login-form">
            <h2 id="greeting">Wilkommen!</h2>
            <div class="mb-4">
<!--                <Input class="input" v-model="username" placeholder="E-Mail" type="text" :error="error.username"/>-->
                <input class="input" v-model="username" placeholder="E-Mail" type="email" :error="error.username"/>
            </div>
            <div class="mb-6">
<!--                <Input class="input" v-model="password" placeholder="Passwort" type="password"-->
<!--                       :error="error.password"/>-->
                <input class="input" v-model="password" placeholder="Passwort" type="password"
                       :error="error.password"/>
            </div>
            <div>
                <a
                    class=""
                    href="#"
                >
                    Vergessen?
                </a>
            </div>
            <div>
                <button
                    class="btn secondary-background"
                    type="button"
                >
                    Anmelden
                </button>
            </div>
        </form>
    </div>
</template>

<style scoped>

#login-container {
    font-family: "Montserrat", sans-serif;
    display: flex;
    flex-direction: column;
    width: 24%;
}

#greeting {
    color: var(--font-color);
    text-align: center;
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 2vh;
}

#login-form {
    background-color: var(--white);
    border-radius: 30px;
    padding: 4vh;
}

.btn {
    width: 100%;
    justify-content: center;
}

.input {
    width: 100%;
}

</style>

<script>
import Input from "./Input"

export default {
    name: "Login",
    components: {Input},
    data: () => {
        return {
            username: "",
            password: "",
            error: {}
        };
    },
    methods: {
        submit() {
            this.error = {};
            if (!this.username.trim()) this.error.username = "Username required";
            if (!!this.error) return;
        }
    }
};
</script>
