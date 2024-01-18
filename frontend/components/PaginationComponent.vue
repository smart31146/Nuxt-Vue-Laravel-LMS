<template>
<RenderlessPagination
:data="props.data"
:limit="limit"
:keep-length="keepLength"
@pagination-change-page="onPaginationChangePage"
v-slot="slotProps"
>
<ul
v-bind="$attrs"
aria-label="Pagination"
class="u-margin-left--auto u-margin-right--auto u-margin-bottom--1_5rem u-width--fit-content u-display--flex u-flex__gap--0_5rem"
v-if="slotProps.computed.total > slotProps.computed.perPage"
>
    <li>
    <button type="button"
    class="p-paging__link"
    :disabled="!slotProps.computed.prevPageUrl"
    :class="!slotProps.computed.prevPageUrl? 'u-cursor--not-allowed' : 'u-cursor--pointer'"
    v-on="slotProps.prevButtonEvents"
    >
        <slot name="prev-nav">
            前へ
        </slot>
    </button>
    </li>
    <li class="u-display--flex u-flex__gap--0_5rem">
    <span
        class="p-paging__link u-cursor--pointer"
        :class="slotProps.computed.currentPage === page ? '' : 'p-paging--current'"
        v-for="(page, key) in slotProps.computed.pageRange"
        :key="key"
        v-on="slotProps.pageButtonEvents(page)"
    >
        {{ page }}
    </span>
    </li>
    <li>
    <button
        class="p-paging__link"
        :disabled="!slotProps.computed.nextPageUrl"
        :class="!slotProps.computed.nextPageUrl? 'u-cursor--not-allowed' : 'u-cursor--pointer'"
        v-on="slotProps.nextButtonEvents"
    >
        <slot name="next-nav">
            次へ
        </slot>
    </button>
    </li>
</ul>
</RenderlessPagination>
</template>

<script setup lang="ts">
import type { PaginateMeta, DataType } from '@/types/index';
import RenderlessPagination from 'laravel-vue-pagination/src/RenderlessPagination.vue';

const props = withDefaults(defineProps<PaginateMeta<DataType>>(),
{
    item_name: '',
    defaultValue: '',
    data: () => (
    {
        current_page: 0,
        data: [],
        first_page_url: null,
        from: 0,
        last_page: 0,
        last_page_url: null,
        links: [{
            url: null,
            label: '',
            active: false,
        }],
        next_page_url: null,
        path: '',
        per_page: 0,
        prev_page_url: null,
        to: 0,
        total: 0,
    }),
});

const onPaginationChangePage = (page: number): void =>
{

    emit('pagination-change-page', page);

}

const emit = defineEmits<{
    (event: 'pagination-change-page', page: number): void;
}>();
</script>