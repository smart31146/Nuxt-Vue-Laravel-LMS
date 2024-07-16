<template>
  <Html>
    <Head>
      <Title>ユーザー管理</Title>
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
         
        </ul>
      </nav>
    </div>
    <div class="content">
      <div class="inner">
        <section class="user table-page">
          <div class="flex justify-between items-center mb-4 p-4">
            <h1 class="text-xl md:text-3xl lg:text-5xl category-title">ユーザー管理</h1>
          
            <NuxtLink class="text-xl md:text-3xl lg:text-5xl" to="/service-admin/user/create"
              >新規追加</NuxtLink
            >
          
        </div>
          <form class="form user-form">
            <table class="form-table">
              <tbody class="form-tbody">
                <tr class="input-box">
                  <th>
                    <label for="user-name" class="label-name">ユーザー名</label>
                  </th>
                  <td>
                    <input
                      type="search"
                      v-model="user_name"
                      class="input-block"
                      id="user-namee"
                      name="user-name"
                    />
                  </td>
                </tr>
                <tr class="input-box">
                  <th>
                    <label for="miyozi" class="label-name">氏</label>
                  </th>
                  <td>
                    <input
                      type="search"
                      v-model="sei"
                      class="input-block"
                      id="miyozi"
                      name="miyozi"
                    />
                  </td>
                </tr>
                <tr class="input-box">
                  <th>
                    <label for="namae" class="label-name">名</label>
                  </th>
                  <td>
                    <input
                      type="search"
                      v-model="mei"
                      class="input-block"
                      id="namae"
                      name="namae"
                    />
                  </td>
                </tr>
                <tr class="input-box">
                  <th>
                    <label for="miyozi-kana" class="label-name">氏カナ</label>
                  </th>
                  <td>
                    <input
                      type="search"
                      v-model="sei_kana"
                      class="input-block"
                      id="miyozi-kana"
                      name="miyozi-kana"
                    />
                  </td>
                </tr>
                <tr class="input-box">
                  <th>
                    <label for="namae-kana" class="label-name">名カナ</label>
                  </th>
                  <td>
                    <input
                      type="search"
                      v-model="mei_kana"
                      class="input-block"
                      id="namae-kana"
                      name="namae-kana"
                    />
                  </td>
                </tr>

                <tr class="select-box">
                  <th>
                    <label for="gender-type" class="label-name">性別</label>
                  </th>
                  <td>
                    <SelectComponent
                      ref="sexSelect"
                      item_name="sex"
                      defaultValue=""
                      :data="sexOptions"
                    />
                  </td>
                </tr>
                <tr class="select-box">
                  <th>
                    <label for="rank-type" class="label-name">会員ランク</label>
                  </th>
                  <td>
                    <SelectComponent
                      ref="userRankSelect"
                      item_name="user_rank"
                      defaultValue=""
                      :data="userRankOptions"
                    />
                  </td>
                </tr>
                <tr class="select-box">
                  <th>
                    <label for="user-type" class="label-name"
                      >ユーザータイプ</label
                    >
                  </th>
                  <td>
                    <SelectComponent
                      ref="userTypeSelect"
                      item_name="user_type"
                      defaultValue=""
                      :data="userTypeOptions"
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
                    <th>ユーザー名</th>
                    <th>氏名(カナ)</th>
                    <th>性別</th>
                    <th>会員ランク</th>
                    <th>ユーザータイプ</th>
                    <th>登録日時</th>
                    <th>ステータス</th>
                    <th>操作</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, i) in user_data" :key="i">
                    <td>{{ item.user_name }}</td>
                    <td>
                      {{ item.sei }} {{ item.mei }}({{ item.sei_kana }}
                      {{ item.mei_kana }})
                    </td>
                    <td>{{ item.sex !== null ? Sex.get(item.sex) : null }}</td>
                    <td>{{ UserRank.get(item.user_rank.toString()) }}</td>
                    <td>{{ UserRank.get(item.user_type.toString()) }}</td>
                    <td>{{ dateTimeFormat(item.created_at).value }}</td>
                    <td>{{ UserStatus.get(item.status) }}</td>
                    <td>
                      <ul class="u-display--flex u-flex__gap--0_5rem">
                        <li>
                          <NuxtLink
                            :to="`/service-admin/user/edit/${item.user_id}`"
                            ><i class="fa-solid fa-pen-to-square fa-icon"></i
                          ></NuxtLink>
                        </li>
                        <li v-if="item.status === 'A'">
                          <span
                            @click="destroy(item.user_id)"
                            class="u-cursor--pointer"
                            ><i class="fa-solid fa-trash fa-icon"></i
                          ></span>
                        </li>
                        <li v-if="item.status === 'D'">
                          <span
                            @click="recover(item.user_id)"
                            class="u-cursor--pointer"
                            ><i class="fa-solid fa-rotate-back"></i
                          ></span>
                        </li>
                        <li>
                          <NuxtLink
                            :to="`/service-admin/user/show/${item.user_id}`"
                            ><i class="fa-solid fa-circle-info fa-icon"></i
                          ></NuxtLink>
                        </li>
                        <li>
                          <NuxtLink
                            :to="`/service-admin/user/progress/${item.user_id}`"
                            ><i class="fa-solid fa-chart-line"></i
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
      :data="user_object"
      :limit="3"
      :keep-length="false"
      @pagination-change-page="pagingUserData"
    />
  </section>
