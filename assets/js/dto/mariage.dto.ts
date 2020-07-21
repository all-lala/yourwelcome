import Configuration from '@/models/configuration.model'
import ConfigurationsTheme from '@/models/configurationsTheme.model'
import ConfigurationsVictoire from '@/models/configurationsVictoire.model'

export default class MariageDto {
	public '@id'?: string;

	public configurations?: Configuration[];

	public configurationsTheme?: ConfigurationsTheme[];

	public configurationsVictoire?: ConfigurationsVictoire[];

	public date?: string;

	public localisation?: string;
	
	public nom?: string;
}