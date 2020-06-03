import ConfigurationsTheme from './configurationsTheme.model';
import ConfigurationsVictoire from './configurationsVictoire.model';

export default class Mariage {
  public id?: number;

  public nom?: string;

  public date?: string;

  public location?: string;

  configurations?: { code: string, value: string }[]

  configurationsTheme?: ConfigurationsTheme[]

  configurationsVictoire?: ConfigurationsVictoire[]
}

