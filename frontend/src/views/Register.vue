<template>
  <div class="h-100">
    <loader :loading="loading" />

    <v-app-bar id="header-register" color="white" elevation="0">
      <img src="@/assets/logo.png" alt="Logo escrito unimestre" width="200" />

      <v-spacer></v-spacer>

      <span class="mr-4">Já tem currículo cadastrado?</span>

      <router-link to="/">
        <v-btn color="primary" large class="text-none px-6"> Login </v-btn>
      </router-link>
    </v-app-bar>

    <div id="body-register">
      <v-container>
        <v-row class="ma-0">
          <v-col class="d-none d-md-block">
            <header class="d-flex flex-column mb-4">
              <span class="font-weight-bold text-h5">Cadastro</span>
              <span class="subtitle-1 text--secondary mt-1">
                Complete suas informações.
              </span>

              <v-divider class="mt-4"></v-divider>
            </header>

            <div class="wrapper-options">
              <div
                :style="`top: ${positionEffect}%; height: ${Math.round(
                  (100 / tabs.length) * 1
                )}%`"
                class="effect-option"
              ></div>

              <span
                v-for="(item, index) in tabs"
                :key="index"
                :data-percent="(100 / tabs.length) * index"
                :ref="`tab-${item.id}`"
                :class="{ active: tabActive == item.id }"
                class="option"
              >
                {{ item.title }}
              </span>
            </div>
          </v-col>

          <v-col cols="12" md="7">
            <v-card class="h-100 px-10 py-3" elevation="0">
              <header style="height: 68px" class="d-flex align-center">
                <span class="font-weight-bold text-h5">
                  {{ getTitleTab(tabActive) }}
                </span>
              </header>

              <v-divider class="mb-4"></v-divider>

              <v-form ref="form" v-model="valid" lazy-validation>
                <component
                  @handleStep="handleStep"
                  @handleDisabledButton="handleDisabledButton"
                  @handleLoading="handleLoading"
                  v-bind:is="componentView"
                  :inputs="inputs"
                ></component>
              </v-form>

              <footer class="w-100 d-flex justify-space-between">
                <v-btn
                  color="primary"
                  outlined
                  class="text-none"
                  large
                  @click="handleStep('back')"
                  v-show="componentView != 'PersonalInformation'"
                >
                  Voltar
                </v-btn>

                <v-btn
                  color="primary"
                  class="ml-auto text-none"
                  large
                  @click="validate"
                  :disabled="disabledButton"
                >
                  {{
                    this.tabActive == this.tabs[this.tabs.length - 1].id
                      ? "Finalizar"
                      : "Próximo"
                  }}
                </v-btn>
              </footer>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </div>
  </div>
</template>

<script>
import Address from "../components/steps/Address.vue";
import Formation from "../components/steps/Formation.vue";
import PersonalInformation from "../components/steps/PersonalInformation.vue";
import ProfessionalExperience from "../components/steps/ProfessionalExperience.vue";
import ApiService from "@/core/services/api.service";
import { unformatStr, unformatDate } from "@/utils/utils";
import Loader from "../components/Loader.vue";

export default {
  components: {
    Formation,
    PersonalInformation,
    Address,
    ProfessionalExperience,
    Loader,
  },

  data() {
    return {
      disabledButton: false,
      valid: true,
      inputs: {
        personalInformation: {
          name: "",
          document: "",
          email: "",
          birth: "",
          gender: 0,
          password: "",
          confirmPassword: "",
          address: 0,
          idUser: 0,
          idPerson: 0,
          id: 0,
        },
        address: {
          zipcode: "",
          complement: "",
          neighborhood: "",
          number: "",
          city: "",
          state: "",
          street: "",
        },
        formation: [],
        experience: [],
      },
      loading: false,
      componentView: "PersonalInformation",
      tabActive: 1,
      positionEffect: 0,
      tabs: [
        {
          id: 1,
          title: "Informações Pessoais",
          component: "PersonalInformation",
        },
        { id: 2, title: "Endereço", component: "Address" },
        { id: 3, title: "Formação", component: "Formation" },
        {
          id: 4,
          title: "Experiência Profissional",
          component: "ProfessionalExperience",
        },
      ],
    };
  },

  methods: {
    handleDisabledButton(val) {
      this.disabledButton = val;
    },
    handleLoading(val) {
      this.loading = val;
    },
    async validate() {
      if (
        this.$refs.form.validate() &&
        this.tabActive == this.tabs[this.tabs.length - 1].id
      ) {
        if (this.$route.query.hash) {
          this.updateData();
        } else {
          this.$router.push("/");

          this.$toast.success("Cadastro concluído com sucesso!!");
        }
      } else if (this.$refs.form.validate() && this.tabActive == 1) {
        this.handleLoading(true);

        if (this.inputs.personalInformation.idPerson == 0) {
          await this.createPerson();
        } else {
          await this.updatePerson();
        }

        if (this.inputs.personalInformation.idUser == 0) {
          await this.createUser();
        } else {
          await this.updateUser();
        }

        this.handleLoading(false);

        this.handleStep("next");
      } else if (this.$refs.form.validate() && this.tabActive == 2) {
        this.handleLoading(true);

        const idAddress = await this.createAddress();
        this.inputs.personalInformation.address = idAddress;
        this.updatePerson();

        this.handleLoading(false);

        this.handleStep("next");
      } else if (this.$refs.form.validate()) {
        this.handleStep("next");
      }
    },
    async updateData() {
      this.loading = true;

      await this.updateAddress();
      await this.updatePerson();
      await this.updateUser();

      this.loading = false;

      this.$router.push("/");

      this.$toast.success("Informações atualizadas com sucesso!!");
    },
    async updateAddress() {
      await ApiService.put(`clients/api/address.php`, {
        ...this.inputs.address,
        zipcode: unformatStr(this.inputs.address.zipcode),
      });
    },
    async updatePerson() {
      const { idPerson, email, document, name, birth, gender, address } =
        this.inputs.personalInformation;

      await ApiService.put(`clients/api/person.php`, {
        id: idPerson,
        name,
        document: unformatStr(document),
        email,
        birth: unformatDate(birth),
        gender,
        address,
      });
    },
    async updateUser() {
      const { idUser, password } = this.inputs.personalInformation;

      await ApiService.put(`users/api/users.php`, {
        id: idUser,
        password,
      });
    },
    async createAddress() {
      const { data } = await ApiService.post("clients/api/address.php", {
        ...this.inputs.address,
        zipcode: unformatStr(this.inputs.address.zipcode),
      });

      return data.return.id;
    },
    async createPerson() {
      const {
        email,
        document,
        name,
        birth,
        gender,
        password,
        confirmPassword,
      } = this.inputs.personalInformation;

      const { data } = await ApiService.post("clients/api/person.php", {
        name,
        document: unformatStr(document),
        email,
        birth: unformatDate(birth),
        gender,
        address: 0,
      });

      const [year, month, date] = data.return.birth.split(/[^0-9]/g);

      this.inputs.personalInformation = {
        ...data.return,
        password,
        confirmPassword,
        gender: Number(data.return.gender),
        birth: `${date}/${month}/${year}`,
        idPerson: data.return.id,
        idUser: 0,
      };
    },
    async createUser() {
      const { idPerson, document, password } = this.inputs.personalInformation;

      const { data } = await ApiService.post("users/api/users.php", {
        document: unformatStr(document),
        password,
        person: idPerson,
      });

      this.inputs.personalInformation = {
        ...this.inputs.personalInformation,
        idUser: data.return.id,
      };
    },
    handleStep(action) {
      const result = action == "next" ? this.tabActive + 1 : this.tabActive - 1;

      this.tabActive = result;

      this.componentView = this.tabs.filter(
        ({ id }) => id == result
      )[0].component;

      this.positionEffect = this.$refs[`tab-${result}`][0].dataset.percent;
    },
    getTitleTab(tabActive) {
      const result = this.tabs.filter(({ id }) => id == tabActive);

      return result[0].title;
    },
  },
};
</script>

<style>
#header-register .v-toolbar__content {
  border-bottom: 1px solid #80808034;
}

#body-register {
  min-height: calc(100% - 64px);
  background: #f8f8f8;
  display: flex;
  align-items: center;
  justify-content: center;
}

.wrapper-options {
  border-left: 1px solid #80808034;
  margin-top: 2rem;
  display: flex;
  flex-direction: column;

  position: relative;
}

.wrapper-options .option {
  padding: 1.5rem 2.5rem;
  color: rgba(0, 0, 0, 0.6);
  text-decoration: none;
  cursor: pointer;
}

.wrapper-options .active {
  color: #333;
  font-weight: bold;
  font-size: 1.2rem;
}

.wrapper-options .effect-option {
  position: absolute;
  left: -1px;
  background: #ff2d55;
  /* height: 25%; */
  width: 3px;

  transition: ease-in-out 0.3s;
}
</style>
