<template>
  <el-container class="main-container">
    <div>
    <el-form
      :label-position="labelPosition.value"
      label-width="100px"
      :model="formLabelAlign"
      justify="center"
    >
      <el-form-item label="Username">
        <el-input label="Username" placeholder="Username" v-model="loginState.username"></el-input>
      </el-form-item>
      <el-form-item label="Password">
        <el-input v-model="loginState.password" show-password></el-input>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" class="dock-right" @click="login"
          >Log In</el-button
        >
      </el-form-item>
    </el-form>
    </div>
  </el-container>
</template> 

<script>
import AuthService from "../../services/AuthService";
import { useRouter } from "vue-router";
import { ref } from "vue";

export default {
  name: "Login",
  components: {},
  emits: ["activeItem"],
  setup(props, { emit }) {
    const router = useRouter();
    const authService = new AuthService();
    const labelPosition = ref("right");
    const formLabelAlign = ref({
      name: "",
      region: "",
      type: "",
    });
    const loginState = ref({
      username: "",
      password: "",
    });
    const login = () => {
      authService
        .login(loginState.value)
        .then((res) => {
          if (res.status === 200) {
            localStorage.setItem("accessToken", res.data.accessToken);
            router.push("/").catch((e) => console.error(e));
            emit("activeItem", "1");
          }
        })
        .catch((e) => {
          console.error(e);
        });
    };

    return {
      loginState,
      formLabelAlign,
      labelPosition,
      login,
    };
  },
};
</script>

<style lang="css" scoped>
.el-container.main-container {
  justify-content: center;
  height: 100%;
  position: relative;
}
.dock-right {
  float: right !important;
}
</style>

