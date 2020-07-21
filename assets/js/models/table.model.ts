import Invite from './invite.model';

export default class Table {

  public iri?: string;

  public id?: number;

  public nom: string = "";

  public image: string = '';

  public couleur: string = '#00000000';

  public invites: Invite[] = [];

  public addInvite(invite: Invite): Table {
    let exist = this.invites.find(inv => inv.iri === invite.iri)
    if (exist) {
      exist = invite;
    } else {
      this.invites.push(invite);
    }
    return this;
  }
}
