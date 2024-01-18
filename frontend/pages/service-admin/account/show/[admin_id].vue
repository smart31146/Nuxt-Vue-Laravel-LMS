<template>
  <Html>
    <Head>
      <Title>管理者アカウント詳細</Title>
    </Head>
  </Html>

  <section>
    <div class="nav-area" :class="{ 'is_open': store.state.stateIsMenuOpen }">
      <nav class="gnav">
        <ul class="gnav-list">
          <li class="gnav-item">
            <NuxtLink to="/service-admin/account/" class="gnav-link"
              >管理者アカウント管理に戻る</NuxtLink
            >
          </li>
        </ul>
      </nav>
    </div>
    <div class="content accont-content">
      <div class="inner">
        <section class="account table-page">
          <h1 class="result sec-title account-title">管理者アカウント詳細</h1>
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
                    {{ admin_name }}
                  </td>
                </tr>
                <tr class="input-box">
                  <th>
                    <label for="email" class="label-name">E-Mail</label>
                  </th>
                  <td>
                    {{ admin_email }}
                  </td>
                </tr>
                <tr class="input-box">
                  <th>
                    <label for="start-date" class="label-name"
                      >利用開始日</label
                    >
                  </th>
                  <td>
                    {{ start_date }}
                  </td>
                </tr>
                <tr class="input-box">
                  <th>
                    <label for="end-date" class="label-name">利用終了日</label>
                  </th>
                  <td class="last">
                    {{ end_date }}
                  </td>
                </tr>
              </tbody>
            </table>
          </form>
        </section>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import type { SelectOptionItems, Admin } from "@/types/index";
import { AdminType } from "@/types/const";
import store from "@/store";
const admin_data = ref<Admin | null>();
const admin_email = ref<string | null>();
const admin_name = ref<string | null>();
const adminTypeOptions = ref(<SelectOptionItems | null>[]);
const admin_type = ref<string | null>();
const start_date = ref<string | null>();
const end_date = ref<string | null>();

const route = useRoute();

const { getOneAdminData } = admin();

const init = async () => {
  const fd: FormData = new FormData();
  fd.append("admin_id", route.params.admin_id.toString());
  admin_data.value = await getOneAdminData(fd);

  if (!admin_data.value) {
    showError({
      statusCode: 404,
      message: "データが存在しません",
    });
  }

  adminTypeOptions.value = arrangeAsSelectOptions(AdminType);

  for (let i = 0; i < adminTypeOptions.value?.length; i++) {
    if (
      adminTypeOptions.value[i]["key"] ===
      admin_data.value["admin_type"].toString()
    ) {
      admin_type.value = adminTypeOptions.value[i]["value"];
    }
  }

  admin_email.value = admin_data.value["admin_email"];
  admin_name.value = admin_data.value["admin_name"];
  start_date.value = dateFormat(admin_data.value["start_date"]).value;
  end_date.value = admin_data.value["end_date"]
    ? dateFormat(admin_data.value["end_date"]).value
    : "";
};
init();

definePageMeta({
  layout: "admin-after-login",
  middleware: "admin",
});
</script>
