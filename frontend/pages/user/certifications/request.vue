<template>
<Html>
<Head>
<Title>修了証の申請完了</Title>
</Head>
</Html>

<section>
<div class="w-full pt-64 m-auto flex flex-col gap-4 justify-center items-center mb-12">
    
    <h1 class="text-3xl md:text-5xl">修了証の申請完了</h1>
    <p class="text-2xl md:text-3xl">修了証の申請が完了しました。</p>
    <p class="mt-8 text-2xl md:text-3xl underline"><NuxtLink to="/user/certifications" class="u-text-decoration--underline">元に戻る</NuxtLink></p>
</div>

</section>
</template>

<script setup lang="ts">
definePageMeta({
    layout: 'user-after-login',
    middleware: 'user',
});
</script>