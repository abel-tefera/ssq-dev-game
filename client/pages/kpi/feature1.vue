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
                required
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
                type="number"
                name="year"
                required
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
                type="number"
                name="month"
                required
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
                type="number"
                name="value"
                
                required
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
                required
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
                required
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
    async submit() {
      let data;

      try {
        const response = await this.form.post("/kpi");
        data = response.data;
        alert("Submitted");
      } catch (e) {
        return;
      }
    },
  },
};
</script>
