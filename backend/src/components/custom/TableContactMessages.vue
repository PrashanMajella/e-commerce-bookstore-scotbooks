<template>
  <CardBoxModal
    v-model="modalState.isActive"
    title="Update Contact Message"
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
      {{ checkedRow.email }}
    </span>
  </div>

  <table>
    <thead>
      <tr>
        <th v-if="checkable" />
        <th>#</th>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Subject</th>
        <th>Message</th>
        <th>Seen</th>
        <th>Created At</th>
        <th>Updated At</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(contactMessage, index) in itemsPaginated" :key="index">
        <TableCheckboxCell
          v-if="checkable"
          @checked="checked($event, contactMessage)"
        />
        <th data-label="#">
          {{ index + 1 }}
        </th>
        <td data-label="ID">
          {{ contactMessage.id }}
        </td>
        <td data-label="Name">
          {{ contactMessage.first_name + " " + contactMessage.last_name }}
        </td>
        <td data-label="Email">
          {{ contactMessage.email }}
        </td>
        <td data-label="Subject">
          <span class="line-clamp-3">
            {{ contactMessage.subject }}
          </span>
        </td>
        <td data-label="Message">
          <span class="line-clamp-3">
            {{ contactMessage.message }}
          </span>
        </td>
        <td data-label="Seen">
          <input
            type="radio"
            :name="'seen' + contactMessage.id"
            :id="'seen' + contactMessage.id"
            :checked="contactMessage.seen"
            disabled
          />
        </td>
        <td data-label="Created At">
          {{ contactMessage.created_at }}
        </td>
        <td data-label="Updated At">
          {{ contactMessage.updated_at }}
        </td>
        <td class="before:hidden lg:w-1 whitespace-nowrap">
          <BaseButtons type="justify-start lg:justify-end" no-wrap>
            <BaseButton
              color="info"
              :icon="mdiEye"
              small
              @click="modalActivation(contactMessage.id)"
            />
          </BaseButtons>
        </td>
      </tr>
    </tbody>
  </table>

  <div
    class="p-3 lg:px-6 bcontactMessage-t bcontactMessage-gray-100 dark:bcontactMessage-slate-800"
  >
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
import { useContactMessageStore } from "@/stores/contactMessage";
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
      name: "app.contact.messages.view",
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

const checked = (isChecked, contactMessage) => {
  if (isChecked) {
    checkedRows.value.push(contactMessage);
  } else {
    checkedRows.value = remove(
      checkedRows.value,
      (row) => row.id === contactMessage.id
    );
  }
};
</script>
