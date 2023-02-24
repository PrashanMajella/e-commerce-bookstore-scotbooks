<template>
  <CardBoxModal
    v-model="modalState.isActive"
    title="View User"
    has-cancel
    @confirmation="modalConfirmation"
  >
    <p>You are being redirected to <b>View Page.</b></p>
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
        <th>Email Verified At</th>
        <th>Created At</th>
        <th>Updated At</th>
        <th>Is Admin</th>
        <th>Authorized By</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(user, index) in itemsPaginated" :key="index">
        <TableCheckboxCell v-if="checkable" @checked="checked($event, user)" />
        <th data-label="#">
          {{ index + 1 }}
        </th>
        <td data-label="ID">
          {{ user.id }}
        </td>
        <td data-label="Title">
          {{ user.name }}
        </td>
        <td data-label="Title">
          {{ user.email }}
        </td>
        <td data-label="City">
          {{ user.email_verified_at }}
        </td>
        <td data-label="City">
          {{ user.created_at }}
        </td>
        <td data-label="City">
          {{ user.updated_at }}
        </td>
        <td data-label="City">
          <input
            type="radio"
            :name="'is_admin-' + user.id"
            :id="'is_admin-' + user.id"
            :checked="user.is_admin"
            disabled
          />
        </td>
        <td data-label="City">
          <template v-if="user.authorized_by">
            <BaseButtons>
              <BaseButton
                :to="{
                  name: 'app.users.view',
                  params: {
                    id: user.authorized_by ?? 0
                  }
                }"
                :icon="mdiShieldAccount"
                label="Authorized By"
                color="contrast"
                rounded-full
                small
              />
            </BaseButtons>
          </template>
        </td>
        <td class="before:hidden lg:w-1 whitespace-nowrap">
          <BaseButtons type="justify-start lg:justify-end" no-wrap>
            <BaseButton
              color="info"
              :icon="mdiEye"
              small
              @click="modalActivation(user.id)"
            />
          </BaseButtons>
        </td>
      </tr>
    </tbody>
  </table>

  <div class="p-3 lg:px-6 buser-t buser-gray-100 dark:buser-slate-800">
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
import { mdiEye, mdiTrashCan, mdiShieldAccount } from "@mdi/js";
import CardBoxModal from "@/components/CardBoxModal.vue";
import TableCheckboxCell from "@/components/TableCheckboxCell.vue";
import BaseLevel from "@/components/BaseLevel.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import BaseButton from "@/components/BaseButton.vue";
import UserAvatar from "@/components/UserAvatar.vue";
import { useRouter } from "vue-router";
import { useStore } from "@/stores/store";
import { useUserStore } from "@/stores/user";
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
      name: "app.users.view",
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

const checked = (isChecked, user) => {
  if (isChecked) {
    checkedRows.value.push(user);
  } else {
    checkedRows.value = remove(checkedRows.value, (row) => row.id === user.id);
  }
};
</script>