</template>

<script setup lang="ts">
import type {
  SelectOptionItems,
  UserData,
  PaginatedResponse,
  DataType,
} from "@/types/index";
import { UserStatus, Sex, UserRank, UserType } from "@/types/const";
import store from "@/store";
let fd: FormData;
const user_object = ref<PaginatedResponse<DataType> | null | undefined>();
const user_data = ref<UserData | null>();
const user_name = ref("");
const sei = ref("");
const mei = ref("");
const sei_kana = ref("");
const mei_kana = ref("");
const sexSelect = ref(null);
const sexOptions = ref(<SelectOptionItems>[]);
const userRankSelect = ref(null);
const userRankOptions = ref(<SelectOptionItems>[]);
const userTypeSelect = ref(null);
const userTypeOptions = ref(<SelectOptionItems>[]);
const statusSelect = ref(null);
const statusOptions = ref(<SelectOptionItems>[]);

const { getAllUserData, destroyUser, recoverUser } = user();

const erase = () => {
  eraseForm();
  sexSelect.value.clearValue();
  userRankSelect.value.clearValue();
  userTypeSelect.value.clearValue();
  statusSelect.value.clearValue();
};

const search = () => {
  fd = new FormData();
  if (user_name.value !== "") {
    fd.append("user_name", user_name.value);
  }

  if (sei.value !== "") {
    fd.append("sei", sei.value);
  }

  if (mei.value !== "") {
    fd.append("mei", mei.value);
  }

  if (sei_kana.value !== "") {
    fd.append("sei_kana", sei_kana.value);
  }

  if (mei_kana.value !== "") {
    fd.append("mei_kana", mei_kana.value);
  }

  if (sexSelect.value !== null) {
    if (sexSelect.value.getSelectedValue()["key"] !== undefined) {
      fd.append("sex", sexSelect.value.getSelectedValue()["key"]);
    }
  }

  if (userRankSelect.value !== null) {
    if (userRankSelect.value.getSelectedValue()["key"] !== undefined) {
      fd.append("user_rank", userRankSelect.value.getSelectedValue()["key"]);
    }
  }

  if (userTypeSelect.value !== null) {
    if (userTypeSelect.value.getSelectedValue()["key"] !== undefined) {
      fd.append("user_type", userTypeSelect.value.getSelectedValue()["key"]);
    }
  }

  if (statusSelect.value !== null) {
    if (statusSelect.value.getSelectedValue()["key"] !== undefined) {
      fd.append("status", statusSelect.value.getSelectedValue()["key"]);
    }
  }

  pagingUserData(1);
};

const destroy = async (user_id: number): Promise<void> => {
  fd = new FormData();
  fd.append("user_id", user_id.toString());
  await destroyUser(fd);
};

const recover = async (user_id: number): Promise<void> => {
  fd = new FormData();
  fd.append("user_id", user_id.toString());
  await recoverUser(fd);
};

const pagingUserData = async (page: number) => {
  user_object.value = await getAllUserData(page, fd);
  user_data.value = user_object.value["data"];
};

const { adminLogout } = useAuth();

const logout = async () => {
  adminLogout();
};

const init = async () => {
  sexOptions.value = arrangeAsSelectOptions(Sex);
  statusOptions.value = arrangeAsSelectOptions(UserStatus);
  userRankOptions.value = arrangeAsSelectOptions(UserRank);
  userTypeOptions.value = arrangeAsSelectOptions(UserType);

  user_object.value = await getAllUserData(1);
  user_data.value = user_object.value["data"];
};
init();

definePageMeta({
  layout: "admin-after-login",
  middleware: "admin",
});
</script>
