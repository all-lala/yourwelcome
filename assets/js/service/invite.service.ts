import Invite from '@/models/invite.model';
import Urls from '@/utils/urls';
import InviteDtoMapper from '@/dto/invite.dto.mapper';
import Vue from 'vue';

export default class InviteService {
	public static async getInvites(): Promise<Invite[]> {
      	return Vue.$axios.get(`${Urls.INVITE}`).then(
		  response => InviteDtoMapper.toModels(response.data['hydra:member'])
		);
	}

	public static async getInvite(inviteIri: string): Promise<Invite> {
      	return Vue.$axios.get(inviteIri).then(
		  response => InviteDtoMapper.toModel(response.data['hydra:member'])
		);
	}

	public static async addinvite(invite: Invite): Promise<Invite> {
	  	const inviteDto = InviteDtoMapper.fromModel(invite);
      	return Vue.$axios.post(`${Urls.INVITE}`, inviteDto).then(
        	response => InviteDtoMapper.toModel(response.data)
      	);
	}

	public static async updateInvite(invite: Invite): Promise<Invite> {
		if(!invite.iri){
			throw new Error('Invite does not exist');
		}
		
		const inviteDto = InviteDtoMapper.fromModel(invite);
		return Vue.$axios.put(invite.iri, inviteDto).then(
			response => InviteDtoMapper.toModel(response.data)
		);
	}

	public static async deleteInvite(invite: Invite): Promise<any> {
		if(!invite.iri){
			throw new Error('Invite does not exist');
		}
      	return Vue.$axios.delete(invite.iri).then(response => response.data);
	}
}