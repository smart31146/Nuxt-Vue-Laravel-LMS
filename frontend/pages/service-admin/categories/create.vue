<template>
  <Html>
    <Head>
      <Title>カテゴリ追加</Title>
    </Head>
  </Html>

  <section>
    <div class="nav-area" :class="{ 'is_open': globlaStore.state.stateIsMenuOpen }">
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
        <section class="category table-page">
          <h1 class="sec-title curriculum-title">カテゴリ追加</h1>
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
                      >カテゴリ名<<span>*</span></label
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
                    <label class="label-name"
                      >階層<span>*</span></label
                    >
                  </th>
                  <td>
                    <SelectComponent
                      ref="categoryLevelSelect"
                      item_name="category_level"
                      defaultValue=""
                      :data="categoryLevelOptions"
                      @notifyChanging="notifyChanging"
                    />
                  </td>
                </tr>
                <tr class="select-box" v-if="is_child_selected">
                  <th>
                    <label class="label-name"
                      >親カテゴリ<span>*</span></label
                    >
                  </th>
                  <td v-if="is_child_selected">
                    <SelectComponent
                      ref="parentCategorySelect"
                      item_name="parent_category_id"
                      defaultValue=""
                      :data="parentCategoryOptions"
                      @notifyChanging="notifyChanging"
                    />
                  </td>
                </tr>
                <tr class="input-box curriculum-img">
                  <th>カテゴリ画像</th>
                  <td>
                    <FileInputComponent
                      ref="category_image"
                      file_kind="image"
                    />
                  </td>
                </tr>
                <tr class="input-box edit-box">
                  <th class="label-name-th">カテゴリ説明文<span>*</span></th>
                  <td class="edit-menu last">
                    <div class="edit-menu-inner">
                      <TinyMCEComponent ref="category_text" data="" />
                    </div>
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
import type { SelectOptionItems } from "@/types/index";
import { CategoryLevels, CategoryLevelsParentOnly } from "@/types/const";
import globlaStore from "@/store";
const category_name_admin = ref("");
const category_name = ref("");
const categoryLevelOptions = ref(<SelectOptionItems>[]);
const parentCategoryOptions = ref(<SelectOptionItems | null>[]);
const category_image = ref(null);
const category_text = ref(null);
const categoryLevelSelect = ref(null);
const parentCategorySelect = ref(null);
const is_child_selected = ref(false);
const error_message = ref<HTMLParagraphElement | null>(null);
const { getParentCategory, storeCategory } = category();

const store = async () => {
  const fd: FormData = new FormData();
  fd.append("category_name_admin", category_name_admin.value);
  fd.append("category_name", category_name.value);
  fd.append(
    "category_level",
    categoryLevelSelect.value.getSelectedValue()["key"]
  );
  if (category_image.value.getInputFile() !== null) {
    fd.append("category_image", category_image.value.getInputFile());
  }
  fd.append("category_text", category_text.value.getTextAreaValue());

  if (parentCategorySelect.value !== null) {
    if (parentCategorySelect.value.getSelectedValue()["key"] !== undefined) {
      fd.append(
        "parent_id",
        parentCategorySelect.value.getSelectedValue()["key"]
      );
    }
  }

  error_message.value.innerHTML = await storeCategory("store", fd);
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

const init = async () => {
  const fd: FormData = new FormData();
  fd.append("is_active_only", "1");

  parentCategoryOptions.value = await getParentCategory(fd);

  if (parentCategoryOptions.value?.length === 0) {
    categoryLevelOptions.value = arrangeAsSelectOptions(
      CategoryLevelsParentOnly
    );
  } else {
    categoryLevelOptions.value = arrangeAsSelectOptions(CategoryLevels);
  }
};
init();

definePageMeta({
  layout: "admin-after-login",
  middleware: "admin",
});
</script>
