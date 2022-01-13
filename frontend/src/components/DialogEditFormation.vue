<template>
  <div class="text-center">
    <v-dialog persistent v-model="dialog" width="500">
      <template v-slot:activator="{ on, attrs }">
        <v-btn icon small v-bind="attrs" v-on="on">
          <v-icon size="1rem">mdi-pencil</v-icon>
        </v-btn>
      </template>

      <v-card>
        <v-card-title class="text-h5 primary white--text">
          Editar licença ou certificado

          <v-btn
            icon
            :loading="loading"
            color="white"
            class="ml-auto"
            @click="closeDialog"
          >
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-card-title>

        <v-card-text class="pt-6">
          <v-form ref="form" v-model="valid" lazy-validation>
            <v-text-field
              v-model="cloneInputs.name"
              :rules="inputRules"
              label="Nome"
              outlined
              required
              dense
            ></v-text-field>

            <v-text-field
              v-model="cloneInputs.company"
              :rules="inputRules"
              label="Organização emissora"
              outlined
              required
              dense
            ></v-text-field>
          </v-form>

          <v-checkbox
            hide-details
            class="mt-0 mb-4"
            v-model="cloneInputs.expire"
            label="Esta credencial não expira"
          ></v-checkbox>

          <v-form ref="form2" v-model="valid2" lazy-validation>
            <span>Data de emissão</span>

            <v-row class="ma-0">
              <v-col class="pl-0 pb-0">
                <v-text-field
                  v-model="cloneInputs.start.month"
                  v-mask="['##']"
                  :rules="monthRules"
                  label="Mês"
                  outlined
                  required
                  dense
                ></v-text-field>
              </v-col>

              <v-col class="pr-0 pb-0">
                <v-text-field
                  v-model="cloneInputs.start.year"
                  :rules="yearRules"
                  v-mask="['####']"
                  label="Ano"
                  outlined
                  required
                  dense
                ></v-text-field>
              </v-col>
            </v-row>

            <div v-if="!cloneInputs.expire">
              <span class="mt-4">Data de expiração</span>

              <v-row class="ma-0">
                <v-col class="pl-0 pb-0">
                  <v-text-field
                    v-model="cloneInputs.end.month"
                    v-mask="['##']"
                    :rules="monthRules"
                    label="Mês"
                    outlined
                    required
                    dense
                  ></v-text-field>
                </v-col>

                <v-col class="pr-0 pb-0">
                  <v-text-field
                    v-model="cloneInputs.end.year"
                    :rules="yearRules"
                    v-mask="['####']"
                    label="Ano"
                    outlined
                    required
                    dense
                  ></v-text-field>
                </v-col>
              </v-row>
            </div>
          </v-form>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="primary"
            class="text-none"
            large
            text
            @click="saveDialog"
            :loading="loading"
          >
            Salvar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import ApiService from "@/core/services/api.service";

export default {
  props: {
    index: {},
    inputs: Object,
    listFormation: Array,
  },

  data() {
    const currentYear = new Date().getFullYear();

    return {
      valid: true,
      valid2: true,
      dialog: false,
      inputRules: [(v) => !!v || "Campo obrigatório"],
      monthRules: [
        (v) => !!v || "Campo obrigatório",
        (v) => (v > 0 && v <= 12) || "Mês inválido",
      ],
      yearRules: [
        (v) => !!v || "Campo obrigatório",
        (v) => (v > 0 && v <= currentYear) || "Ano inválido",
      ],
      cloneInputs: {
        start: { month: "", year: "" },
        end: { month: "", year: "" },
      },
      loading: false,
    };
  },

  watch: {
    [`cloneInputs.expire`](val) {
      if (val == true) {
        this.cloneInputs.end = {
          month: "",
          year: "",
        };
      }
    },
  },

  mounted() {
    this.cloneInputs = JSON.parse(JSON.stringify(this.inputs));
  },

  methods: {
    async saveDialog() {
      const form1 = this.$refs.form.validate();
      const form2 = this.$refs.form2.validate();

      if (form1 && form2) {
        this.loading = true;

        const tmp = [...this.listFormation];

        tmp.splice(this.index, 1);

        const obj = JSON.parse(JSON.stringify(this.cloneInputs));

        const data = await this.updateGraduation(obj);

        tmp[this.index] = {
          ...data,
          start: {
            month: data.startMonth,
            year: data.startYear,
          },
          end: {
            month: data.endMonth,
            year: data.endYear,
          },
        };

        this.$emit("updateInputs", tmp);

        this.dialog = false;

        this.loading = false;
      }
    },

    async updateGraduation(obj) {
      const tmp = {
        ...obj,
        startMonth: obj.start.month,
        startYear: obj.start.year,
        endMonth: obj.end.month,
        endYear: obj.end.year,
      };

      const { data } = await ApiService.put(`clients/api/graduation.php`, tmp);

      return data.return;
    },

    closeDialog() {
      this.cloneInputs = JSON.parse(JSON.stringify(this.inputs));

      this.dialog = false;
    },
  },
};
</script>
