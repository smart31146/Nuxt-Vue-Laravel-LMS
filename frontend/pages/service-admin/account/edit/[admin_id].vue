<template>
  <Html>
    <Head>
      <Title>管理者アカウント編集</Title>
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
            <NuxtLink to="/service-admin/account" class="gnav-link"
              >管理者アカウント管理に戻る</NuxtLink
            >
          </li>
        </ul>
      </nav>
    </div>
    <div class="content accont-content">
      <div class="inner">
        <section class="account table-page">
          <h1 class="sec-title account-title">管理アカウント編集</h1>
          <p class="inner-text"><span>*</span>は必須入力</p>
          <form class="form account-form">
            <table class="form-table">
              <tbody class="form-tbody">
                <tr class="input-box">
                  <th>
                    <label for="administrator-name" class="label-name"
                      >管理者名</label
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
                    <label for="email" class="label-name">E-Mail</label>
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
                      >パスワード(必要な場合)</label
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
                    <label for="end-date" class="label-name"
                      >利用終了日<span>*</span></label
                    >
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
            <button class="serch-btn btn" @click.prevent="update">更新</button>
          </form>
        </section>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import type { SelectOptionItems, Admin } from "@/types/index";
import store from "@/store";
const admin_data = ref<Admin | null>();
const admin_email = ref("");
const password = ref("");
const admin_name = ref("");
const start_date = ref<string | null>();
const end_date = ref<string | null>();
const route = useRoute();
const error_message = ref<HTMLParagraphElement | null>(null);

const { storeAdmin, getOneAdminData } = admin();

const update = async () => {
  const fd: FormData = new FormData();
  fd.append("admin_id", route.params.admin_id.toString());
  fd.append("admin_email", admin_email.value);

  if (password.value !== "") {
    fd.append("password", password.value);
  }

  fd.append("admin_name", admin_name.value);
  fd.append("start_date", start_date.value);
  fd.append("end_date", end_date.value);

  error_message.value.innerHTML = await storeAdmin("update", fd);
  if (error_message.value.innerHTML) {
    window.scroll({ top: 0, behavior: "smooth" });
  }
};
const { adminLogout } = useAuth();

const logout = async () => {
  adminLogout();
};
const init = async () => {
  const fd: FormData = new FormData();
  fd.append("mode", "update");
  fd.append("admin_id", route.params.admin_id.toString());
  admin_data.value = await getOneAdminData(fd);

  if (!admin_data.value) {
    showError({
      statusCode: 404,
      message: "データが存在しません",
    });
  }

  admin_email.value = admin_data.value["admin_email"];
  admin_name.value = admin_data.value["admin_name"];
  start_date.value = admin_data.value["start_date"];
  end_date.value = admin_data.value["end_date"];
};
init();

definePageMeta({
  layout: "admin-after-login",
  middleware: "admin",
});
</script>
