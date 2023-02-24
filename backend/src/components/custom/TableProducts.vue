<template>
  <CardBoxModal
    v-model="modalState.isActive"
    title="Update Product"
    has-cancel
    @confirmation="modalConfirmation"
  >
    <p>You are being redirected to <b>Update Page.</b></p>
  </CardBoxModal>

  <CardBoxModal
    v-model="modalDeleteState.isActive"
    title="Delete Products"
    button="danger"
    has-cancel
    @confirmation="modalDeleteConfirmation"
  >
    <p>Are you sure you want to <b>delete</b> this product?</p>
    <p>This operation cant't be undone!</p>
  </CardBoxModal>

  <div v-if="checkedRows.length" class="p-3 bg-gray-100/50 dark:bg-slate-800">
    <span
      v-for="checkedRow in checkedRows"
      :key="checkedRow.id"
      class="inline-block px-2 py-1 rounded-sm mr-2 text-sm bg-gray-100 dark:bg-slate-700"
    >
      {{ checkedRow.title }}
    </span>
  </div>

  <table>
    <thead>
      <tr>
        <th v-if="checkable" />
        <th>#</th>
        <th>Image</th>
        <th>ID</th>
        <th>Title</th>
        <th>Updated At</th>
        <!-- <th>Progress</th>
        <th>Created</th> -->
        <th></th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(product, index) in itemsPaginated" :key="index">
        <TableCheckboxCell
          v-if="checkable"
          @checked="checked($event, product)"
        />
        <th data-label="#">
          {{ index + 1 }}
        </th>
        <td class="border-b-0 lg:w-[200px] before:hidden">
          <img
            :src="product.image_url ?? store.assets.image.emptyItem"
            :alt="product.title"
            class="w-[150px] h-[240px] mx-auto lg:w-[100px] lg:h-[160px] object-cover rounded-md"
          />
        </td>
        <td data-label="ID">
          {{ product.id }}
        </td>
        <td data-label="Title">
          {{ product.title }}
        </td>
        <td data-label="City">
          {{ product.updated_at }}
        </td>
        <!-- <td data-label="Progress" class="lg:w-32">
          <progress
            class="flex w-2/5 self-center lg:w-full"
            max="100"
            :value="product.progress"
          >
            {{ product.progress }}
          </progress>
        </td>
        <td data-label="Created" class="lg:w-1 whitespace-nowrap">
          <small
            class="text-gray-500 dark:text-slate-400"
            :title="product.created"
            >{{ product.created }}</small
          >
        </td> -->
        <td class="before:hidden lg:w-1 whitespace-nowrap">
          <BaseButtons type="justify-start lg:justify-end" no-wrap>
            <BaseButton
              color="info"
              :icon="mdiEye"
              small
              @click="modalActivation(product.id)"
            />
            <BaseButton
              color="danger"
              :icon="mdiTrashCan"
              small
              @click="modalDeleteActivation(product.id)"
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
import { useProductStore } from "@/stores/product";
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

const [modalDeleteState, modalDeleteActivation, modalDeleteConfirmation] =
  useModalConfirmation();

watch(modalState, (newVal, oldVal) => {
  if (newVal.allowed) {
    router.push({
      name: "app.products.view",
      params: { id: newVal.id },
    });
  }
});

watch(modalDeleteState, (newVal, oldVal) => {
  if (newVal.allowed) {
    (async () => {
      try {
        return await useProductStore().deleteProduct(newVal.id);
      } catch (error) {
        return error;
      }
    })();
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

const checked = (isChecked, product) => {
  if (isChecked) {
    checkedRows.value.push(product);
  } else {
    checkedRows.value = remove(
      checkedRows.value,
      (row) => row.id === product.id
    );
  }
};
</script>
