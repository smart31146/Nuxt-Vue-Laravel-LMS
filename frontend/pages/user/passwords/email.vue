<template>
<Html>
<Head>
<Title>現在登録しているE-Mailを入力</Title>
</Head>
</Html>

<section class="u-padding-top--3rem u-padding-bottom--3rem">
    
  <div class="flex m-auto mt-48 mb-12 w-1/3 bg-white min-h-full flex-1 flex-col justify-center py-24 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <img class="mx-auto h-24 w-auto" src="/images/logo.png" alt="Your Company" />
      <h2 class="mt-10 text-center text-5xl font-bold leading-9 tracking-tight text-gray-900">現在登録しているE-Mailを入力</h2>
    </div>
    
    <div class="mt-14 w-3/4 m-auto text-3xl">
      <p class="mb-4 text-lg text-red-500" ref="error_message"></p>
      <form class="space-y-6" action="#" method="POST">
        <div>
          <label for="email" class="block text-4xl font-medium leading-6 text-gray-900">E-Mail</label>
          <div class="mt-4">
            <input v-model="user_email" id="email" name="your_email" type="email" autocomplete="email" required="" class="block w-full rounded-md border-0 py-3.5 px-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-3xl sm:leading-6" />
          </div>
        </div>
    
        <div>
          <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 mt-12 px-3 py-4 text-3xl font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"  @click.prevent="submit">送信</button>
        </div>
      </form>
    <NuxtLink class="mt-4" to="/"
      >
      <button type="button" class="flex w-full justify-center rounded-md bg-indigo-600 mt-12 px-3 py-4 text-3xl font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"  
    >ログインページに戻る</button>
    </NuxtLink
    >
    </div>
  </div>
</section>
</template>

<script setup lang="ts">
import type { UserResetInfo } from '@/types/index';

const user_email = ref('');
const error_message = ref<HTMLParagraphElement | null>(null);
const { userPasswordReset } = useAuth();

const submit = async () =>
{

    const resetInfo: UserResetInfo = {
        user_email: user_email.value,
    };

    error_message.value.innerHTML = await userPasswordReset(resetInfo);

}

definePageMeta({
    layout: 'user-before-login',
});
</script>