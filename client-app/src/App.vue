<template>
  <el-container class="app-viewport">
    <el-header class="main-container">
      <el-menu
        class="el-menu-demo"
        mode="horizontal"
        background-color="#545c64"
        text-color="#fff"
        active-text-color="#ffd04b"
        color="accent"
        @select="(e) => handleSelect(e)"
      >
        <el-menu-item index="1">Home</el-menu-item>
        <el-menu-item index="2">Countries</el-menu-item>
        <el-menu-item index="3">Favorites</el-menu-item>
        <el-menu-item index="4" class="dock-right">Sign Up</el-menu-item>
        <el-menu-item v-if='!isLoggedIn' index="5" class="dock-right">Log In</el-menu-item>
        <el-menu-item v-else index="6" class="dock-right">Log Out</el-menu-item>
      </el-menu>
    </el-header>
    <el-container>
      <el-main>
        <router-view @activeItem="updateActive" />
      </el-main>
    </el-container>
    <el-footer class="footer"> </el-footer>
  </el-container>
</template>

<script>
import { ref } from "vue";
import { useRouter } from "vue-router";

export default {
  name: "App",
  setup() {
    const isLoggedIn = ref(false);
    const router = useRouter();
    const appRoutes = Array.from(router.getRoutes());
    var activeIndex = ref("1");

    const updateActive = (index) => {
      activeIndex.value = index;
    };

    const handleSelect = (index) => {
      router.push(appRoutes[index - 1].path).catch((e) => console.error(e));
      // updateActive(index);
    };

    return {
      appRoutes,
      activeIndex,
      updateActive,
      handleSelect,
      isLoggedIn,
    };
  },
};
</script>

<style scoped>
.main-container {
  padding: 0px !important;
}

.el-menu-demo > .el-menu-item.dock-right {
  float: right !important;
}

.app-viewport {
  height: 100vh;
}

.footer {
  background-color: #303133;
  color: #e6a23c;
}
</style>

