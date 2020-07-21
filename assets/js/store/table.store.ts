import Vue from 'vue';
import Table from "@/models/table.model";
import { Module, MutationTree, ActionTree, GetterTree } from 'vuex';
import Urls from '@/utils/urls';
import TableService from '@/service/table.service';

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
    tables(state: TableStoreState, tables: Table[]) {
      state.tables = tables && tables.map(
        tab => Object.assign(new Table(), tab),
      );
    },
    table(state: TableStoreState, table: Table) {
      state.table = table
    },
  }

  getters: GetterTree<TableStoreState, any> = {
    getTableByIri(state: TableStoreState) {
      return (tableIri: string) => state.tables && state.tables.find(table => table.iri === tableIri)
    }
  }

  actions: ActionTree<TableStoreState, any> = {
    loadTables(context) {
      TableService.getTables().then(tables => context.commit('tables', tables));
    },
    addTable(context, table: Table) {
      TableService.addtable(table).then(() => {
        context.dispatch('loadTables');
      });
    },
    updateTable(context, table: Table) {
      TableService.updateTable(table).then(() =>  {
        context.dispatch('loadTables');
      });
    },
    deleteTable: (context, table: Table) => {
      TableService.deleteTable(table).then(() => {
        context.dispatch('loadTables');
      });
    },
  }
}