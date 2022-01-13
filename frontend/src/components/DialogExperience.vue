<template>
  <div class="text-center">
    <v-dialog v-model="dialog" width="500">
      <template v-slot:activator="{ on, attrs }">
        <v-btn icon v-bind="attrs" v-on="on">
          <v-icon>mdi-plus</v-icon>
        </v-btn>
      </template>

      <v-card>
        <v-card-title class="text-h5 primary white--text">
          Adicionar experiência

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
              v-model="inputs.name"
              :rules="inputRules"
              label="Nome"
              outlined
              required
              dense
            ></v-text-field>

            <v-text-field
              v-model="inputs.company"
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
            v-model="inputs.expire"
            label="Trabalho atualmente neste cargo"
          ></v-checkbox>

          <v-form ref="form2" v-model="valid2" lazy-validation>
            <span>Data de início</span>

            <v-row class="ma-0">
              <v-col class="pl-0 pb-0">
                <v-text-field
                  v-model="inputs.start.month"
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
                  v-model="inputs.start.year"
                  :rules="yearRules"
                  v-mask="['####']"
                  label="Ano"
                  outlined
                  required
                  dense
                ></v-text-field>
              </v-col>
            </v-row>

            <div v-if="!inputs.expire">
              <span class="mt-4">Data de término</span>

              <v-row class="ma-0">
                <v-col class="pl-0 pb-0">
                  <v-text-field
                    v-model="inputs.end.month"
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
                    v-model="inputs.end.year"
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

            <v-textarea
              outlined
              name="input-7-4"
              label="Descrição"
              counter="500"
              v-model="inputs.description"
            ></v-textarea>
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
    idUser: {},
    listExperiences: Array,
  },

  data() {
    const currentYear = new Date().getFullYear();

    return {
      inputs: {
        expire: true,
        start: {
          month: "",
          year: "",
        },
        end: {
          month: "",
          year: "",
        },
      },
      valid: true,
      valid2: true,
      loading: false,
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
    };
  },

  methods: {
    async saveDialog() {
      const form1 = this.$refs.form.validate();
      const form2 = this.$refs.form2.validate();

      if (form1 && form2) {
        this.loading = true;

        const obj = JSON.parse(JSON.stringify(this.inputs));

        const data = await this.createExperience(obj);

        this.listExperiences.push({
          ...data,
          start: {
            month: data.startMonth,
            year: data.startYear,
          },
          end: {
            month: data.endMonth,
            year: data.endYear,
          },
        });

        this.dialog = false;

        this.resetDialog();

        this.loading = false;
      }
    },

    closeDialog() {
      this.dialog = false;

      this.resetDialog();
    },

    resetDialog() {
      this.$refs.form.reset();
      this.$refs.form2.reset();
      this.inputs.expire = true;
    },

    async createExperience(obj) {
      const tmp = {
        ...obj,
        startMonth: obj.start.month,
        startYear: obj.start.year,
        endMonth: obj.end.month,
        endYear: obj.end.year,
        user: this.idUser,
      };

      const { data } = await ApiService.post("clients/api/experience.php", tmp);

      return data.return;
    },
  },
};
</script>
