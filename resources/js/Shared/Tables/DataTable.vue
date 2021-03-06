<template>
  <div class="card">
    <div class="card-header">
      <slot name="header">
        <search-filter v-model="form.search" @reset="reset">
          <div class="row">
            <label class="col-12 form-control-label"
              >{{ __("trashed") }}:</label
            >
            <div class="col-12">
              <select v-model="form.trashed" class="form-control mb-3">
                <option :value="null">--</option>
                <option value="with">{{ __("with_trashed") }}</option>
                <option value="only">{{ __("only_trashed") }}</option>
              </select>
            </div>
          </div>
          <slot slot="append">
            <slot name="append" v-bind="{ props: $props, data: $data }" />
          </slot>
        </search-filter>
      </slot>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <vuetable
          ref="vuetable"
          :api-url="apiUrl"
          :fields="fields"
          :css="css.table"
          :multi-sort="multiSort"
          :data-path="dataPath"
          pagination-path=""
          :data-manager="dataManager"
          :append-params="form"
          @vuetable:pagination-data="onPaginationData"
          @vuetable:row-clicked="rowClicked"
        >
          <template
            v-for="(_, slot) of $scopedSlots"
            :slot="slot"
            slot-scope="props"
          >
            <slot :name="slot" v-bind="props" />
          </template>
        </vuetable>
      </div>
    </div>
    <div class="card-footer">
      <data-table-pagination
        ref="pagination"
        :css="css.pagination"
        :info-template="infoTemplate"
        @vuetable-pagination:change-page="onChangePage"
      />
    </div>
  </div>
</template>

<script>
import Vue from 'vue'
import { Vuetable } from "vuetable-2";
import VuetableFieldCheckbox from 'vuetable-2/src/components/VuetableFieldCheckbox.vue';
import SearchFilter from "@/Shared/Tables/SearchFilter";
import throttle from "lodash/throttle";
import mapValues from "lodash/mapValues";
import DataTablePagination from "@/Shared/Tables/DataTablePagination";

Vue.component('vuetable-field-checkbox', VuetableFieldCheckbox)

export default {
  components: {
    Vuetable,
    SearchFilter,
    DataTablePagination,
  },
  props: {
    apiMode: {
      type: Boolean,
      default: true,
    },
    apiUrl: {
      type: String,
      default: "https://vuetable.ratiw.net/api/users",
    },
    fields: {
      type: Array,
      default: () => ["name", "nickname", "email", "gender"],
    },
    filters: {
      type: Object,
      default: () => {
        return {
          search: "",
          trashed: "",
        };
      },
    },
    multiSort: {
      type: Boolean,
      default: true,
    },
    infoTemplate: {
      type: String,
      default: "Displaying {from} to {to} of {total} items",
    },
    dataPath: {
      type: String,
      default: "data",
    },
    tableHeaderClass:{
      type: String,
      default: 'text-left font-bold'
    }
  },
  data() {
    return {
      css: {
        table: {
          tableWrapper: "table-responsive",
          tableHeaderClass: this.tableHeaderClass,
          tableBodyClass: "",
          tableClass: "table table-striped table-hover mb-0",
          loadingClass: "loading",
          ascendingIcon: "fa fa-angle-up",
          descendingIcon: "fa fa-angle-down",
          ascendingClass: "sorted-asc",
          descendingClass: "sorted-desc",
          sortableIcon: "",
          detailRowClass: "vuetable-detail-row",
          handleIcon: "fa-bars text-secondary",
          renderIcon(classes, options) {
            return `<i class="${classes.join(" ")}" ${options}></span>`;
          },
        },
        pagination: {
          wrapperClass: "pagination pagination-primary justify-content-center",
          activeClass: "active",
          disabledClass: "disabled",
          pageClass: "page-item",
          linkClass: "page-item",
          paginationClass: "pagination",
          paginationInfoClass: "float-right",
          dropdownClass: "form-control",
          infoClass: "text-center mr-auto mb-3",
          icons: {
            first: "fa fa-angle-double-left",
            prev: "fa fa-angle-left",
            next: "fa fa-angle-right",
            last: "fa fa-angle-double-right",
          },
        },
      },
      form: this.filters
    };
  },
  computed:{
      selectedTo(){
        return this.$refs.vuetable.selectedTo || [];
      } 
  },
  watch: {
    form: {
      handler: throttle(function () {
        this.$nextTick(() => this.$refs.vuetable.refresh());
      }, 150),
      deep: true,
    },
  },
  methods: {
    onPaginationData(paginationData) {
      this.$refs.pagination.setPaginationData(paginationData);
    },
    onChangePage(page) {
      this.$refs.vuetable.changePage(page);
    },
    dataManager(sortOrder, pagination) {
      if (this.data.length < 1) return;

      let local = this.data;

      // sortOrder can be empty, so we have to check for that as well
      if (sortOrder.length > 0) {
        console.log("orderBy:", sortOrder[0].sortField, sortOrder[0].direction);
        local = _.orderBy(
          local,
          sortOrder[0].sortField,
          sortOrder[0].direction
        );
      }

      pagination = this.$refs.vuetable.makePagination(
        local.length,
        this.perPage
      );
      let from = pagination.from - 1;
      let to = from + this.perPage;

      return {
        pagination: pagination,
        data: _.slice(local, from, to),
      };
    },
    reset() {
      this.form = mapValues(this.form, () => null);
    },
    refresh() {
      this.$refs.vuetable.refresh();
    },
    reload() {
      this.$refs.vuetable.reload();
    },
    rowClicked(data)
    {
      this.$emit('vuetable:row-clicked', data)
    }
  },
};
</script>
<style scoped>
>>> .vuetable-slot .btn-sm {
  width: 36px;
  height: 36px;
  align-items: center;
  display: inline-flex;
  justify-content: center;
  margin-right: 10px;
}
>>> .table > thead > tr > th {
  font-size: 1rem;
  white-space: pre;
  line-height: 1;
}
</style>