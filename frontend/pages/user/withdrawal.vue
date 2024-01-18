<template>
<Html>
<Head>
<Title>退会の確認</Title>
</Head>
</Html>

<section>
<p class="u-margin-left--auto u-margin-right--auto u-margin-bottom--1_5rem u-width--fit-content">退会するとこのサービスを二度と利用できなくなります。<br>よろしいでしょうか。</p>
<p class="u-margin-left--auto u-margin-right--auto u-margin-bottom--1_5rem u-width--fit-content"><span class="p-button p-button--green" @click.prevent="withdrawal">退会する</span></p>
</section>
</template>

<script setup lang="ts">
const { userWithdrawal } = useAuth();

const withdrawal = async () =>
{

    await userWithdrawal();

}

definePageMeta({
    layout: 'user-after-login',
    middleware: 'user',
});
</script>