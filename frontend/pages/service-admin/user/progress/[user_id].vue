<template>
  <Html>
    <Head>
      <Title>{{ user_name }}の受講履歴</Title>
    </Head>
  </Html>

  <section>
    <div class="nav-area" :class="{ 'is_open': store.state.stateIsMenuOpen }">
      <nav class="gnav">
        <ul class="gnav-list">
          <li class="gnav-item">
            <NuxtLink class="gnav-link" to="/service-admin/user"
              >ユーザー管理に戻る</NuxtLink
            >
          </li>
        </ul>
      </nav>
    </div>
    <div class="content">
      <div class="inner">
        <section class="user table-page">
          <h1 class="result sec-title user-title">{{ user_name }}の受講履歴</h1>
          <form class="form user-form">
            <table class="form-table">
              <tbody class="form-tbody">
                <tr class="input-box">
                  <th>
                    <label for="curriculum_name" class="label-name"
                      >カリキュラム名</label
                    >
                  </th>
                  <td>
                    <input type="search" class="input-block" v-model="curriculum_name" />
                  </td>
                </tr>
                <tr class="input-box">
                  <th>
                    <label for="category_name" class="label-name"
                      >カテゴリ名</label
                    >
                  </th>
                  <td>
                    <input type="search" class="input-block" v-model="category_name" />
                  </td>
                </tr>
                <tr class="input-box">
                  <th>
                    <label for="required-type" class="label-name">任意</label>
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
                <tr class="input-box">
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
                <tr class="input-box">
                  <th>
                    <label for="status" class="label-name">状態</label>
                  </th>
                  <td>
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
          <h1 class="result sec-title user-title">
            受講可能な必修受講総数: {{ total_count }}、完了数:
            {{ total_completed }}、達成率: {{ completed_percent }}%
          </h1>
          <div class="table-area">
            <div class="table-inner">
              <table class="curriculum-table table table-body">
                <thead>
                  <tr>
                    <th>カリキュラム名</th>
                    <th>カテゴリ名</th>
                    <th>カリキュラム種別</th>
                    <th>必修/任意</th>
                    <th>受講開始日時</th>
                    <th>受講終了日時</th>
                    <th>進捗状況</th>
                    <th>状態</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, i) in taking_curriculum_data" :key="i">
                    <td>{{ item.curriculum_name }}</td>
                    <td>{{ item.category_name }}</td>
                    <td>
                      {{ CurriculumType.get(item.curriculum_type.toString()) }}
                    </td>
                    <td>{{ RequiredType.get(item.is_required.toString()) }}</td>
                    <td>{{ dateTimeFormat(item.started_at).value }}</td>
                    <td>
                      {{
                        item.completed_at
                          ? dateTimeFormat(item.completed_at).value
                          : ""
                      }}
                    </td>
                    <td>
                      {{
                        getPercentage(
                          item.taking_curriculum_second,
                          item.total_curriculum_second
                        )
                      }}%
                    </td>
                    <td>{{ TakingCurriculumStatus.get(item.status) }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </section>
      </div>
    </div>
    <PaginationComponent
      :data="taking_curriculum_object"
      :limit="3"
      :keep-length="false"
      @pagination-change-page="pagingTakingCurriculumData"
    />
  </section>
</template>

<script setup lang="ts">
import type {
  SelectOptionItems,
  CurriculumData,
  PaginatedResponse,
  DataType,
  TakingCurriculumData,
} from "@/types/index";
import {
  RequiredType,
  CurriculumType,
  TakingCurriculumStatus,
} from "@/types/const";
import store from "@/store";
let fd: FormData;
const user_data = ref<User | null>();
const taking_curriculum_object = ref<
  PaginatedResponse<DataType> | null | undefined
>();
const taking_curriculum_data = ref<TakingCurriculumData | null>();
const category_data = ref<SelectOptionItems | null>();
const statusSelect = ref(null);
const requiredTypeSelect = ref(null);
const curriculumTypeSelect = ref(null);
const statusOptions = ref(<SelectOptionItems>[]);
const curriculumTypeOptions = ref(<SelectOptionItems>[]);
const requiredTypeOptions = ref(<SelectOptionItems>[]);
const curriculum_name = ref("");
const category_name = ref("");
const { getActiveCategory } = category();
const { getAllTakingCurriculumData, getUserAchievementInfo } = curriculum();
const user_name = ref("");
const total_count = ref(0);
const total_completed = ref(0);
const completed_percent = ref(0);
const achievement = ref([]);

const { getOneUserData } = user();
const route = useRoute();

const erase = () => {
  eraseForm();
  curriculumTypeSelect.value.clearValue();
  requiredTypeSelect.value.clearValue();
  statusSelect.value.clearValue();
};

const search = () => {
  fd = new FormData();
  fd.append("user_id", route.params.user_id.toString());

  if (curriculum_name.value !== "") {
    fd.append("curriculum_name", curriculum_name.value);
  }

  if (category_name.value !== "") {
    fd.append("category_name", category_name.value);
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

  pagingTakingCurriculumData(1);
};

const pagingTakingCurriculumData = async (page: number) => {
  taking_curriculum_object.value = await getAllTakingCurriculumData(
    "progress",
    page,
    fd,
    route.params.user_id
  );
  taking_curriculum_data.value = taking_curriculum_object.value["data"];
  window.scroll({ top: 0, behavior: "smooth" });
};

const init = async () => {
  statusOptions.value = arrangeAsSelectOptions(TakingCurriculumStatus);
  curriculumTypeOptions.value = arrangeAsSelectOptions(CurriculumType);
  requiredTypeOptions.value = arrangeAsSelectOptions(RequiredType);

  fd = new FormData();
  fd.append("user_id", route.params.user_id.toString());

  [
    user_data.value,
    taking_curriculum_object.value,
    category_data.value,
    achievement.value,
  ] = await Promise.all([
    getOneUserData(fd),
    getAllTakingCurriculumData("progress", 1, fd, route.params.user_id),
    getActiveCategory(),
    getUserAchievementInfo(fd),
  ]);

  if (!user_data.value) {
    showError({
      statusCode: 404,
      message: "データが存在しません",
    });
  }

  taking_curriculum_data.value = taking_curriculum_object.value["data"];
  user_name.value = user_data.value["user_name"];

  total_count.value = achievement.value["total_count"];
  total_completed.value = achievement.value["total_completed"];
  completed_percent.value = achievement.value["completed_percent"];
};
init();

definePageMeta({
  layout: "admin-after-login",
  middleware: "admin",
});
</script>
