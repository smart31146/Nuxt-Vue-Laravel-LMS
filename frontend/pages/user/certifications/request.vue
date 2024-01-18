<template>
<Html>
<Head>
<Title>修了証の申請完了</Title>
</Head>
</Html>

<section>
<p class="u-width__min--95vw-64rem u-margin-left--auto u-margin-right--auto u-margin-bottom--1_5rem u-text-align--right"><NuxtLink to="/user/certifications" class="u-text-decoration--underline">元に戻る</NuxtLink></p>
<h1 class="u-width__min--95vw-64rem u-margin-left--auto u-margin-right--auto u-margin-bottom--1_5rem">修了証の申請完了</h1>
<p class="u-width__min--95vw-48rem u-margin-left--auto u-margin-right--auto u-margin-bottom--1_5rem">修了証の申請が完了しました。</p>
</section>
</template>

<script setup lang="ts">
definePageMeta({
    layout: 'user-after-login',
    middleware: 'user',
});
</script>