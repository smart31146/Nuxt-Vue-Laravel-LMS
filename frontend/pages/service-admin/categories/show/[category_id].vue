<template>
  <Html>
    <Head>
      <Title>カテゴリ詳細</Title>
    </Head>
  </Html>

  <section>
    <div class="nav-area" :class="{ 'is_open': store.state.stateIsMenuOpen }">
      <nav class="gnav">
        <ul class="gnav-list">
          <li class="gnav-item">
            <NuxtLink to="/service-admin/categories" class="gnav-link"
              >カテゴリ管理に戻る</NuxtLink
            >
          </li>
        </ul>
      </nav>
    </div>
    <div class="content">
      <div class="inner">
        <section class="category table-page">
          <h1 class="result sec-title curriculum-title">カテゴリ詳細</h1>
          <form class="form curriculum-form">
            <table class="form-table">
              <tbody class="form-tbody">
                <tr class="input-box">
                  <th>
                    <label for="user-category-name" class="label-name"
                      >カテゴリスラッグ</label
                    >
                  </th>
                  <td>
                    {{ category_slug }}
                  </td>
                </tr>
                <tr class="input-box">
                  <th>
                    <label for="user-category-name" class="label-name"
                      >管理者用カテゴリ名</label
                    >
                  </th>
                  <td>
                    {{ category_name_admin }}
                  </td>
                </tr>
                <tr class="input-box">
                  <th>
                    <label for="category-name" class="label-name"
                      >カテゴリ名<</label
                    >
                  </th>
                  <td>
                    {{ category_name }}
                  </td>
                </tr>
                <tr class="select-box">
                  <th>
                    <label for="category-type" class="label-name">階層</label>
                  </th>
                  <td>
                    {{ category_level }}
                  </td>
                </tr>
                <tr class="select-box" v-if="is_child_selected">
                  <th>
                    <label for="category-type" class="label-name"
                      >親カテゴリ</label
                    >
                  </th>
                  <td v-if="is_child_selected">
                    {{ parent_category_name }}
                  </td>
                </tr>
                <tr
                  v-if="is_current_category_image"
                  class="input-box curriculum-img"
                >
                  <th>カテゴリ画像</th>
                  <td v-if="is_current_category_image">
                    <img :src="category_image" />
                  </td>
                </tr>
                <tr class="input-box edit-box">
                  <th class="label-name-th">カテゴリ説明文</th>
                  <td class="edit-menu last text-wrap">
                    <div v-html="category_text" class="edit-menu-inner"></div>
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
import type { SelectOptionItems, Category } from "@/types/index";
import { CategoryLevels } from "@/types/const";
import store from '../../../../store';
const category_data = ref<Category | null>();
const category_slug = ref("");
const category_name_admin = ref("");
const category_name = ref("");
const parentCategoryOptions = ref(<SelectOptionItems | null>[]);
const category_level = ref("");
const category_image = ref("");
const img_dir_path = ref(null);
const is_current_category_image = ref(true);
const parent_category_name = ref("");
const is_child_selected = ref(false);
const category_text = ref("");
const route = useRoute();
const { getParentCategory, getOneCategoryData, getCategoryDirectoryPath } =
  category();

const init = async () => {
  const parentFD: FormData = new FormData();
  parentFD.append("is_active_only", "1");

  const fd: FormData = new FormData();
  fd.append("category_id", route.params.category_id.toString());

  [parentCategoryOptions.value, category_data.value, img_dir_path.value] =
    await Promise.all([
      getParentCategory(parentFD),
      getOneCategoryData(fd),
      getCategoryDirectoryPath(),
    ]);

  if (!category_data.value) {
    showError({
      statusCode: 404,
      message: "データが存在しません",
    });
  }

  category_slug.value = category_data.value["category_slug"];
  category_name_admin.value = category_data.value["category_name_admin"];
  category_name.value = category_data.value["category_name"];

  CategoryLevels.forEach((value, key) => {
    if (key === category_data.value["category_level"]) {
      category_level.value = value;
    }
  });

  for (let i = 0; i < parentCategoryOptions.value?.length; i++) {
    if (
      parseInt(parentCategoryOptions.value[i]["key"], 10) ===
      category_data.value["parent_id"]
    ) {
      parent_category_name.value = parentCategoryOptions.value[i]["value"];
    }
  }

  if (category_data.value["category_image"] !== null) {
    category_image.value =
      img_dir_path.value + category_data.value["category_image"];
  } else {
    is_current_category_image.value = false;
  }

  if (category_data.value["category_level"] === "C") {
    is_child_selected.value = true;
  }

  category_text.value = category_data.value["category_text"];
};

init();

definePageMeta({
  layout: "admin-after-login",
  middleware: "admin",
});
</script>
