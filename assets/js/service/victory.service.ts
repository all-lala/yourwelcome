import Victory from '@/models/victory.model';
import Urls from '@/utils/urls';
import Vue from 'vue';

export default class VictoryService {
	public static async getVictories(): Promise<Victory[]> {
      	return Vue.$axios.get(`${Urls.TABLE}`).then(
		  response => response.data['hydra:member']
		);
	}
}