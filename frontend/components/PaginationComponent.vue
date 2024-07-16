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
class="m-auto mb-8  flex gap-2 mt-4 text-xl w-[fit-content] items-center justify-center"
style="width: fit-content;"
>
    <li>
    <button type="button"
    class="p-paging__link"
    :disabled="!slotProps.computed.prevPageUrl"
    :class="!slotProps.computed.prevPageUrl? 'cursor-not-allowed' : 'cursor-pointer'"
    v-on="slotProps.prevButtonEvents"
    >
        <slot name="prev-nav">
            前へ
        </slot>
    </button>
    </li>
    <li class="flex gap-2">
    <span
        class="p-paging__link cursor-pointer rounded-full p-1 h-8 w-8 text-center"
        :class="{'bg-blue-500 text-white': slotProps.computed.currentPage === page, 'hover:bg-blue-200': slotProps.computed.currentPage !== page}"
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
        :class="!slotProps.computed.nextPageUrl? 'cursor-not-allowed' : 'cursor-pointer'"
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