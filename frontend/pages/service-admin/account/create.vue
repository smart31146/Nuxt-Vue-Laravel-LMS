<template>
  <Html>
    <Head>
      <Title>管理者アカウント追加</Title>
    </Head>
  </Html>

  <section>
    <div class="nav-area" :class="{ 'is_open': globalStore.state.stateIsMenuOpen }">
      <nav class="gnav">
        <ul class="gnav-list">
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
        </ul>
      </nav>
    </div>
    <div class="content accont-content">
      <div class="inner">
        <section class="account table-page">
          <h1 class="sec-title account-title">管理者アカウント追加</h1>
          <p class="inner-text"><span>*</span>は必須入力</p>
          <form class="form account-form">
            <table class="form-table">
              <tbody class="form-tbody">
                <tr class="input-box">
                  <th>
                    <label for="administrator-name" class="label-name"
                      >管理者名<span>*</span></label
                    >
                  </th>
                  <td>
                    <input
                      type="text"
                      v-model="admin_name"
                      class="input-block"
                      id="administrator-name"
                      name="administrator-name"
                    />
                  </td>
                </tr>
                <tr class="input-box">
                  <th>
                    <label for="email" class="label-name"
                      >E-Mail<span>*</span></label
                    >
                  </th>
                  <td>
                    <input
                      type="text"
                      v-model="admin_email"
                      class="input-block"
                      id="email"
                      name="email"
                    />
                  </td>
                </tr>
                <tr class="input-box">
                  <th>
                    <label for="pass" class="label-name"
                      >パスワード<span>*</span></label
                    >
                  </th>
                  <td>
                    <input
                      type="text"
                      v-model="password"
                      class="input-block"
                      id="pass"
                      name="pass"
                    />
                  </td>
                </tr>
                <tr class="input-box">
                  <th>
                    <label for="start-date" class="label-name"
                      >利用開始日<span>*</span></label
                    >
                  </th>
                  <td>
                    <input
                      type="date"
                      v-model="start_date"
                      class="input-block"
                      id="start-date"
                      name="start-dates"
                    />
                  </td>
                </tr>
                <tr class="input-box">
                  <th>
                    <label for="end-date" class="label-name">利用終了日</label>
                  </th>
                  <td class="last">
                    <input
                      type="date"
                      v-model="end_date"
                      class="input-block"
                      id="end-date"
                      name="end-date"
                    />
                  </td>
                </tr>
              </tbody>
            </table>
            <button class="serch-btn btn" @click.prevent="store">作成</button>
          </form>
        </section>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import globalStore from '../../../store';
const admin_name = ref("");
const admin_email = ref("");
const password = ref("");
const start_date = ref("");
const end_date = ref("");
const error_message = ref<HTMLParagraphElement | null>(null);

const { storeAdmin } = admin();

const store = async () => {
  const fd: FormData = new FormData();
  fd.append("mode", "create");
  fd.append("admin_email", admin_email.value);
  fd.append("password", password.value);
  fd.append("admin_name", admin_name.value);
  fd.append("start_date", start_date.value);
  fd.append("end_date", end_date.value);

  error_message.value.innerHTML = await storeAdmin("store", fd);
  if (error_message.value.innerHTML) {
    window.scroll({ top: 0, behavior: "smooth" });
  }
};

definePageMeta({
  layout: "admin-after-login",
  middleware: "admin",
});
</script>
