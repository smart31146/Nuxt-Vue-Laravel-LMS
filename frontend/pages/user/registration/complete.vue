<template>
<Html>
<Head>
<Title>ユーザーの新規登録の官僚</Title>
</Head>
</Html>

<section>
  <div class="content">
    <h1 class="result sec-title account-title">新規登録が完了しました。</h1>
    <p class="result inner-text">ログイン画面で、入力したメールアドレスとパスワードでログインしてください</p>
  </div>
</section>
</template>
<script setup lang="ts">
definePageMeta({
  layout: "user-before-login",
});
</script>