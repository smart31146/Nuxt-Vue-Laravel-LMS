<template>
  <Html>
    <Head>
      <Title>パスワードリセットの完了</Title>
    </Head>
  </Html>

  <section class="mt-48 m-auto">
    <div class="password">
      <div class="password-inner">
        <h1 class="sec-title password-title">パスワードリセットの完了</h1>
        <p class="result inner-text">
          ログインページでリセットしたパスワードを使い、ログインしてください。
        </p>

        <NuxtLink class="mt-4" to="/">
          <button
            type="button"
            class="flex w-full justify-center rounded-md bg-indigo-600 mt-12 px-3 py-4 text-3xl font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
          >
            ログインページに戻る
          </button>
        </NuxtLink>
      </div>
    </div>
  </section>
</template>
<script>
definePageMeta({
  layout: "user-before-login",
});
</script>
