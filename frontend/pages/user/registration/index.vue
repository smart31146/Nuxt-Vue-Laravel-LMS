<template>
  <Html>
    <Head>
      <Title>新規会員登録</Title>
    </Head>
  </Html>

  <section>
    <div class="flex m-auto mt-48 mb-12 w-1/3 bg-white min-h-full flex-1 flex-col justify-center py-24 lg:px-8">
      <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <img class="mx-auto h-24 w-auto" src="/images/logo.png" alt="Your Company" />
        <h2 class="mt-10 text-center text-5xl font-bold leading-9 tracking-tight text-gray-900">新規会員登録</h2>
      </div>
      
      <div class="mt-14 w-3/4 m-auto text-3xl">
        <p class="mb-4 text-lg text-red-500" ref="error_message"></p>
        <form class="space-y-6" action="#" method="POST">
          <div>
            <label for="user-name" class="label-name">ユーザー名<span>*</span></label>
            <div class="mt-4">
              <input type="text"
              v-model="user_name"
              maxlength="100"
              id="user-name"
              name="user-name" required="" 
              class="block w-full rounded-md border-0 py-3.5 px-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-3xl sm:leading-6" />
            </div>
          </div>
          <div>
            <label for="email" class="block text-4xl font-medium leading-6 text-gray-900">E-Mail<span>*</span></label>
            <div class="mt-4">
              <input v-model="user_email" id="email" name="email" type="email" autocomplete="email" required="" class="block w-full rounded-md border-0 py-3.5 px-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-3xl sm:leading-6" />
            </div>
          </div>
    
          <div>
            <div class="flex items-center justify-between">
              <label for="pass" class="block text-4xl font-medium leading-6 text-gray-900">パスワード<span>*</span></label>
              
            </div>
            <div class="mt-4">
              <input v-model="password" id="pass" name="pass" type="password" autocomplete="current-password" required="" class="block w-full rounded-md border-0 py-3.5 px-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-3xl sm:leading-6" />
            </div>
          </div>
          <div>
            <div class="flex items-center justify-between">
              <label for="password_confirmation" class="block text-4xl font-medium leading-6 text-gray-900">パスワード<span>*</span></label>
              
            </div>
            <div class="mt-4">
              <input v-model="password_confirmation" id="password_confirmation" name="password_confirmation" type="password" autocomplete="current-password" required="" class="block w-full rounded-md border-0 py-3.5 px-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-3xl sm:leading-6" />
            </div>
          </div>
          <div>
            <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 mt-12 px-3 py-4 text-3xl font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" @click.prevent="registration">登録</button>
          </div>
        </form>
    
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import type { UserRegistrationInfo, UserLoginInfo } from "@/types/index";
import globlaStore from "@/store";
const user_name = ref("");
const user_email = ref("");
const password = ref("");
const password_confirmation = ref("");
const error_message = ref<HTMLParagraphElement | null>(null);

// ユーザー認証関連の関数のインポート
const { userRegistration } = useAuth();

const registration = async () => {
  // データのバリデーションを追加
  if (
    !user_name.value ||
    !user_email.value ||
    !password.value ||
    !password_confirmation.value
  ) {
    error_message.value.innerHTML = "全てのフィールドを入力してください。";
    return;
  }

  try {
    const registrationInfo: UserRegistrationInfo = {
      user_name: user_name.value,
      user_email: user_email.value,
      password: password.value,
      password_confirmation: password_confirmation.value,
    };

    // ユーザー登録処理
    error_message.value.innerHTML = await userRegistration(registrationInfo);

    // エラーメッセージがある場合、ページトップへスクロール
    if (error_message.value.innerHTML) {
      window.scroll({ top: 0, behavior: "smooth" });
    }
  } catch (error) {
    console.error("登録処理中にエラーが発生しました:", error);
    error_message.value.innerHTML = "登録処理中にエラーが発生しました。";
  }
};

definePageMeta({
  layout: 'user-before-login',
});
</script>
