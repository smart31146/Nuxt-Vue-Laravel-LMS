<template>
<Html>
<Head>
<Title>会員ログイン</Title>
</Head>
</Html>

<section class="u-padding-top--3rem u-padding-bottom--3rem">
<h1 class="u-text-align--center u-margin-bottom--3rem">会員ログイン</h1>
<p class="u-width__min--95vw-48rem u-margin-left--auto u-margin-right--auto u-margin-bottom--1_5rem u-color--red" ref="error_message"></p>

<form class="u-width__min--95vw-48rem u-margin-left--auto u-margin-right--auto">
<dl class="u-margin-bottom--1_5rem">
<dt class="u-margin-bottom--0_75rem">E-Mail</dt>
<dd class="u-margin-bottom--0_75rem"><input v-model="user_email" type="email"></dd>
<dt class="u-margin-bottom--0_75rem">パスワード</dt>
<dd class="u-margin-bottom--0_75rem"><input v-model="password" type="password"></dd>
</dl>

<menu class="u-margin-left--auto u-margin-right--auto u-width--fit-content">
<li class="u-margin-bottom--0_75rem"><button class="p-button p-button--green u-width--15rem" @click.prevent="login">ログイン</button></li>
<li class="u-text-align--center"><NuxtLink class="u-text-decoration--underline" href="/user/passwords/email">パスワードをお忘れの方</NuxtLink></li>
</menu>
</form>
</section>
</template>

<script setup lang="ts">
import type { UserLoginInfo } from '@/types/index';

const user_email = ref('');
const password = ref('');
const error_message = ref<HTMLParagraphElement | null>(null);
const { userLogin } = useAuth();

const login = async () =>
{

    const loginInfo: UserLoginInfo = {
        user_email: user_email.value,
        password: password.value,
    };

    error_message.value.innerHTML = await userLogin(loginInfo);
    if (error_message.value.innerHTML)
    {

        window.scroll({ top: 0, behavior: 'smooth'});

    }

}
</script>