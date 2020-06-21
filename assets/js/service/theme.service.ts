import Theme from '@/models/theme.model';
import Urls from '@/utils/urls';
import Vue from 'vue';

export default class ThemeService {
	public static async getThemes(): Promise<Theme[]> {
      	return Vue.$axios.get(`${Urls.TABLE}`).then(
		  response => response.data['hydra:member']
		);
	}
}