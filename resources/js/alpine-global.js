import { toArray } from "lodash";
import { post } from "./api";

document.addEventListener("alpine:init", () => {
  Alpine.store("app", {
    watchlistItems: Alpine.$persist([]),
  });

  Alpine.data("toast", () => ({
    visible: false,
    message: null,
    delay: 5000,
    percent: 0,
    interval: null,
    timeout: null,
    show(message) {
      this.visible = true;
      this.message = message;

      this.checkAndReset();

      this.timeout = setTimeout(() => {
        this.visible = false;
        this.timeout = null;
      }, this.delay);

      const startDate = Date.now();
      const futureDate = Date.now() + this.delay;

      this.interval = setInterval(() => {
        const date = Date.now();

        this.percent = (date - startDate) * 100 / (futureDate - startDate);
        if (this.percent >= 100) {
          clearInterval(this.interval);
          this.interval = null;
        }
      }, 1);
    },
    checkAndReset() {
      if (this.interval) {
        clearInterval(this.interval);
        this.interval = null;
      }

      if (this.timeout) {
        clearTimeout(this.timeout);
        this.timeout = null;
      }
    },
    close() {
      this.visible = false;
      this.checkAndReset();
    },
  }));

  Alpine.data("productItem", (product = {}) => ({
    product: product,
    async addToCart(quantity = 1) {
      try {
        const result = await post(this.product.addToCartUrl, { quantity });
        this.$dispatch("cart-change", { count: result.count });
        this.$dispatch("notify", {
          message: "The item has been added into the cart successfully.",
        });
      } catch (error) {
        console.log(error);
      }
    },
    async removeFromCart() {
      try {
        const result = await post(this.product.removeFromCartUrl);
        this.$dispatch("cart-change", { count: result.count });
        this.$dispatch("notify", {
          message: "The item has been removed from the cart successfully.",
        });
        this.cartItems = this.cartItems.filter((object) => object.id !== this.product.id);
      } catch (error) {
        console.log(error);
      }
    },
    async changeQuantity() {
      try {
        const result = await post(this.product.updateQuantityUrl, { quantity: this.product.quantity });
        this.$dispatch("cart-change", { count: result.count });
        this.$dispatch("notify", {
          message: "The item quantity has been updated",
        });
      } catch (error) {
        console.log(error);
      }
    },
    async addToWatchlist() {
      try {
        const result = await post(this.product.addToWatchlistUrl);
        this.watchlistManager(result);
      } catch (error) {
        console.log(error);
      }
    },
    async removeFromWatchlist() {
      try {
        const result = await post(this.product.removeFromWatchlistUrl);
        this.watchlistManager(result);
      } catch (error) {
        console.log(error);
      }
    },
    watchlistManager(result) {
      let messageKey = null;

      if (result.count < this.$store.app.watchlistItems.length) {
        messageKey = "removed from";
      } else {
        messageKey = "added into";
      }

      this.$store.app.watchlistItems = result.items;

      this.$dispatch("watchlist-change", { count: result.count });
      this.$dispatch("notify", {
        message: `The item has been ${messageKey} the watchlist.`,
      });
    },
    isInWatchlist() {
      return this.$store.app.watchlistItems?.some((object) => object.product_id === this.product.id);
    },
  }));

  Alpine.data("requestManager", (requests = []) => ({
    requests: requests,
    init() {
      this.$watch('$store.app.watchlistItems', (value, oldValue) => {
        if (value !== oldValue) return;
        this.watchlistStatus();
      });
    },
    async watchlistStatus() {
      try {
        const result = await post(this.requests.watchlistStatusUrl);
        this.$store.app.watchlistItems = result.items;
      } catch (error) {
        console.log(error);
      }
    }
  }));

  Alpine.data("checkout", (data) => ({
    user: data.user,
    customer: data.customer,
    countries: data.countries,
    states: {
      billing: [],
      shipping: []
    },
    billing: {
      first_name: null,
      last_name: null,
      phone: null,
      email: null,
      address1: null,
      address2: null,
      city: null,
      state: null,
      country_code: null,
      zip_code: null,
    },
    shipping: {
      first_name: null,
      last_name: null,
      phone: null,
      email: null,
      address1: null,
      address2: null,
      city: null,
      state: null,
      country_code: null,
      zip_code: null,
    },
    temp: {},
    init () {
      this.billing = data.billing;
      this.shipping = data.shipping;
      this.$watch(['billing.country_code', 'shipping.country_code'], () => {
        this.states.billing = this.getStates('billing');
        this.states.shipping = this.getStates('shipping');
      });
    },
    getStates(key) {
      const country = this.countries.find((object) => object.code === this[key]?.country_code);
      const _states = JSON.parse(country?.states)?.length > 0 ? JSON.parse(country?.states) : [];
      return _states;
    },
    get getAllStates() {
      const _states = this.countries.map((array) => JSON.parse(array.states))
        .filter((array) => array).flat();
      return _states;
    },
    sameAsBilling(event) {
      if (event.target.checked) {
        this.states.shipping = this.getStates('billing');

        setTimeout(()=> {
          this.temp = { ...this.shipping, type: 'shipping' };
          this.shipping = { ...this.billing, type: 'shipping' };
        }, 1);
      } else {
        this.shipping = { ...this.temp, type: 'shipping' };
      }
    },
  }));
});
