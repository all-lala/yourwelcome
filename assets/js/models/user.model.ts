import Mariage from './mariage.model';

export default class User {
  public id?: number;

  public email?: string;

  public password?: string;

  public mariage?: Mariage;

  public static createUser(mariage?: Mariage): User {
    const user = new User();
    if (!mariage) {
      mariage = new Mariage();
    }
    user.mariage = mariage;

    return user;
  }
}