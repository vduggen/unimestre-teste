<template>
  <v-container class="h-100 pa-0" fluid>
    <v-row class="h-100 ma-0">
      <v-col
        class="bg-primary h-100 d-none d-md-flex align-center justify-center flex-column"
      >
        <img
          src="@/assets/undraw_mobile_login_re_9ntv-red.svg"
          alt="Access account"
          width="60%"
        />

        <span class="text-h4 font-weight-bold mt-7 white--text text-center">
          Bem vindo a área de <br />
          trabalhe conosco
        </span>
      </v-col>

      <v-col class="d-flex align-center justify-center pt-7">
        <div style="width: 95%" class="h-100">
          <header class="d-flex align-center justify-end ml-auto">
            <span class="mr-4">Não tem currículo cadastrado?</span>

            <router-link to="/cadastro">
              <v-btn
                :loading="loading"
                color="primary"
                large
                class="text-none px-6"
              >
                Cadastro
              </v-btn>
            </router-link>
          </header>

          <div
            style="height: calc(100% - 44px)"
            class="d-flex justify-center align-center flex-column"
          >
            <span class="text-h5 font-weight-medium text-center mb-10">
              Login
            </span>

            <v-form
              ref="form"
              style="width: 350px"
              v-model="valid"
              lazy-validation
            >
              <v-text-field
                outlined
                v-model="document"
                :rules="documentRules"
                label="CPF"
                v-mask="['###.###.###-##']"
                :loading="loading"
                required
                dense
              ></v-text-field>

              <v-text-field
                outlined
                dense
                v-model="password"
                :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                :rules="passwordRules"
                :type="show1 ? 'text' : 'password'"
                label="Senha"
                :loading="loading"
                @click:append="show1 = !show1"
              ></v-text-field>

              <v-btn
                color="primary"
                class="text-none mt-5"
                @click="validate"
                large
                block
                :loading="loading"
              >
                Entrar
              </v-btn>
            </v-form>
          </div>
        </div>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import { cpf } from "cpf-cnpj-validator";
import ApiService from "@/core/services/api.service";
import { unformatStr } from "@/utils/utils";

export default {
  name: "Home",

  data: () => ({
    loading: false,
    show1: false,
    password: "",
    passwordRules: [(v) => !!v || "Campo obrigatório"],
    valid: true,
    document: "",
    documentRules: [
      (v) => !!v || "Campo obrigatório",
      (v) => cpf.isValid(v) || "CPF inválido",
    ],
  }),

  methods: {
    validate() {
      if (this.$refs.form.validate()) {
        const document = unformatStr(this.document);
        const password = this.password;
        this.loading = true;

        ApiService.get(
          `users/api/users.php?document=${document}&password=${password}`
        )
          .then(({ data }) => {
            if (data.message == "") {
              this.$router.push(`/cadastro?hash=${data.return.hash}`);
            } else {
              this.$toast.error(data.message);
            }

            this.loading = false;
          })
          .catch(() => (this.loading = false));
      }
    },
  },
};
</script>

<style scoped>
.bg-primary {
  background-color: #5a90fb;
}
</style>
