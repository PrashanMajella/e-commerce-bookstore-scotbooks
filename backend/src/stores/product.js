import { defineStore } from "pinia";
import axiosClient from "@/api/axios";

export const useProductStore = defineStore("product", {
  state: () => {
    return {
      products: {
        loading: false,
        data: [],
        links: {},
        meta: {}
      },
      currentProduct: {
        loading: false,
        data: {}
      },
    };
  },
  getters: {},
  actions: {
    setProducts(products) {
      this.$patch((state) => {
        state.products = products
      });
    },
    setCurrentProduct(product) {
      this.$patch((state) => {
        state.currentProduct.data = product.data;
      });
    },
    setProductsLoading(loading) {
      this.$patch((state) => {
        state.products.loading = loading;
      });
    },
    setCurrentProductLoading(loading) {
      this.$patch((state) => {
        state.currentProduct.loading = loading;
      });
    },
    async saveProduct(product) {
      let result;

      if (product.image_url) {
        delete product.image_url;
      }

      this.setCurrentProductLoading(true);
      if (product.id) {
        try {
          result = await axiosClient.put(`/products/${product.id}`, product);
          this.setCurrentProduct(result.data);
          return result;
        } catch (error) {
          throw error;
        } finally {
          this.setCurrentProductLoading(false);
          this.getProducts();
        }
      } else {
        try {
          result = await axiosClient.post("/products", product);
          this.setCurrentProduct(result.data);
          return result;
        } catch (error) {
          throw error;
        } finally {
          this.setCurrentProductLoading(false);
          this.getProducts();
        }
      }
    },
    async getProduct(id) {
      this.setCurrentProductLoading(true);
      try {
        const result = await axiosClient.get(`/products/${id}`);
        this.setCurrentProduct(result.data);
        return result;
      } catch (error) {
        throw error;
      } finally {
        this.setCurrentProductLoading(false);
      }
    },
    async getProducts() {
      this.setProductsLoading(true);
      try {
        const { data } = await axiosClient.get("/products");
        this.setProducts(data);
        return data;
      } catch (error) {
        throw error;
      } finally {
        this.setProductsLoading(false);
      }
    },
    async deleteProduct(id) {
      try {
        return await axiosClient.delete(`/products/${id}`);
      } catch (error) {
        return error;
      } finally {
        this.getProducts();
      }
    },
  }
});

