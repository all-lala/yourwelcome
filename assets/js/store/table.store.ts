import Vue from 'vue';
import Table from "@/models/table.model";
import { Module, MutationTree, ActionTree } from 'vuex';
import Urls from '@/utils/urls';

interface TableStoreState {
  tables: Table[];
  table?: Table;
}

export default class TableStore implements Module<TableStoreState, any> {
  public namespaced = true;

  state: TableStoreState = {
    tables: [],
    table: undefined
  }

  mutations: MutationTree<TableStoreState> = {
    tables: (state: TableStoreState, tables: Table[]) => {
      state.tables = tables && tables.map(
        tab => Object.assign(new Table(), tab),
      );
    },
    table: (state: TableStoreState, table: Table) => {
      state.table = table
    },
  }

  actions: ActionTree<TableStoreState, any> = {
    loadTable(context, id) {
      Vue.$axios.get(`${Urls.TABLE}/${id}`).then(table => context.commit('table', table.data));
    },
    loadTables(context) {
      Vue.$axios.get(`${Urls.TABLE}`).then(tables => context.commit('tables', tables.data));
    },
    addTable(context, table: Table) {
      return Vue.$axios.post(`${Urls.TABLE}`, table).then(result => {
        context.dispatch('loadTables');
      });
    },
    updateTable(context, table: Table) {
      Vue.$axios.patch(`${Urls.TABLE}/${table.id}`, table).then((result) => {
        context.dispatch('loadTables');
      });
    },
    deleteTable: (context, table: Table) => {
      Vue.$axios.delete(`${Urls.TABLE}/${table.id}`).then((result) => {
        context.dispatch('loadTables');
      });
    },
  }
}