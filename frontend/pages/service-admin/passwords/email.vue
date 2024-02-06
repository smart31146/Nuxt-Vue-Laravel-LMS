<template>
  <NuxtLayout name="admin-before-login">
    <Html>
      <Head>
        <Title>現在登録しているE-Mailを入力</Title>
      </Head>
    </Html>

    <section class="u-padding-top--3rem u-padding-bottom--3rem">
      <div class="password">
        <div class="password-inner">
          <h1 class="sec-title password-title">
            現在登録している<br class="sp" />E-Mailを入力
          </h1>
          <p
            class="u-width__min--95vw-48rem u-margin-left--auto u-margin-right--auto u-margin-bottom--1_5rem u-color--red"
            ref="error_message"
          ></p>
          <form class="password-form">
            <div class="password-block password-email">
              <label for="email" class="label-name">E-Mail</label>
              <input
                v-model="admin_email"
                type="email"
                id="email"
                class="password-input"
                name="your_email"
              />
            </div>
            <button class="password-btn" @click.prevent="submit">送信</button>
          </form>
          <NuxtLink class="password-text-link border" to="/service-admin"
            >ログインページに戻る</NuxtLink
          >
        </div>
      </div>
    </section>
  </NuxtLayout>
</template>

<script setup lang="ts">
import type { AdminResetInfo } from "@/types/index";

const admin_email = ref("");
const error_message = ref<HTMLParagraphElement | null>(null);
const { adminPasswordReset } = useAuth();

definePageMeta({
  layout: false,
});

const submit = async () => {
  const resetInfo: AdminResetInfo = {
    admin_email: admin_email.value,
  };

  error_message.value.innerHTML = await adminPasswordReset(resetInfo);
};
</script>
