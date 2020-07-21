import Table from '@/models/table.model';
import Urls from '@/utils/urls';
import TableDtoMapper from '@/dto/table.dto.mapper';
import Vue from 'vue';

export default class TableService {
	public static async getTables(): Promise<Table[]> {
      	return Vue.$axios.get(`${Urls.TABLE}`).then(
		  response => TableDtoMapper.toModels(response.data['hydra:member'])
		);
	}

	public static async getTable(tableIri: string): Promise<Table> {
      	return Vue.$axios.get(tableIri).then(
		  response => TableDtoMapper.toModel(response.data['hydra:member'])
		);
	}

	public static async addtable(table: Table): Promise<Table> {
	  	const tableDto = TableDtoMapper.fromModel(table);
      	return Vue.$axios.post(`${Urls.TABLE}`, tableDto).then(
        	response => TableDtoMapper.toModel(response.data)
      	);
	}

	public static async updateTable(table: Table): Promise<Table> {
		if(!table.iri){
			throw new Error('Table does not exist');
		}
		
		const tableDto = TableDtoMapper.fromModel(table);
		return Vue.$axios.put(table.iri, tableDto).then(
			response => TableDtoMapper.toModel(response.data)
		);
	}

	public static async deleteTable(table: Table): Promise<any> {
		if(!table.iri){
			throw new Error('Table does not exist');
		}
      	return Vue.$axios.delete(table.iri).then(response => response.data);
	}
}