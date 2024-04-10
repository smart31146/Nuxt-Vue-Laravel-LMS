<template>
  <Html>
  <Head>
  <Title>会員ログイン</Title>
  </Head>
  </Html>
  
  <div class="flex m-auto mt-48 mb-12 w-4/5 md:w-2/3 lg:w-1/3 bg-white min-h-full flex-1 flex-col justify-center py-24 lg:px-4">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <img class="mx-auto h-24 w-auto" src="/images/logo.png" alt="Your Company" />
      <h2 class="mt-10 text-center text-5xl font-bold leading-9 tracking-tight text-gray-900">会員ログイン</h2>
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
          <div class="flex items-center justify-between">
            <label for="password" class="block text-4xl font-medium leading-6 text-gray-900">パスワード</label>
            <div class="text-sm">
              <NuxtLink href="/user/passwords/email" class="font-semibold text-indigo-600 hover:text-indigo-500">>パスワードをお忘れの方</NuxtLink>
            </div>
          </div>
          <div class="mt-4">
            <input v-model="password" id="password" name="password" type="password" autocomplete="current-password" required="" class="block w-full rounded-md border-0 py-3.5 px-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-3xl sm:leading-6" />
          </div>
        </div>
  
        <div>
          <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 mt-12 px-3 py-4 text-3xl font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" @click.prevent="login">ログイン</button>
        </div>
      </form>
  
    </div>
  </div>
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
  definePageMeta({
      layout: 'user-before-login',
  });
  </script>