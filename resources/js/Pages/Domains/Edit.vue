<template>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <form @submit.prevent="submit">
            <text-select-input
              v-model="form.platform_id"
              :error="$page.errors.platform_id"
              :options="platforms"
              :placeholder="__('input', {name: __('platform')})"
              :label="__('platform')"
              :taggable="false"
            />
            <text-input
              v-model="form.name"
              :error="$page.errors.name"
              :label="__('domain')"
            />
            <text-select-input
              v-model="form.protocols"
              :error="$page.errors.protocols"
              :options="protocols"
              :placeholder="__('input', {name: __('protocol')})"
              :label="__('protocol')"
              :taggable="false"
              :multiple="true"
            />
            <toggle-input
              v-model="form.backup"
              :error="$page.errors.backup"
              :label="__('backup')"
            />
            <toggle-input
              v-model="form.renew"
              :error="$page.errors.renew"
              :label="__('renew')"
            />
            <toggle-input
              v-model="form.enable"
              :error="$page.errors.enable"
              :label="__('enable')"
            />
            <text-input
              v-model="form.remark"
              :error="$page.errors.remark"
              :label="__('remark')"
              :placeholder="__('input', { name: __('remark') })"
            />
            <div class="form-group">
              <loading-button
                :loading="sending"
                class="btn btn-primary"
                type="submit"
              >
                {{ __("domains.edit") }}
              </loading-button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import LoadingButton from "@/Shared/Forms/LoadingButton";
import TextInput from "@/Shared/Forms/TextInput";
import TextSelectInput from "@/Shared/Forms/TextSelectInput";
import ToggleInput from "@/Shared/Forms/ToggleInput";
import mapValues from "lodash/mapValues";

export default {
  components: {
    LoadingButton,
    ToggleInput,
    TextInput,
    TextSelectInput,
  },
  props: {
    domain: Object,
    platforms: Array,
    protocols: Array,
  },
  data() {
    return {
      sending: false,
      form: {
        platform_id: this.domain.platform_id,
        name: this.domain.name,
        protocols: this.domain.protocols,
        backup: this.domain.backup,
        renew: this.domain.renew,
        remark: this.domain.remark,
        enable: this.domain.enable,
      },
    };
  },
  methods: {
    submit() {
      this.sending = true;
      this.$page.errors = mapValues(this.form, () => "");
      console.log(this.form)
      this.$inertia
        .put(this.route("domains.update", this.domain.id), this.form)
        .then(() => {
          this.sending = false;
        });
    },
  },
};
</script>
