<template>
  <Html>
    <Head>
      <Title>新規会員登録</Title>
    </Head>
  </Html>

  <section class="u-padding-top--3rem u-padding-bottom--3rem">
    <h1 class="u-text-align--center u-margin-bottom--3rem">新規会員登録</h1>
    <p
      class="u-width__min--95vw-48rem u-margin-left--auto u-margin-right--auto u-margin-bottom--1_5rem u-color--red"
      ref="error_message"
    ></p>

    <form class="u-width__min--95vw-48rem u-margin-left--auto u-margin-right--auto">
      <dl class="u-margin-bottom--1_5rem">
        <dt class="u-margin-bottom--0_75rem">ユーザー名</dt>
        <dd class="u-margin-bottom--0_75rem">
          <input v-model="user_name" type="text" />
        </dd>
        <dt class="u-margin-bottom--0_75rem">E-Mail</dt>
        <dd class="u-margin-bottom--0_75rem">
          <input v-model="user_email" type="email" />
        </dd>
        <dt class="u-margin-bottom--0_75rem">パスワード</dt>
        <dd class="u-margin-bottom--0_75rem">
          <input v-model="password" type="password" />
        </dd>
        <dt class="u-margin-bottom--0_75rem">パスワード再入力</dt>
        <dd class="u-margin-bottom--0_75rem">
          <input v-model="password_confirmation" type="password" />
        </dd>
      </dl>
      <p
        class="u-margin-left--auto u-margin-right--auto u-width--fit-content u-margin-bottom--0_75rem"
      >
        <button
          class="p-button p-button--green u-width--15rem"
          @click.prevent="registration"
        >
          登録
        </button>
      </p>
    </form>
  </section>
</template>

<script setup lang="ts">
import type { UserRegistrationInfo, UserLoginInfo } from "@/types/index";

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
</script>
