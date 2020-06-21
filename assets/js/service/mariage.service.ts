import MariageDtoMapper from '@/dto/mariage.dto.mapper';
import Urls from '@/utils/urls';
import Vue from 'vue';
import Mariage from '@/models/mariage.model';

export default class MariageService {
	public static async getMariage(): Promise<Mariage> {
		return Vue.$axios.get(`${Urls.MARIAGE}`).then(
		  response => MariageDtoMapper.toModel(response.data['hydra:member'][0])
		);
	}

	public static async updateMariage(mariage: Mariage): Promise<Mariage> {
		if(!mariage.iri){
			throw new Error('Table does not exist');
		}
		
		const mariageDto = MariageDtoMapper.fromModel(mariage);
		return Vue.$axios.put(mariage.iri, mariageDto).then(
			response => MariageDtoMapper.toModel(response.data)
		);
	}
}