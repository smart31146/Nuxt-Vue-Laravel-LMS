<template>
<Html>
<Head>
<Title>お問い合わせ</Title>
</Head>
</Html>

<section class="u-padding-top--3rem u-padding-bottom--3rem">
<h1 class="u-text-align--center u-margin-bottom--3rem">お問い合わせ</h1>

<p class="u-width__min--95vw-48rem u-margin-left--auto u-margin-right--auto u-margin-bottom--1_5rem u-color--red" ref="error_message"></p>

<form class="u-width__min--95vw-48rem u-margin-left--auto u-margin-right--auto">
<dl>
<dt class="u-margin-bottom--0_75rem">お名前</dt>
<dd class="u-margin-bottom--0_75rem"><input v-model="your_name" type="text" required></dd>
<dt class="u-margin-bottom--0_75rem">E-Mail</dt>
<dd class="u-margin-bottom--0_75rem"><input v-model="your_email" type="email" required autocomplete="email"></dd>
<dt class="u-margin-bottom--0_75rem">本文</dt>
<dd class="u-margin-bottom--0_75rem"><textarea v-model="your_body" required></textarea></dd>
</dl>
<p class="u-text-align--center"><button class="p-button p-button--green u-width--15rem" @click.prevent="submit">送信</button></p>
</form>
</section>
</template>

<script setup lang="ts">
import type { ContactInfo } from '@/types/index';

const your_name = ref('');
const your_email = ref('');
const your_body = ref('');
const error_message = ref<HTMLParagraphElement | null>(null);
const { contact } = useAuth();

const submit = async () =>
{

	const contactInfo: ContactInfo = {
        your_name: your_name.value,
        your_email: your_email.value,
        your_body: your_body.value,
    };

    error_message.value.innerHTML = await contact(contactInfo);
    if (error_message.value.innerHTML)
    {

        window.scroll({ top: 0, behavior: 'smooth'});

    }

}
</script>