import { reactive } from "vue";

export const useModalConfirmation = () => {
  const state = reactive({
    isActive: false,
    allowed: false,
    denied: false,
    id: 0
  });

  const activation = (id) => {
    state.isActive = true;
    state.id = id
  };

  const confirmation = (boolean) => {
    if (boolean && state.id) {
      state.allowed = true;
      setTimeout(() => {
        state.allowed = false;
        state.id = 0;
      }, 500);
    } else {
      state.denied = true;
      setTimeout(() => {
        state.denied = false;
        state.id = 0;
      }, 500);
    }
    return;
  };

  return [state, activation, confirmation];
};
