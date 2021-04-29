<template>
  <el-container v-if="isLoading">
    <h1>Loading content...</h1>
  </el-container>
  <el-container v-else>
    <el-row :gutter="20" style="width: 100%">
      <el-col
        class="mb-col"
        :sm="12"
        :md="6"
        v-for="(country, index) in favorites"
        :key="index"
      >
        <el-card class="box-card" style="border: 1px solid black">
          <template #header>
            <div class="card-header">
              <span>{{ country.name }}</span
              ><br />
              <el-button
                @click="
                  removeFromFav({ user_id: 1, country_id: country.alpha2Code })
                "
                class="button width-100"
                type="danger"
                >Remove From Favorites</el-button
              >
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
import CountriesService from "../../services/CountriesService";

import { onBeforeMount, onMounted, ref } from "vue";
import { useRouter } from "vue-router";
export default {
  name: "Favorites",
  components: {},
  setup(props, { emit }) {
    const router = useRouter();
    const isLoading = ref(false);
    const favorites = ref([]);
    const page = ref(1);
    const records = ref(0);
    const countriesService = new CountriesService();

    const fetchFavorites = async () => {
      isLoading.value = true;
      countriesService.getFavorites().then((res) => {
        if (res.status === 200) {
          favorites.value = res.data;
          isLoading.value = false;
          records.value = res.data.length;
        }
      });
    };

    const removeFromFav = (country) => {
      countriesService
        .removeFromFavorites(country)
        .then((res) => {
          if (res.status === 200) {
            alert("Removed From Favorites");// implement notification from ui lib
            isLoading.value = true; 
            favorites.value = res.data;
            isLoading.value = false;
            records.value = res.data.length;
          }
        })
        .catch((e) => console.error(e));
    };

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
      fetchFavorites();
    });

    return {
      isLoading,
      favorites,
      page,
      records,
      removeFromFav,
    };
  },
};
</script>

<style scoped>
.mb-col {
  margin-bottom: 20px;
}
.width-100 {
  width: 100% !important;
}
</style>
