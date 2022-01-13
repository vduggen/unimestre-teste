<template>
  <div>
    <v-list>
      <v-subheader class="px-0">
        Experiência

        <v-spacer></v-spacer>

        <dialog-experience
          :idUser="inputs.personalInformation.id"
          :listExperiences="inputs.experience"
        />
      </v-subheader>

      <v-list-item
        class="pl-0"
        v-for="(item, index) in inputs.experience"
        :key="index"
      >
        <v-list-item-content>
          <v-list-item-title
            class="font-weight-bold d-flex justify-space-between align-center"
          >
            {{ item.name }}

            <span class="d-flex align-center">
              <v-btn icon small @click="deleteItem(item.id, index)">
                <v-icon size="1rem">mdi-delete</v-icon>
              </v-btn>

              <dialog-edit-experience
                :index="index"
                :inputs="item"
                :listExperience="inputs.experience"
                @updateInputs="updateInputs"
              />
            </span>
          </v-list-item-title>
          <v-list-item-subtitle class="text--primary">
            {{ item.company }}
          </v-list-item-subtitle>
          <v-list-item-subtitle class="text--secondary">
            {{ getNameMonth(item.start.month) }} de {{ item.start.year }} •
            {{
              item.end.month == ""
                ? "o momento"
                : `${getNameMonth(item.end.month)} de ${item.end.year}`
            }}
          </v-list-item-subtitle>
          <v-list-item-subtitle id="description" class="text--primary">
            {{ item.description }}
          </v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>
    </v-list>
  </div>
</template>

<script>
import DialogEditExperience from "../DialogEditExperience.vue";
import DialogExperience from "../DialogExperience.vue";
import ApiService from "@/core/services/api.service.js";

export default {
  components: { DialogExperience, DialogEditExperience },

  props: {
    inputs: Object,
  },

  mounted() {
    const hash = this.$route.query.hash;

    if (hash && this.inputs.experience.length == 0) {
      this.$emit("handleLoading", true);

      ApiService.get(
        `clients/api/experience.php?user=${this.inputs.personalInformation.id}`
      ).then(({ data }) => {
        if (data.return.length > 0) {
          this.inputs.experience = data.return.map((item) => ({
            ...item,
            start: {
              month: item.startMonth,
              year: item.startYear,
            },
            end: {
              month: item.endMonth,
              year: item.endYear,
            },
          }));
        }

        this.$emit("handleLoading", false);
      });
    }
  },

  data: () => ({
    inputRules: [(v) => !!v || "Campo obrigatório"],
    months: [
      { id: 1, name: "Janeiro" },
      { id: 2, name: "Fevereiro" },
      { id: 3, name: "Março" },
      { id: 4, name: "Abril" },
      { id: 5, name: "Maio" },
      { id: 6, name: "Junho" },
      { id: 7, name: "Julho" },
      { id: 8, name: "Agosto" },
      { id: 9, name: "Setembro" },
      { id: 10, name: "Outubro" },
      { id: 11, name: "Novembro" },
      { id: 12, name: "Dezembro" },
    ],
  }),

  methods: {
    async deleteItem(id, index) {
      this.$emit("handleLoading", true);

      await this.deleteExperience(id);

      const tmp = [...this.inputs.experience];

      tmp.splice(index, 1);

      this.updateInputs(tmp);

      this.$emit("handleLoading", false);
    },

    async deleteExperience(id) {
      return await ApiService.delete(`clients/api/experience.php?id=${id}`);
    },

    getNameMonth(value) {
      if (value) {
        const result = this.months.filter(({ id }) => id == value);

        return result[0].name;
      }
    },

    updateInputs(newArr) {
      this.inputs.experience = [];
      this.inputs.experience = newArr;
    },
  },
};
</script>

<style>
#description.v-list-item__subtitle {
  white-space: normal !important;
}
</style>
