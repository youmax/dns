<template>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <form @submit.prevent="submit">
            <text-input
              v-model="form.name"
              :error="$page.errors.name"
              :label="__('role')"
              :placeholder="__('input', { name: __('role') })"
            />
            <dual-listbox
              v-model="form.permissions"
              :title-left="__('item_available', { name: __('permission') })"
              :left-items="permissions"
              :title-right="__('item_selected', { name: __('permission') })"
              :right-items="form.permissions"
              :error="$page.errors.permission"
              :label="__('permission')"
            />
            <div class="form-group">
              <loading-button
                :loading="sending"
                class="btn btn-primary"
                type="submit"
                >{{ __("roles.edit") }}
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
import DualListbox from "@/Shared/Forms/DualListbox";

export default {
  components: {
    LoadingButton,
    TextInput,
    DualListbox,
  },
  props: {
    role: Object,
    permissions: Array,
  },
  data() {
    return {
      sending: false,
      form: {
        name: this.role.name,
        permissions: this.role.permissions,
      },
    };
  },
  methods: {
    submit() {
      this.sending = true;
      this.$inertia
        .put(this.route("roles.update", this.role.id), this.form)
        .then(() => (this.sending = false));
    },
  },
};
</script>
