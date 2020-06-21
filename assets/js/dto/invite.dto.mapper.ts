import Invite from '@/models/invite.model';
import InviteDto from './invite.dto';
import store from '@/store';

export default class InviteDtoMapper{
	public static fromModel(invite: Invite): InviteDto {
		const inviteDto = new InviteDto();

		inviteDto['@id'] = invite.iri;
		inviteDto.id = invite.id;
		inviteDto.badge = invite.badge;
		inviteDto.nom = invite.nom;
		inviteDto.prenom = invite.prenom;
		inviteDto.mariage = store.state.mariage.mariage.iri;
		inviteDto.table = invite.table && invite.table.iri || null;

		return inviteDto;
	}

	public static toModel(inviteDto: InviteDto): Invite {
		const invite = new Invite();

		invite.iri = inviteDto['@id'];
		invite.id = inviteDto.id;
		invite.nom = inviteDto.nom;
		invite.prenom = inviteDto.prenom;
		invite.badge = inviteDto.badge;
		if(inviteDto.table){
			invite.table = store.getters['table/getTableByIri'](inviteDto.table);
			if(invite.table) {
				invite.table.addInvite(invite);
			}
		}

		return invite;
	}

	public static fromModels(invites: Invite[]): InviteDto[] {
		return invites.map(inv => InviteDtoMapper.fromModel(inv));
	}

	public static toModels(invitesDto: InviteDto[]): Invite[] {
		return invitesDto.map(inv => InviteDtoMapper.toModel(inv));
	}
}