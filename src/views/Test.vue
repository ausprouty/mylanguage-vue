<template>
  <div>
    <h1>Select Test</h1>
    <BaseSelect
      label="Test"
      :options="test_options"
      v-model="test"
      v-on:change="runTest(test)"
      class="field"
    />
    {{ this.result }}
  </div>
</template>
<script>
import AuthorService from "@/services/AuthorService.js";
import BibleService from "@/services/BibleService.js";
import ContentService from "@/services/ContentService.js";

import LogService from "@/services/LogService.js";
import store from "@/store/store.js";
import { mapState } from "vuex";

export default {
  data() {
    return {
      test: "",
      result: "",
      test_options: ["testLogin"],
    };
  },
  computed: mapState(["user"]),
  methods: {
    async runTest(test) {
      var response = await this[test]();
      this.result = response;
      LogService.consoleLog(test, response);
    },
    setupParams() {
      var params = {};
      params.my_uid = store.state.user.uid;
      return params;
    },
    async testLogin() {
      var params = this.setupParams();
      params.password = "Ruth1987";
      params.username = "bob";
      var response = await AuthorService.login(params);
      return response;
    },
  },
};
</script>
