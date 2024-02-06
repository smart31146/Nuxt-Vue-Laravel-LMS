<template>
  <Html>
    <Head>
      <Title>カテゴリ管理</Title>
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
            <NuxtLink class="gnav-link" to="/service-admin/categories/create"
              >新規追加</NuxtLink
            >
          </li>
        </ul>
      </nav>
    </div>
    <div class="content">
      <div class="inner">
        <section class="category table-page">
          <h1 class="sec-title category-title">カテゴリ管理</h1>
          <form class="form category-form">
            <table class="form-table">
              <tbody class="form-tbody">
                <tr class="input-box">
                  <th>
                    <label for="user-category-name" class="label-name"
                      >管理者用カテゴリ名</label
                    >
                  </th>
                  <td>
                    <input
                      type="search"
                      v-model="category_name_admin"
                      class="input-block"
                      id="user-category-name"
                      name="category-name"
                    />
                  </td>
                </tr>
                <tr class="input-box">
                  <th>
                    <label for="category-name" class="label-name"
                      >カテゴリ名</label
                    >
                  </th>
                  <td>
                    <input
                      type="search"
                      v-model="category_name"
                      class="input-block"
                      id="category-name"
                      name="category-name"
                    />
                  </td>
                </tr>
                <tr class="select-box">
                  <th>
                    <label for="hierarchy" class="label-name">階層</label>
                  </th>
                  <td>
                    <SelectComponent
                      ref="categoryLevelSelect"
                      item_name="category_level"
                      defaultValue=""
                      :data="categoryLevelOptions"
                    />
                  </td>
                </tr>
                <tr class="input-box">
                  <th>
                    <label for="oya-category-name" class="label-name"
                      >親カテゴリ名</label
                    >
                  </th>
                  <td>
                    <input
                      type="search"
                      v-model="parent_category_name"
                      class="input-block"
                      id="oya-category-name"
                      name="oya-category-name"
                    />
                  </td>
                </tr>
                <tr class="select-box">
                  <th>
                    <label for="hierarchy" class="label-name">状態</label>
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
              <table class="category-table table table-body">
                <thead>
                  <tr>
                    <th>スラッグ</th>
                    <th>管理者用カテゴリ名</th>
                    <th>カテゴリ名</th>
                    <th>階層</th>
                    <th>親カテゴリ名</th>
                    <th>状態</th>
                    <th>操作</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, i) in category_data" :key="i">
                    <td>{{ item.category_slug }}</td>
                    <td>{{ item.category_name_admin }}</td>
                    <td>{{ item.category_name }}</td>
                    <td>{{ CategoryLevels.get(item.category_level) }}</td>
                    <td>
                      {{
                        setCategoryName(item.parent_id, parent_category_data)
                      }}
                    </td>
                    <td>{{ CategoryStatus.get(item.status) }}</td>
                    <td>
                      <ul class="flex gap-0.5">
                        <li>
                          <NuxtLink
                            :to="`/service-admin/categories/edit/${item.category_id}`"
                            ><i class="fa-solid fa-pen-to-square fa-icon"></i
                          ></NuxtLink>
                        </li>
                        <li v-if="item.status === 'A'">
                          <span
                            @click="destroy(item.category_id)"
                            class="u-cursor--pointer"
                            ><i class="fa-solid fa-trash fa-icon"></i
                          ></span>
                        </li>
                        <li v-if="item.status === 'D'">
                          <span
                            @click="recover(item.category_id)"
                            class="u-cursor--pointer"
                            ><i class="fa-solid fa-rotate-left fa-icon"></i
                          ></span>
                        </li>
                        <li>
                          <NuxtLink
                            :to="`/service-admin/categories/show/${item.category_id}`"
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
      :data="category_object"
      :limit="3"
      :keep-length="false"
      @pagination-change-page="pagingCategoryData"
    />
  </section>
</template>

<script setup lang="ts">
import type {
  SelectOptionItems,
  CategoryData,
  PaginatedResponse,
  DataType,
} from "@/types/index";
import { CategoryLevels, CategoryStatus } from "@/types/const";
import store from "@/store";
let fd: FormData;
const category_object = ref<PaginatedResponse<DataType> | null | undefined>();
const category_data = ref<CategoryData | null>();
const parent_category_data = ref<SelectOptionItems | null>();
const categoryLevelSelect = ref(null);
const categoryLevelOptions = ref(<SelectOptionItems>[]);
const statusSelect = ref(null);
const statusOptions = ref(<SelectOptionItems>[]);
const category_name_admin = ref("");
const category_name = ref("");
const parent_category_name = ref("");
const {
  getAllCategoryData,
  getParentCategory,
  destroyCategory,
  recoverCategory,
  setCategoryName,
} = category();

const erase = () => {
  eraseForm();
  categoryLevelSelect.value.clearValue();
  statusSelect.value.clearValue();
};

const search = () => {
  fd = new FormData();
  if (category_name_admin.value !== "") {
    fd.append("category_name_admin", category_name_admin.value);
  }

  if (category_name.value !== "") {
    fd.append("category_name", category_name.value);
  }

  if (categoryLevelSelect.value !== null) {
    if (categoryLevelSelect.value.getSelectedValue()["key"] !== undefined) {
      fd.append(
        "category_level",
        categoryLevelSelect.value.getSelectedValue()["key"]
      );
    }
  }

  if (parent_category_name.value !== "") {
    fd.append("parent_category_name", parent_category_name.value);
  }

  if (statusSelect.value !== null) {
    if (statusSelect.value.getSelectedValue()["key"] !== undefined) {
      fd.append("status", statusSelect.value.getSelectedValue()["key"]);
    }
  }

  pagingCategoryData(1);
};

const destroy = async (category_id: number): Promise<void> => {
  fd = new FormData();
  fd.append("category_id", category_id.toString());
  await destroyCategory(fd);
};

const recover = async (category_id: number): Promise<void> => {
  fd = new FormData();
  fd.append("category_id", category_id.toString());
  await recoverCategory(fd);
};

const pagingCategoryData = async (page: number) => {
  category_object.value = await getAllCategoryData(page, fd);
  category_data.value = category_object.value["data"];
};

const init = async () => {
  categoryLevelOptions.value = arrangeAsSelectOptions(CategoryLevels);
  statusOptions.value = arrangeAsSelectOptions(CategoryStatus);

  [category_object.value, parent_category_data.value] = await Promise.all([
    getAllCategoryData(1),
    getParentCategory(),
  ]);

  category_data.value = category_object.value["data"];
};

const { adminLogout } = useAuth();

const logout = async () => {
  adminLogout();
};
init();

definePageMeta({
  layout: "admin-after-login",
  middleware: "admin",
});
</script>
