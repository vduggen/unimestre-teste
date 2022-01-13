<template>
  <div>
    <v-row class="ma-0">
      <v-col class="pl-0">
        <v-text-field
          v-model="inputs.address.zipcode"
          :rules="inputRules"
          label="CEP"
          @blur="getCEP"
          v-mask="['#####-###']"
          outlined
          required
          dense
          :loading="loading"
        ></v-text-field>
      </v-col>

      <v-col class="pr-0">
        <v-text-field
          v-model="inputs.address.street"
          :rules="inputRules"
          label="Rua"
          outlined
          required
          dense
          :loading="loading"
        ></v-text-field>
      </v-col>
    </v-row>

    <v-row class="ma-0">
      <v-col class="pl-0">
        <v-text-field
          v-model="inputs.address.neighborhood"
          :rules="inputRules"
          label="Bairro"
          outlined
          required
          dense
          :loading="loading"
        ></v-text-field>
      </v-col>

      <v-col class="pr-0">
        <v-text-field
          v-model="inputs.address.number"
          :rules="inputRules"
          label="Número"
          v-mask="['#########']"
          outlined
          required
          dense
        ></v-text-field>
      </v-col>
    </v-row>

    <v-row class="ma-0">
      <v-col class="pl-0">
        <v-text-field
          v-model="inputs.address.city"
          :rules="inputRules"
          label="Cidade"
          outlined
          required
          dense
          :loading="loading"
        ></v-text-field>
      </v-col>

      <v-col class="pr-0">
        <v-autocomplete
          :items="listStates"
          :rules="inputRules"
          v-model="inputs.address.state"
          label="Estado"
          outlined
          required
          dense
        ></v-autocomplete>
      </v-col>
    </v-row>

    <v-text-field
      v-model="inputs.address.complement"
      label="Complemento"
      outlined
      required
      dense
      hide-details
      class="mb-5"
    ></v-text-field>
  </div>
</template>

<script>
import ApiService from "@/core/services/api.service.js";

export default {
  props: {
    inputs: Object,
  },

  mounted() {
    const hash = this.$route.query.hash;

    if (hash && this.inputs.address.zipcode == "") {
      this.$emit("handleLoading", true);

      ApiService.get(
        `clients/api/address.php?id=${this.inputs.personalInformation.address}`
      ).then(({ data }) => {
        this.inputs.address = data.return;

        this.$emit("handleLoading", false);
      });
    }
  },

  data: () => ({
    loading: false,
    listStates: [
      "AC",
      "AL",
      "AP",
      "AM",
      "BA",
      "CE",
      "DF",
      "ES",
      "GO",
      "MA",
      "MT",
      "MS",
      "MG",
      "PA",
      "PB",
      "PR",
      "PE",
      "PI",
      "RJ",
      "RN",
      "RS",
      "RO",
      "RR",
      "SC",
      "SP",
      "SE",
      "TO",
    ],
    inputRules: [(v) => !!v || "Campo obrigatório"],
  }),

  methods: {
    getCEP() {
      const zipcode = this.inputs.address.zipcode.replace("-", "");

      if (zipcode) {
        this.loading = true;

        ApiService.getViaCEP(zipcode)
          .then(({ data }) => {
            this.loading = false;

            this.inputs.address = {
              ...this.inputs.address,
              street: data.logradouro,
              complement: data.complemento,
              neighborhood: data.bairro,
              city: data.localidade,
              state: data.uf,
            };
          })
          .catch(() => (this.loading = false));
      }
    },
  },
};
</script>
