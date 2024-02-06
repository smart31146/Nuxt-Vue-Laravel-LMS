<template>
  <NuxtLayout name="admin-before-login">
    <Html>
      <Head>
        <Title>パスワードリセットの完了</Title>
      </Head>
    </Html>

    <section class="u-padding-top--3rem u-padding-bottom--3rem">
      <div class="password">
        <div class="password-inner">
          <h1 class="sec-title password-title">パスワードリセットの完了</h1>
          <p class="result inner-text">
            ログインページでリセットしたパスワードを使い、ログインしてください。
          </p>
          <NuxtLink class="password-text-link border" to="/service-admin"
            >ログインページに戻る</NuxtLink
          >
        </div>
      </div>
    </section>
  </NuxtLayout>
</template>

<script setup lang="ts">
definePageMeta({
  layout: false,
});
</script>
