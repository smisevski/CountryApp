<template>
  <el-container v-if="isLoading">
    <h1>Loading content...</h1>
  </el-container>
  <el-container v-else>
    <el-row :gutter="20">
      <el-col
        class="mb-col"
        :lg="6"
        :md="6"
        :sm="12"
        v-for="(country, index) in countries"
        :key="index"
      >
        <el-card shadow='hover' class="box-card" style="border: 1px solid black">
          <template #header>
            <div class="card-header">
              <span>{{ country.name }}</span
              ><br />
              <el-button class="button width-100" type="primary" @click="addToFav({ user_id: 1, country_id: country.alpha2Code })">Add To Favorites</el-button>
            </div>
          </template>
          <div>
            <span>
              {{ country.capital }}
            </span>
            <small>--capital</small>
            <br />
            <span>
              {{ country.region }}
            </span>
            <small>--region</small>
          </div>
        </el-card>
      </el-col>
    </el-row>
  </el-container>
</template>

<script>
// import AuthService from "../../services/AuthService";
import CountriesService from "../../services/CountriesService";

import { onBeforeMount, onMounted, ref } from "vue";
import { useRouter } from "vue-router";
export default {
  name: "Countries",
  components: {},
  setup(props, { emit }) {
    const router = useRouter();
    const isLoading = ref(false);
    const countries = ref([]);
    const page = ref(1);
    const records = ref(0);
    const countriesService = new CountriesService();

    const fetchCountries = async () => {
      isLoading.value = true;
      countriesService.getAll().then((res) => {
        if (res.status === 200) {
          countries.value = res.data;
          isLoading.value = false;
          records.value = res.data.length;
        }
      });
    };

    const addToFav = (country) => {
      countriesService.addToFavorites(country).then((res) => {
        if (res.status === 200) {
          alert('Added to Favorites') // implement notification from library (toast, popup, etc..)
        }
      }).catch((e) => console.error(e))
    }

    onBeforeMount(() => {
      if (
        localStorage.accessToken === undefined ||
        localStorage.accessToken === null ||
        localStorage.accessToken == ""
      ) {
        router.push("/login").catch((e) => console.error(e));
        emit("activeItem", "4");
      }
    });

    onMounted(() => {
      fetchCountries();
    });

    return {
      isLoading,
      countries,
      page,
      records,
      addToFav
    };
  },
};
</script>

<style scoped>
.mb-col {
  margin-bottom: 20px;
}
.width-100 {
  width: 100%!important;
}
</style>

