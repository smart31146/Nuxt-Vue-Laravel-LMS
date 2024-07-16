<template>
  <Html>
    <Head>
      <Title>ユーザーの作成完了</Title>
    </Head>
  </Html>

  <section>
    <div class="nav-area" :class="{ 'is_open': store.state.stateIsMenuOpen }">
      <nav class="gnav">
        <ul class="gnav-list">
          <li class="gnav-item">
              <NuxtLink to="/service-admin/dashboard/" class="gnav-link"
                >修了証管理</NuxtLink
              >
          </li>
          <li class="gnav-item">
            <NuxtLink to="/service-admin/categories/" class="gnav-link"
              >カテゴリ管理</NuxtLink
            >
          </li>
          <li class="gnav-item">
            <NuxtLink to="/service-admin/curriculums/" class="gnav-link"
              >カリキュラム管理</NuxtLink
            >
          </li>
          <li class="gnav-item">
            <NuxtLink to="/service-admin/user/" class="gnav-link"
              >ユーザー管理</NuxtLink
            >
          </li>
          <li class="gnav-item">
            <NuxtLink to="/service-admin/account/" class="gnav-link"
              >管理者アカウント管理</NuxtLink
            >
          </li>
          <li class="gnav-item">
            <span @click.prevent="logout" class="gnav-link logout"
              >ログアウト</span
            >
          </li>
          <li class="gnav-item">
            <NuxtLink class="gnav-link" to="/service-admin/user"
              >ユーザー管理に戻る</NuxtLink
            >
          </li>
        </ul>
      </nav>
    </div>
    <div class="content">
      <h1 class="result sec-title account-title">ユーザーの作成完了</h1>
      <p class="result inner-text">ユーザーの作成が完了しました。</p>
    </div>
  </section>
</template>

<script setup lang="ts">
import store from "@/store";
const { adminLogout } = useAuth();

const logout = async () => {
  adminLogout();
};

definePageMeta({
  layout: "admin-after-login",
  middleware: "admin",
});
</script>
