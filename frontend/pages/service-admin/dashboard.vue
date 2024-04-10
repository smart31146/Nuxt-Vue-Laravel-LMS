<template>
  <Html>
    <Head>
      <Title>管理者ダッシュボード</Title>
    </Head>
  </Html>

  <section>
    <div class="nav-area" :class="{ 'is_open': store.state.stateIsMenuOpen }">
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
    <div class="content">
      <div class="inner">
        <section class="dashboard table-page">
        
          <h1 class="sec-title dashboard-title">
            修了証の申請があったユーザー
          </h1>
          
          <div class="table-area">
            <div class="table-inner">
              <table class="curriculum-table table">
                <thead>
                  <tr>
                    <th>ユーザー名</th>
                    <th>申請日時</th>
                    <th>操作</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, i) in user_data" :key="i">
                    <td>
                      <NuxtLink
                        :to="`/service-admin/account/show/${item.user_id}`"
                        class="u-text-decoration--underline"
                        >{{ item.user_name }}</NuxtLink
                      >
                    </td>
                    <td>{{ dateTimeFormat(item.created_at).value }}</td>
                    <td>
                      <ul class="u-display--flex u-flex__gap--0_5rem">
                        <li>
                          <span
                            @click="update(item.user_id)"
                            class="u-cursor--pointer"
                            ><i class="fa fa-file-circle-check"></i
                          ></span>
                        </li>
                      </ul>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </section>
      </div>
    </div>
    
    <PaginationComponent
      :data="user_object"
      :limit="3"
      :keep-length="false"
      @pagination-change-page="pagingUserData"
    />

  </section>
</template>

<script setup lang="ts">

  import type {
  PaginatedResponse,
  DataType,
  RequestCertificateData,
} from "@/types/index";
import store from "@/store";
const user_object = ref<PaginatedResponse<DataType> | null | undefined>();
const user_data = ref<RequestCertificateData | null>();
const { getRequestCertificate, updateCertificate } = curriculum();

const pagingUserData = async (page: number) => {
  user_object.value = await getRequestCertificate(page);
  user_data.value = user_object.value["data"];
};

const update = async (user_id: number) => {
  const fd: FormData = new FormData();
  fd.append("user_id", user_id.toString());

  await updateCertificate(fd);
};

const { adminLogout } = useAuth();

const logout = async () => {
  adminLogout();
};

const init = async () => {
  user_object.value = await getRequestCertificate(1);
  user_data.value = user_object.value["data"];
};
init();

definePageMeta({
  layout: "admin-after-login",
  middleware: "admin",
});
</script>
