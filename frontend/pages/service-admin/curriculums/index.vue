<template>
  <Html>
    <Head>
      <Title>カリキュラム管理</Title>
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
            <NuxtLink class="gnav-link" to="/service-admin/curriculums/create"
              >新規追加</NuxtLink
            >
          </li>
        </ul>
      </nav>
    </div>
    <div class="content">
      <div class="inner">
        <section class="category table-page">
          <h1 class="sec-title curriculum-title">カリキュラム管理</h1>
          <form class="form curriculum-form">
            <table class="form-table">
              <tbody class="form-tbody">
                <tr class="input-box">
                  <th>
                    <label for="user-cslug-name" class="label-name"
                      >管理スラッグ</label
                    >
                  </th>
                  <td>
                    <input
                      type="search"
                      v-model="curriculum_name_admin"
                      class="input-block"
                      id="user-cslug-name"
                      name="cslug-name"
                    />
                  </td>
                </tr>
                <tr class="input-box">
                  <th>
                    <label for="curriculum-name" class="label-name"
                      >カリキュラム</label
                    >
                  </th>
                  <td>
                    <input
                      type="search"
                      v-model="curriculum_name"
                      class="input-block"
                      id="curriculum-name"
                      name="curriculum-name"
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
                    <label for="requiredーoptional" class="label-name"
                      >必修/任意</label
                    >
                  </th>
                  <td>
                    <SelectComponent
                      ref="requiredTypeSelect"
                      item_name="required_type"
                      defaultValue=""
                      :data="requiredTypeOptions"
                    />
                  </td>
                </tr>
                <tr class="select-box">
                  <th>
                    <label for="curriculum-type" class="label-name"
                      >カリキュラム種別</label
                    >
                  </th>
                  <td>
                    <SelectComponent
                      ref="curriculumTypeSelect"
                      item_name="curriculum_type"
                      defaultValue=""
                      :data="curriculumTypeOptions"
                    />
                  </td>
                </tr>
                <tr class="select-box">
                  <th>
                    <label for="hierarchy" class="label-name">公開タイプ</label>
                  </th>
                  <td>
                    <SelectComponent
                      ref="releaseTypeSelect"
                      item_name="release_type"
                      defaultValue=""
                      :data="releaseTypeOptions"
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
                    <th>管理スラッグ</th>
                    <th>カリキュラム名</th>
                    <th>カテゴリ名</th>
                    <th>カリキュラム種別</th>
                    <th>必修/任意</th>
                    <th>公開タイプ</th>
                    <th>状態</th>
                    <th>操作</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, i) in curriculum_data" :key="i">
                    <td>{{ item.curriculum_name_admin }}</td>
                    <td>{{ item.curriculum_name }}</td>
                    <td>
                      {{ setCategoryName(item.category_id, category_data) }}
                    </td>
                    <td>
                      {{ CurriculumType.get(item.curriculum_type.toString()) }}
                    </td>
                    <td>{{ RequiredType.get(item.is_required.toString()) }}</td>
                    <td>{{ ReleaseType.get(item.release_type.toString()) }}</td>
                    <td>{{ CurriculumStatus.get(item.status) }}</td>
                    <td>
                      <ul class="flex gap-0.5">
                        <li>
                          <NuxtLink
                            :to="`/service-admin/curriculums/edit/${item.curriculum_slug}`"
                            ><i class="fa-solid fa-pen-to-square fa-icon"></i
                          ></NuxtLink>
                        </li>
                        <li v-if="item.status === 'A'">
                          <span
                            @click="destroy(item.curriculum_slug)"
                            class="u-cursor--pointer"
                            ><i class="fa-solid fa-trash fa-icon"></i
                          ></span>
                        </li>
                        <li v-if="item.status === 'D'">
                          <span
                            @click="recover(item.curriculum_slug)"
                            class="u-cursor--pointer"
                            ><i class="fa-solid fa-rotate-left fa-icon"></i
                          ></span>
                        </li>
                        <li>
                          <NuxtLink
                            :to="`/service-admin/curriculums/show/${item.curriculum_slug}`"
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
      :data="curriculum_object"
      :limit="3"
      :keep-length="false"
      @pagination-change-page="pagingCurriculumData"
    />
  </section>
</template>

