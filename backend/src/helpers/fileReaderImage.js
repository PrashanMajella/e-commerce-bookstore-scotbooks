import { reactive } from "vue";

export const useFileReaderImage = () => {
  const state = reactive({
    isActive: false,
    allowed: false,
    denied: false,
    loading: false,
    image: null,
  });

  const onChoose = async (event) => {
    const file = event.target.files[0];
    const reader = new FileReader();

    reader.onload = () => state.image = reader.result;
    reader.readAsDataURL(file);

    state.isActive = true;
    state.loading = true;

    setTimeout(() => {
      state.loading = false;
    }, 1000);

    return;
  };

  const confirmation = (boolean) => {
    if (boolean) {
      state.allowed = true;
      setTimeout(() => {
        state.allowed = false;
      }, 500);
    } else {
      state.denied = true;
      setTimeout(() => {
        state.denied = false;
        state.image = null;
      }, 500);
    }
    return;
  };

  return [state, onChoose, confirmation];
};
