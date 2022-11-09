<template>
  <div class="row">
    <div class="col-lg-8 m-auto">
      <card :title="$t('kpi')">
        <form @submit.prevent="submit" @keydown="form.onKeydown($event)">
          <!-- Email -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{
              $t("email")
            }}</label>
            <div class="col-md-7">
              <input
                v-model="form.email"
                :class="{ 'is-invalid': form.errors.has('email') }"
                type="email"
                name="email"
                class="form-control"
              />
              <has-error :form="form" field="email" />
            </div>
          </div>

          <!-- Name -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{
              $t("year")
            }}</label>
            <div class="col-md-7">
              <input
                v-model="form.year"
                :class="{ 'is-invalid': form.errors.has('year') }"
                type="text"
                name="year"
                class="form-control"
              />
              <has-error :form="form" field="year" />
            </div>
          </div>

          <!-- Name -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{
              $t("month")
            }}</label>
            <div class="col-md-7">
              <input
                v-model="form.month"
                :class="{ 'is-invalid': form.errors.has('month') }"
                type="text"
                name="month"
                class="form-control"
              />
              <has-error :form="form" field="month" />
            </div>
          </div>

          <!-- Name -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{
              $t("value")
            }}</label>
            <div class="col-md-7">
              <input
                v-model="form.value"
                :class="{ 'is-invalid': form.errors.has('value') }"
                type="text"
                name="value"
                class="form-control"
              />
              <has-error :form="form" field="value" />
            </div>
          </div>

          <!-- Name -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{
              $t("type")
            }}</label>
            <div class="col-md-7">
              <input
                v-model="form.type"
                :class="{ 'is-invalid': form.errors.has('type') }"
                type="text"
                name="type"
                class="form-control"
              />
              <has-error :form="form" field="type" />
            </div>
          </div>

          <!-- Name -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{
              $t("subtype")
            }}</label>
            <div class="col-md-7">
              <input
                v-model="form.subtype"
                :class="{ 'is-invalid': form.errors.has('subtype') }"
                type="text"
                name="subtype"
                class="form-control"
              />
              <has-error :form="form" field="subtype" />
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-7 offset-md-3 d-flex">
              <!-- Submit Button -->
              <v-button :loading="form.busy">
                {{ $t("submit") }}
              </v-button>

              <!-- GitHub Login Button -->
              <login-with-github />
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-7 offset-md-3 d-flex">
              <input type="file" @change="uploadFile" ref="file" />
              <button @click="submitFile">Upload!</button>
            </div>
          </div>
        </form>
      </card>
    </div>
  </div>
</template>

<script>
import Form from "vform";

export default {
  middleware: "guest",
  data: () => ({
    form: new Form({
      email: "",
      year: "",
      month: "",
      value: "",
      type: "",
      subtype: "",
      file: null,
    }),
    // mustVerifyEmail: false,
  }),

  head() {
    return { title: this.$t("kpi") };
  },

  methods: {
    uploadFile() {
      this.file = this.$refs.file.files[0];
    },
    async submit() {
      let data;

      try {
        const response = await this.form.post("/kpi");
        data = response.data;
      } catch (e) {
        return;
      }
    },
    async submitFile() {
      let data;

      const formData = new FormData();
      formData.append("file", this.file);
      const headers = { "Content-Type": "multipart/form-data" };

      try {
        const response = await this.form.post("/kpi/upload", formData, {
          headers,
        });

        data = res.data.files;
        const status = res.status;
      } catch (e) {
        return;
      }
    },
  },
};
</script>