<script setup lang="ts">
import type {
  SelectOptionItems,
  CurriculumData,
  PaginatedResponse,
  DataType,
} from "@/types/index";
import {
  CurriculumStatus,
  CurriculumType,
  RequiredType,
  ReleaseType,
} from "@/types/const";
import store from "@/store";
let fd: FormData;
const curriculum_object = ref<PaginatedResponse<DataType> | null | undefined>();
const curriculum_data = ref<CurriculumData | null>();
const category_data = ref<SelectOptionItems | null>();
const statusSelect = ref(null);
const releaseTypeSelect = ref(null);
const requiredTypeSelect = ref(null);
const curriculumTypeSelect = ref(null);
const statusOptions = ref(<SelectOptionItems>[]);
const curriculumTypeOptions = ref(<SelectOptionItems>[]);
const requiredTypeOptions = ref(<SelectOptionItems>[]);
const releaseTypeOptions = ref(<SelectOptionItems>[]);
const curriculum_name_admin = ref("");
const curriculum_name = ref("");
const category_name = ref("");
const { getActiveCategory, setCategoryName } = category();
const { getAllCurriculumData, destroyCurriculum, recoverCurriculum } =
  curriculum();

const erase = () => {
  eraseForm();
  requiredTypeSelect.value.clearValue();
  curriculumTypeSelect.value.clearValue();
  releaseTypeSelect.value.clearValue();
  statusSelect.value.clearValue();
};

const search = () => {
  fd = new FormData();
  if (curriculum_name_admin.value !== "") {
    fd.append("curriculum_name_admin", curriculum_name_admin.value);
  }

  if (curriculum_name.value !== "") {
    fd.append("curriculum_name", curriculum_name.value);
  }

  if (category_name.value !== "") {
    fd.append("category_name", category_name.value);
  }

  if (releaseTypeSelect.value !== null) {
    if (releaseTypeSelect.value.getSelectedValue()["key"] !== undefined) {
      fd.append(
        "release_type",
        releaseTypeSelect.value.getSelectedValue()["key"]
      );
    }
  }

  if (requiredTypeSelect.value !== null) {
    if (requiredTypeSelect.value.getSelectedValue()["key"] !== undefined) {
      fd.append(
        "is_required",
        requiredTypeSelect.value.getSelectedValue()["key"]
      );
    }
  }

  if (curriculumTypeSelect.value !== null) {
    if (curriculumTypeSelect.value.getSelectedValue()["key"] !== undefined) {
      fd.append(
        "curriculum_type",
        curriculumTypeSelect.value.getSelectedValue()["key"]
      );
    }
  }

  if (statusSelect.value !== null) {
    if (statusSelect.value.getSelectedValue()["key"] !== undefined) {
      fd.append("status", statusSelect.value.getSelectedValue()["key"]);
    }
  }

  pagingCurriculumData(1);
};

const destroy = async (curriculum_slug: string): Promise<void> => {
  fd = new FormData();
  fd.append("curriculum_slug", curriculum_slug);
  await destroyCurriculum(fd);
};

const recover = async (curriculum_slug: string): Promise<void> => {
  fd = new FormData();
  fd.append("curriculum_slug", curriculum_slug);
  await recoverCurriculum(fd);
};

const pagingCurriculumData = async (page: number) => {
  curriculum_object.value = await getAllCurriculumData(
    "service-admin",
    page,
    fd
  );
  curriculum_data.value = curriculum_object.value["data"];
  window.scroll({ top: 0, behavior: "smooth" });
};
const { adminLogout } = useAuth();

const logout = async () => {
  adminLogout();
};
const init = async () => {
  statusOptions.value = arrangeAsSelectOptions(CurriculumStatus);
  curriculumTypeOptions.value = arrangeAsSelectOptions(CurriculumType);
  requiredTypeOptions.value = arrangeAsSelectOptions(RequiredType);
  releaseTypeOptions.value = arrangeAsSelectOptions(ReleaseType);

  [curriculum_object.value, category_data.value] = await Promise.all([
    getAllCurriculumData("service-admin", 1),
    getActiveCategory(),
  ]);

  curriculum_data.value = curriculum_object.value["data"];
};
init();

definePageMeta({
  layout: "admin-after-login",
  middleware: "admin",
});
</script>
