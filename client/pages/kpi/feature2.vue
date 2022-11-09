<template>
  <div class="row">
    <div class="col-lg-8 m-auto">
      <card :title="$t('kpi')">
        <form @submit.prevent="submitFile" @keydown="form.onKeydown($event)">
          <div class="form-group row">
            <div class="col-md-7 offset-md-3 d-flex">
              <input
                type="file"
                @change="uploadFile"
                ref="file"
                accept=".txt, application/json"
              />
              <button @click="submitFile" :disabled="form.uploading">
                Upload!
              </button>
            </div>
          </div>
        </form>
      </card>
      <card v-if="data" :title="$t('Response')">
        <div v-for="{ kpi, errors } in data">
          <ul id="example-1" class="my-4">
            <vue-json-pretty :data="{ kpi }" />

            <li class="my-2" v-for="error in errors" style="color: red">
              {{...error}}
            </li>
            <div v-if="!errors" style="color: green">STORED</div>
          </ul>
        </div>
      </card>
      <vue-progress-bar></vue-progress-bar>
      <!-- <progress-bar :options="options" :value="50" /> -->
    </div>
  </div>
</template>
<script>
import Form from "vform";
import axios from "axios";

export default {
  middleware: "guest",
  data: () => ({
    form: new Form({
      file: null,
      uploading: false,
    }),
    data: null,
    // options: {
    //   text: {
    //     color: "#FFFFFF",
    //     shadowEnable: true,
    //     shadowColor: "#000000",
    //     fontSize: 14,
    //     fontFamily: "Helvetica",
    //     dynamicPosition: false,
    //     hideText: false,
    //   },
    //   progress: {
    //     color: "#2dbd2d",
    //     backgroundColor: "#333333",
    //     inverted: false,
    //   },
    //   layout: {
    //     height: 35,
    //     width: 140,
    //     verticalTextAlign: 61,
    //     horizontalTextAlign: 43,
    //     zeroOffset: 0,
    //     strokeWidth: 30,
    //     progressPadding: 0,
    //     type: "line",
    //   },
    // },
    // mustVerifyEmail: false,
  }),

  head() {
    return { title: this.$t("kpi") };
  },

  methods: {
    uploadFile() {
      const file = this.$refs.file.files[0];

      const fsize = file.size;
      const fileSize = Math.round(fsize / 1024);
      this.form.file = this.$refs.file.files[0];

      //   if (fileSize >= 4096 * 5) {
      //     alert("File too Big, please select a file less than 20mb");
      //   } else if (fileSize < 2048 / 1000) {
      //     alert("File too small, please select a file greater than 2kb");
      //   } else {
      //   }
    },
    async submitFile() {
      let data;

      if (this.form.file === null) {
        return;
      }
      this.$Progress.start();
      this.form.uploading = true;
      const formData = new FormData();
      formData.append("file", this.form.file);
      const headers = { "Content-Type": "multipart/form-data" };

      try {
        const response = await axios.post("/kpi/upload", formData, {
          headers,
        });
        this.data = response.data;
      } catch (e) {
        console.log(e);
        // return;
      } finally {
        this.$Progress.finish();
        this.form.uploading = false;
        // this.form.file = null;
      }
    },
  },
};
</script>
