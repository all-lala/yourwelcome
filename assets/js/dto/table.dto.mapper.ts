import TableDto from './table.dto';
import Table from '@/models/table.model';
import store from '@/store';

export default class TableDtoMapper {
	public static fromModel(table: Table): TableDto {
		const tableDto = new TableDto();

		tableDto['@id'] = table.iri;

		tableDto.couleur = table.couleur;

		tableDto.id = table.id;

		tableDto.image = table.image;

		tableDto.invites = table.invites.map(invite => invite.iri || '');

		tableDto.mariage = store.state.mariage.mariage.iri;

		tableDto.nom = table.nom;

		return tableDto;
	}

	public static toModel(tableDto: TableDto): Table {
		const table = new Table();

		table.iri = tableDto['@id'];

		table.id = tableDto.id;

		if (tableDto.nom) {
			table.nom = tableDto.nom;
		} 

		if (tableDto.image) {
			table.image = tableDto.image;
		}

		if (tableDto.couleur) {
			table.couleur = tableDto.couleur;
		}

		if (Array.isArray(tableDto.invites) && tableDto.invites.length) {
			tableDto.invites.forEach(inviteIri => {
				const invite = store.getters['invite/getInviteByIri'](inviteIri);
				if (invite) {
					table.invites.push(invite);
					invite.table = table;
				}
			})
		}

		return table;
	}

	public static fromModels(tables: Table[]): TableDto[] {
		return tables.map(table => TableDtoMapper.fromModel(table));
	}

	public static toModels(tablessDto: TableDto[]): Table[] {
		return tablessDto.map(table => TableDtoMapper.toModel(table));
	}
}