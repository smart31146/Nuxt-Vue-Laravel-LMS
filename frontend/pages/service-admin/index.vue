<template>
  <Html>
    <Head>
      <Title>運営者ログイン</Title>
    </Head>
  </Html>

  <div class="login">
    <div class="login-inner">
      <h1 class="sec-title login-title">運営者ログイン</h1>
      <form class="login-form">
        <div class="login-block login-email">
          <label for="email" class="label-name">E-Mail</label>
          <input
            v-model="admin_email"
            type="email"
            id="email"
            class="login-input-update"
            name="your_email"
          />
        </div>
        <div class="login-block login-pass">
          <label for="password" class="label-name">パスワード</label>
          <input
            v-model="password"
            type="password"
            id="password"
            class="login-input-update"
            name="your_password"
          />
        </div>
        <button class="login-btn" @click.prevent="login">ログイン</button>
      </form>
      <NuxtLink
        class="login-text-link border"
        href="/service-admin/passwords/email"
        >パスワードをお忘れの方</NuxtLink
      >
    </div>
  </div>
</template>

<script setup lang="ts">
import type { AdminLoginInfo } from "@/types/index";

const admin_email = ref("");
const password = ref("");
const error_message = ref<HTMLParagraphElement | null>(null);
const { adminLogin } = useAuth();

const login = async () => {
  const loginInfo: AdminLoginInfo = {
    admin_email: admin_email.value,
    password: password.value,
  };

  error_message.value.innerHTML = await adminLogin(loginInfo);
  if (error_message.value.innerHTML) {
    window.scroll({ top: 0, behavior: "smooth" });
  }
};

definePageMeta({
  layout: "admin-before-login",
});
</script>
