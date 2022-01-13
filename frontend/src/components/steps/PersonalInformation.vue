<template>
  <div>
    <v-row class="ma-0">
      <v-col class="pl-0">
        <v-text-field
          v-model="inputs.personalInformation.document"
          :rules="documentRules"
          label="CPF"
          v-mask="['###.###.###-##']"
          outlined
          required
          :disabled="$route.query.hash !== undefined"
          dense
          @blur="verifyExistDocument"
        ></v-text-field>
      </v-col>

      <v-col class="pr-0">
        <v-text-field
          v-model="inputs.personalInformation.name"
          :rules="inputRules"
          label="Nome completo"
          outlined
          required
          dense
        ></v-text-field>
      </v-col>
    </v-row>

    <v-text-field
      v-model="inputs.personalInformation.email"
      :rules="emailRules"
      label="Email"
      outlined
      required
      dense
    ></v-text-field>

    <v-row class="ma-0">
      <v-col class="pl-0">
        <v-menu
          ref="menu1"
          v-model="menu1"
          :close-on-content-click="false"
          transition="scale-transition"
          offset-y
          max-width="290px"
          min-width="auto"
        >
          <template v-slot:activator="{ on, attrs }">
            <v-text-field
              label="Data de nascimento"
              append-icon="mdi-calendar"
              @blur="date = parseDate(inputs.personalInformation.birth)"
              v-bind="attrs"
              v-on="on"
              v-model="inputs.personalInformation.birth"
              v-mask="['##/##/####']"
              :rules="inputRules"
              outlined
              dense
            ></v-text-field>
          </template>
          <v-date-picker
            locale="pt-br"
            color="primary"
            v-model="date"
            no-title
            @input="menu1 = false"
          ></v-date-picker>
        </v-menu>
      </v-col>

      <v-col class="pr-0">
        <v-select
          :items="genderOptions"
          item-text="name"
          item-value="id"
          :rules="inputRules"
          v-model="inputs.personalInformation.gender"
          label="Gênero"
          outlined
          required
          dense
        ></v-select>
      </v-col>
    </v-row>

    <v-row class="ma-0">
      <v-col class="pl-0">
        <v-text-field
          v-model="inputs.personalInformation.password"
          :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
          :rules="[...inputRules, ...rules.min]"
          :type="show1 ? 'text' : 'password'"
          name="input-10-1"
          label="Senha"
          outlined
          dense
          @click:append="show1 = !show1"
        ></v-text-field>
      </v-col>
      <v-col class="pr-0">
        <v-text-field
          v-model="inputs.personalInformation.confirmPassword"
          :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
          :rules="[...inputRules, ...rules.min, ...rules.matchPassword]"
          :type="show2 ? 'text' : 'password'"
          name="input-10-1"
          label="Confirmar senha"
          outlined
          dense
          @click:append="show2 = !show2"
        ></v-text-field>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import { cpf } from "cpf-cnpj-validator";
import ApiService from "@/core/services/api.service";
import { unformatStr, formatDate } from "@/utils/utils";

export default {
  props: {
    inputs: Object,
  },

  data() {
    return {
      show1: false,
      show2: false,
      rules: {
        min: (v) => (!!v && v.length >= 8) || "Mínimo 8 caracteres",
        matchPassword: (v) =>
          this.inputs.personalInformation.password == v ||
          "As senhas não coincidem",
      },
      genderOptions: [
        { id: 1, name: "Masculino" },
        { id: 2, name: "Feminino" },
        { id: 3, name: "Não binário" },
      ],
      inputRules: [(v) => !!v || "Campo obrigatório"],
      documentRules: [
        (v) => !!v || "Campo obrigatório",
        (v) => cpf.isValid(v) || "CPF inválido",
      ],
      emailRules: [
        (v) => !!v || "Campo obrigatório",
        (v) => /.+@.+\..+/.test(v) || "E-mail inválido",
      ],
      date: "",
      menu1: false,
    };
  },

  mounted() {
    const hash = this.$route.query.hash;

    if (hash && this.inputs.personalInformation.document == "") {
      this.$emit("handleLoading", true);

      ApiService.get(`users/api/users.php?hash=${hash}`).then(({ data }) => {
        ApiService.get(`clients/api/person.php?id=${data.return.person}`).then(
          (personResponse) => {
            this.inputs.personalInformation = {
              ...data.return,
              ...personResponse.data.return,
              idUser: data.return.id,
              idPerson: personResponse.data.return.id,
              birth: formatDate(personResponse.data.return.birth),
              password: "",
              gender: Number(personResponse.data.return.gender),
            };

            this.$emit("handleLoading", false);
          }
        );
      });
    }
  },

  watch: {
    date() {
      this.inputs.personalInformation.birth = this.formatDate(this.date);
    },
  },

  methods: {
    verifyExistDocument() {
      const document = this.inputs.personalInformation.document;

      if (cpf.isValid(document)) {
        ApiService.get(
          `users/api/users.php?document=${unformatStr(document)}`
        ).then(({ data }) => {
          if (data.message == "") {
            this.$emit("handleDisabledButton", false);
          } else {
            this.$toast.error(data.message);

            this.$emit("handleDisabledButton", true);
          }
        });
      }
    },

    formatDate(date) {
      if (!date) return null;

      const [year, month, day] = date.split("-");
      return `${day}/${month}/${year}`;
    },
    parseDate(date) {
      if (!date) return null;

      const [day, month, year] = date.split("/");
      return `${year}-${month.padStart(2, "0")}-${day.padStart(2, "0")}`;
    },
  },
};
</script>
