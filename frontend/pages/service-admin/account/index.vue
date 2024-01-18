<template>
  <Html>
    <Head>
      <Title>管理者アカウント管理</Title>
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
          <li class="gnav-item">
            <NuxtLink class="gnav-link" to="/service-admin/account/create"
              >新規追加</NuxtLink
            >
          </li>
        </ul>
      </nav>
    </div>
    <div class="content">
      <div class="inner">
        <section class="account table-page">
          <h1 class="sec-title account-title">管理アカウント管理</h1>
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
                      type="search"
                      v-model="admin_name"
                      class="input-block"
                      id="administrator-name"
                      name="administrator-name"
                    />
                  </td>
                </tr>
                <tr class="select-box">
                  <th>
                    <label for="administrator-type" class="label-name"
                      >管理者タイプ</label
                    >
                  </th>
                  <td>
                    <SelectComponent
                      ref="adminTypeSelect"
                      item_name="admin_type"
                      defaultValue=""
                      :data="adminTypeOptions"
                    />
                  </td>
                </tr>
                <tr class="select-box">
                  <th>
                    <label for="situation" class="label-name">状態</label>
                  </th>
                  <td class="last">
                    <SelectComponent
                      ref="statusSelect"
                      item_name="status"
                      defaultValue=""
                      :data="statusOptions"
                    />
                  </td>
                </tr>
              </tbody>
            </table>
            <button class="serch-btn" @click.prevent="search">
              <i class="fa-solid fa-magnifying-glass fa-icon"></i>
            </button>
          </form>
          <div class="table-area">
            <div class="table-inner">
              <table class="curriculum-table table table-body">
                <thead>
                  <tr>
                    <th>管理者名</th>
                    <th>管理者タイプ</th>
                    <th>利用開始日</th>
                    <th>利用終了日</th>
                    <th>ステータス</th>
                    <th>操作</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, i) in admin_data" :key="i">
                    <td>{{ item.admin_name }}</td>
                    <td>{{ AdminType.get(item.admin_type.toString()) }}</td>
                    <td>{{ dateTimeFormat(item.start_date).value }}</td>
                    <td>
                      {{
                        item.end_date ? dateTimeFormat(item.end_date).value : ""
                      }}
                    </td>
                    <td>{{ AdminStatus.get(item.status) }}</td>
                    <td>
                      <ul class="u-display--flex u-flex__gap--0_5rem">
                        <li>
                          <NuxtLink
                            :to="`/service-admin/account/edit/${item.admin_id}`"
                            ><i class="fa-solid fa-pen-to-square fa-icon"></i
                          ></NuxtLink>
                        </li>
                        <li v-if="item.status === 'A'">
                          <span
                            @click="destroy(item.admin_id)"
                            class="u-cursor--pointer"
                            ><i class="fa-solid fa-trash fa-icon"></i
                          ></span>
                        </li>
                        <li v-if="item.status === 'D'">
                          <span
                            @click="recover(item.admin_id)"
                            class="u-cursor--pointer"
                            ><i class="fa-solid fa fa-rotate-back"></i
                          ></span>
                        </li>
                        <li>
                          <NuxtLink
                            :to="`/service-admin/account/show/${item.admin_id}`"
                            ><i class="fa-solid fa-circle-info fa-icon"></i
                          ></NuxtLink>
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
      :data="admin_object"
      :limit="3"
      :keep-length="false"
      @pagination-change-page="pagingAdminData"
    />
  </section>
</template>

<script setup lang="ts">
import store from '../../../store';
import type {
  SelectOptionItems,
  AdminData,
  PaginatedResponse,
  DataType,
} from "@/types/index";
import { AdminStatus, AdminType } from "@/types/const";

let fd: FormData;
const admin_object = ref<PaginatedResponse<DataType> | null | undefined>();
const admin_data = ref<AdminData | null>();
const admin_name = ref("");
const adminTypeSelect = ref(null);
const adminTypeOptions = ref(<SelectOptionItems>[]);
const statusSelect = ref(null);
const statusOptions = ref(<SelectOptionItems>[]);

const { getAllAdminData, destroyAdmin, recoverAdmin } = admin();

const erase = () => {
  eraseForm();
  adminTypeSelect.value.clearValue();
  statusSelect.value.clearValue();
};

const search = () => {
  fd = new FormData();
  if (admin_name.value !== "") {
    fd.append("admin_name", admin_name.value);
  }

  if (adminTypeSelect.value !== null) {
    if (adminTypeSelect.value.getSelectedValue()["key"] !== undefined) {
      fd.append("admin_type", adminTypeSelect.value.getSelectedValue()["key"]);
    }
  }

  if (statusSelect.value !== null) {
    if (statusSelect.value.getSelectedValue()["key"] !== undefined) {
      fd.append("status", statusSelect.value.getSelectedValue()["key"]);
    }
  }

  pagingAdminData(1);
};

const destroy = async (admin_id: number): Promise<void> => {
  fd = new FormData();
  fd.append("admin_id", admin_id.toString());
  await destroyAdmin(fd);
};

const recover = async (admin_id: number): Promise<void> => {
  fd = new FormData();
  fd.append("admin_id", admin_id.toString());
  await recoverAdmin(fd);
};

const pagingAdminData = async (page: number) => {
  admin_object.value = await getAllAdminData(page, fd);
  admin_data.value = admin_object.value["data"];
};

const { adminLogout } = useAuth();

const logout = async () => {
  adminLogout();
};

const init = async () => {
  adminTypeOptions.value = arrangeAsSelectOptions(AdminType);
  statusOptions.value = arrangeAsSelectOptions(AdminStatus);

  admin_object.value = await getAllAdminData(1);
  admin_data.value = admin_object.value["data"];
};
init();

definePageMeta({
  layout: "admin-after-login",
  middleware: "admin",
});
</script>
