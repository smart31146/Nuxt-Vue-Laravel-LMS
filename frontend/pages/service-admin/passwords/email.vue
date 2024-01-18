<template>
<NuxtLayout name="admin-before-login">
<Html>
<Head>
<Title>現在登録しているE-Mailを入力</Title>
</Head>
</Html>

<section class="u-padding-top--3rem u-padding-bottom--3rem">
<h1 class="u-text-align--center u-margin-bottom--3rem">現在登録しているE-Mailを入力</h1>
<p class="u-width__min--95vw-48rem u-margin-left--auto u-margin-right--auto u-margin-bottom--1_5rem u-color--red" ref="error_message"></p>

<form class="u-width__min--95vw-48rem u-margin-left--auto u-margin-right--auto">
<dl class="u-margin-bottom--1_5rem">
<dt class="u-margin-bottom--0_75rem">E-Mail</dt>
<dd class="u-margin-bottom--0_75rem"><input v-model="admin_email" type="email" required autocomplete="email" autofocus></dd>
</dl>

<menu class="u-margin-left--auto u-margin-right--auto u-width--fit-content">
<li class="u-margin-bottom--0_75rem"><button class="p-button p-button--green u-width--15rem" @click.prevent="submit">送信</button></li>
<li class="u-text-align--center"><NuxtLink class="u-text-decoration--underline" href="/service-admin">ログインページに戻る</NuxtLink></li>
</menu>
</form>
</section>
</NuxtLayout>
</template>

<script setup lang="ts">
import type { AdminResetInfo } from '@/types/index';

const admin_email = ref('');
const error_message = ref<HTMLParagraphElement | null>(null);
const { adminPasswordReset } = useAuth();

definePageMeta(
{
    layout: false,
});

const submit = async () =>
{

    const resetInfo: AdminResetInfo = {
        admin_email: admin_email.value,
    };

    error_message.value.innerHTML = await adminPasswordReset(resetInfo);

}
</script>