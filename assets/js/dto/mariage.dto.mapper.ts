import MariageDto from './mariage.dto';
import Mariage from '@/models/mariage.model';

export default class MariageDtoMapper {
	public static fromModel(mariage: Mariage): MariageDto {
		const mariageDto = new MariageDto();

		mariageDto['@id'] = mariage.iri;

		Object.assign(mariageDto, mariage);

		return mariageDto;
	}

	public static toModel(mariageDto: MariageDto): Mariage {
		const mariage = new Mariage();

		mariage.iri = mariageDto['@id'];

		Object.assign(mariage, mariageDto);

		return mariage;
	}

	public static fromModels(mariages: Mariage[]): MariageDto[] {
		return mariages.map(mariage => MariageDtoMapper.fromModel(mariage));
	}

	public static toModels(mariagessDto: MariageDto[]): Mariage[] {
		return mariagessDto.map(mariage => MariageDtoMapper.toModel(mariage));
	}

}