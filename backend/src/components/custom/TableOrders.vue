<template>
  <CardBoxModal
    v-model="modalState.isActive"
    title="Update Order"
    has-cancel
    @confirmation="modalConfirmation"
  >
    <p>You are being redirected to <b>Update Page.</b></p>
  </CardBoxModal>

  <div v-if="checkedRows.length" class="p-3 bg-gray-100/50 dark:bg-slate-800">
    <span
      v-for="checkedRow in checkedRows"
      :key="checkedRow.id"
      class="inline-block px-2 py-1 rounded-sm mr-2 text-sm bg-gray-100 dark:bg-slate-700"
    >
      {{ checkedRow.id }}
    </span>
  </div>

  <table>
    <thead>
      <tr>
        <th v-if="checkable" />
        <th>#</th>
        <th>ID</th>
        <th>Total Price</th>
        <th>Status</th>
        <th>Created By</th>
        <th>Updated By</th>
        <th>Created At</th>
        <th>Updated At</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(order, index) in itemsPaginated" :key="index">
        <TableCheckboxCell
          v-if="checkable"
          @checked="checked($event, order)"
        />
        <th data-label="#">
          {{ index + 1 }}
        </th>
        <td data-label="ID">
          {{ order.id }}
        </td>
        <td data-label="Title">
          ${{ order.total_price }}
        </td>
        <td data-label="Title">
          <span
            class="capitalize"
            :class="[
              order.status === 'paid' ? 'text-green-500'
              : order.status === 'shipped' ? 'text-sky-500'
              : order.status === 'pending' ? 'text-yellow-500'
              : order.status === 'cancelled' ? 'text-red-500'
              : ''
            ]">
            {{ order.status }}
          </span>
        </td>
        <td data-label="City">
          {{ order.created_by }}
        </td>
        <td data-label="City">
          {{ order.updated_by }}
        </td>
        <td data-label="City">
          {{ order.created_at }}
        </td>
        <td data-label="City">
          {{ order.updated_at }}
        </td>
        <!-- <td data-label="Progress" class="lg:w-32">
          <progress
            class="flex w-2/5 self-center lg:w-full"
            max="100"
            :value="order.progress"
          >
            {{ order.progress }}
          </progress>
        </td>
        <td data-label="Created" class="lg:w-1 whitespace-nowrap">
          <small
            class="text-gray-500 dark:text-slate-400"
            :title="order.created"
            >{{ order.created }}</small
          >
        </td> -->
        <td class="before:hidden lg:w-1 whitespace-nowrap">
          <BaseButtons type="justify-start lg:justify-end" no-wrap>
            <BaseButton
              color="info"
              :icon="mdiEye"
              small
              @click="modalActivation(order.id)"
            />
          </BaseButtons>
        </td>
      </tr>
    </tbody>
  </table>

  <div class="p-3 lg:px-6 border-t border-gray-100 dark:border-slate-800">
    <BaseLevel>
      <BaseButtons>
        <BaseButton
          v-for="page in pagesList"
          :key="page"
          :active="page === currentPage"
          :label="page + 1"
          :color="page === currentPage ? 'lightDark' : 'whiteDark'"
          small
          @click="currentPage = page"
        />
      </BaseButtons>
      <small>Page {{ currentPageHuman }} of {{ numPages }}</small>
    </BaseLevel>
  </div>
</template>

<script setup>
import { computed, ref, watch } from "vue";
import { mdiEye, mdiTrashCan } from "@mdi/js";
import CardBoxModal from "@/components/CardBoxModal.vue";
import TableCheckboxCell from "@/components/TableCheckboxCell.vue";
import BaseLevel from "@/components/BaseLevel.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import BaseButton from "@/components/BaseButton.vue";
import UserAvatar from "@/components/UserAvatar.vue";
import { useRouter } from "vue-router";
import { useStore } from "@/stores/store";
import { useOrderStore } from "@/stores/order";
import { useModalConfirmation } from "@/helpers/modalConfirmation";

const props = defineProps({
  checkable: Boolean,
  list: {
    type: Array,
    default: [],
  },
});

const router = useRouter();

const store = useStore();

const [modalState, modalActivation, modalConfirmation] = useModalConfirmation();

watch(modalState, (newVal, oldVal) => {
  if (newVal.allowed) {
    router.push({
      name: "app.orders.view",
      params: { id: newVal.id },
    });
  }
});

const items = ref(props.list);

const perPage = ref(5);

const currentPage = ref(0);

const checkedRows = ref([]);

const itemsPaginated = computed(() =>
  items.value.slice(
    perPage.value * currentPage.value,
    perPage.value * (currentPage.value + 1)
  )
);

const numPages = computed(() => Math.ceil(items.value.length / perPage.value));

const currentPageHuman = computed(() => currentPage.value + 1);

const pagesList = computed(() => {
  const pagesList = [];

  for (let i = 0; i < numPages.value; i++) {
    pagesList.push(i);
  }

  return pagesList;
});

const remove = (arr, cb) => {
  const newArr = [];

  arr.forEach((item) => {
    if (!cb(item)) {
      newArr.push(item);
    }
  });

  return newArr;
};

const checked = (isChecked, order) => {
  if (isChecked) {
    checkedRows.value.push(order);
  } else {
    checkedRows.value = remove(
      checkedRows.value,
      (row) => row.id === order.id
    );
  }
};
</script>
