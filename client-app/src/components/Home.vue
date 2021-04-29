<template>
  <el-container>
    <h1>Home</h1>
    <l-map
      v-model="zoom"
      :center="[47.41322, -1.219482]"
      @move="log('move')"
    ></l-map>
  </el-container>
</template>

<script>
// import AuthService from "../../services/AuthService";
import { onBeforeMount } from "vue";
import { useRouter } from "vue-router";

import {
  LMap,

} from "@vue-leaflet/vue-leaflet";
import "leaflet/dist/leaflet.css";

export default {
  name: "Home",
  components: {
    LMap,
  },
  setup(props, { emit }) {
    const router = useRouter();
    const zoom = 0;
    const center = [47.41322, -1.219482];

    const move = () => {
      console.log('moving map...')
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
    return {
      zoom,
      center,
      move
    };
  },
};
</script>

<style scoped>
</style>

