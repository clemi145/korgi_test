<template>
  <div id="login-container">
    <jet-validation-errors class="mb-4" />

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
      {{ status }}
    </div>

    <form @submit.prevent="submit" id="login-form">
      <h2 id="greeting">Wilkommen!</h2>
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

      <div class="block mt-4">
        <label class="checkbox-container">
            Passwort merken
          <jet-checkbox name="remember" v-model="form.remember" />
            <span class="checkbox"></span>
        </label>
      </div>

      <div class="flex items-center justify-end mt-4">
        <inertia-link
          v-if="canResetPassword"
          :href="route('password.request')"
          class="underline text-sm text-gray-600 hover:text-gray-900"
        >
          Forgot your password?
        </inertia-link>

        <jet-button
          class="btn secondary-background"
          :disabled="form.processing"
        >
          Anmelden
        </jet-button>
      </div>
    </form>
  </div>
</template>

<script>
import JetButton from "@/Jetstream/Button";
import JetInput from "@/Jetstream/Input";
import JetCheckbox from "@/Jetstream/Checkbox";
import JetLabel from "@/Jetstream/Label";
import JetValidationErrors from "@/Jetstream/ValidationErrors";

export default {
  components: {
    JetButton,
    JetInput,
    JetCheckbox,
    JetLabel,
    JetValidationErrors,
  },

  props: {
    canResetPassword: Boolean,
    status: String,
  },

  data() {
    return {
      form: this.$inertia.form({
        email: "",
        password: "",
        remember: false,
      }),
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
#login-container {
  font-family: "Montserrat", sans-serif;
  display: flex;
  flex-direction: column;
  width: 100%;
}

#greeting {
  color: var(--font-color);
  text-align: center;
  font-size: 1.5rem;
  font-weight: 600;
  margin-bottom: 2vh;
}

#login-form {
  background-color: var(--background-color);
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
