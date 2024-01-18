<template>
  <Html>
    <Head>
      <Title>カテゴリ編集</Title>
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
          <h1 class="sec-title curriculum-title">カテゴリ編集</h1>
          <p class="inner-text"><span>*</span>は必須入力</p>
          <form class="form curriculum-form">
            <table class="form-table">
              <tbody class="form-tbody">
                <tr class="input-box">
                  <th>
                    <label for="user-category-name" class="label-name"
                      >管理者用カテゴリ名<span>*</span></label
                    >
                  </th>
                  <td>
                    <input
                      type="text"
                      class="input-block"
                      id="user-category-name"
                      name="cuser-category-name"
                      v-model="category_name_admin"
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
                      type="text"
                      v-model="category_name"
                      class="input-block"
                      id="category-name"
                      name="category-name"
                    />
                  </td>
                </tr>
                <tr class="select-box">
                  <th>
                    <label for="category-type" class="label-name"
                      >階層<span>*</span></label
                    >
                  </th>
                  <td>
                    <SelectComponent
                      ref="categoryLevelSelect"
                      item_name="category_level"
                      :defaultValue="categoryLevelValue"
                      :data="categoryLevelOptions"
                      @notifyChanging="notifyChanging"
                      :key="categoryUpdate"
                    />
                  </td>
                </tr>
                <tr class="input-box curriculum-img">
                  <th>カテゴリ画像</th>
                  <td>
                    <UploadedImageComponent
                      v-if="is_current_category_image"
                      :src="current_category_image"
                      @closeImage="closeImage"
                    />
                    <FileInputComponent
                      ref="category_image"
                      file_kind="image"
                      v-if="!is_current_category_image"
                    />
                  </td>
                </tr>
                <tr class="input-box edit-box">
                  <th class="label-name-th">カリキュラム説明文</th>
                  <td class="edit-menu last">
                    <div class="edit-menu-inner">
                      <TinyMCEComponent
                        ref="category_text"
                        :data="categoryTextData"
                      />
                    </div>
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
import type { SelectOptionItems, Category } from "@/types/index";
import { CategoryLevels, CategoryLevelsParentOnly } from "@/types/const";
import store from "@/store";
const category_data = ref<Category | null>();
const category_name_admin = ref("");
const category_name = ref("");
const categoryLevelOptions = ref(<SelectOptionItems>[]);
const parentCategoryOptions = ref(<SelectOptionItems | null>[]);
const current_category_image = ref("");
const category_image = ref(null);
const img_dir_path = ref(null);
const is_current_category_image = ref(true);
const category_text = ref(null);
const categoryLevelSelect = ref(null);
const parentCategorySelect = ref(null);
const categoryLevelValue = ref<number | string | Object | undefined>();
const parentCategoryValue = ref<number | string | Object | undefined>();
const is_child_selected = ref(false);
const categoryTextData = ref("");
const error_message = ref<HTMLParagraphElement | null>(null);
const categoryUpdate = ref(0);
const category_image_change = ref(false);
const route = useRoute();
const {
  getParentCategory,
  getOneCategoryData,
  storeCategory,
  getCategoryDirectoryPath,
} = category();

const update = async () => {
  const fd: FormData = new FormData();
  fd.append("category_id", route.params.category_id.toString());
  fd.append("category_name_admin", category_name_admin.value);
  fd.append("category_name", category_name.value);
  fd.append(
    "category_level",
    categoryLevelSelect.value.getSelectedValue()["key"]
  );

  if (category_image.value !== null) {
    if (category_image.value.getInputFile() !== null) {
      fd.append("category_image", category_image.value.getInputFile());
    }
  }

  fd.append("category_text", category_text.value.getTextAreaValue());

  if (
    parentCategorySelect.value !== null &&
    parentCategorySelect.value.getSelectedValue() !== undefined
  ) {
    if (parentCategorySelect.value.getSelectedValue()["key"] !== undefined) {
      fd.append(
        "parent_id",
        parentCategorySelect.value.getSelectedValue()["key"]
      );
    }
  }

  if (category_image_change.value) {
    fd.append("category_image_change", "1");
  }

  error_message.value.innerHTML = await storeCategory("update", fd);
  if (error_message.value.innerHTML) {
    window.scroll({ top: 0, behavior: "smooth" });
  }
};

const notifyChanging = (item_name: string, key: string) => {
  if (item_name === "category_level") {
    if (key === "C") {
      is_child_selected.value = true;
    } else {
      is_child_selected.value = false;
    }
  }
};

const closeImage = (): void => {
  is_current_category_image.value = false;
  category_image_change.value = true;
};
const { adminLogout } = useAuth();

const logout = async () => {
  adminLogout();
};
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

  if (parentCategoryOptions.value?.length === 0) {
    categoryLevelOptions.value = arrangeAsSelectOptions(
      CategoryLevelsParentOnly
    );
  } else {
    categoryLevelOptions.value = arrangeAsSelectOptions(CategoryLevels);
  }

  category_name_admin.value = category_data.value["category_name_admin"];
  category_name.value = category_data.value["category_name"];

  CategoryLevels.forEach((value, key) => {
    if (key === category_data.value["category_level"]) {
      categoryLevelValue.value = {
        key: key,
        value: value,
      };
    }
  });
  categoryUpdate.value++;

  for (let i = 0; i < parentCategoryOptions.value?.length; i++) {
    if (
      parseInt(parentCategoryOptions.value[i]["key"], 10) ===
      category_data.value["parent_id"]
    ) {
      parentCategoryValue.value = parentCategoryOptions.value[i];
    }
  }

  if (category_data.value["category_level"] === "C") {
    is_child_selected.value = true;
  }

  category_text.value.setTextAreaValue(category_data.value["category_text"]);

  if (category_data.value["category_image"] !== null) {
    current_category_image.value =
      img_dir_path.value + category_data.value["category_image"];
  } else {
    is_current_category_image.value = false;
  }
};

init();

definePageMeta({
  layout: "admin-after-login",
  middleware: "admin",
});
</script>
