import Invite from './invite.model';

export default class Table {
  public id?: number;

  public nom: string = "";

  public image: string = '';

  public couleur: string = '#00000000';

  public realImg: HTMLCanvasElement | null = null;

  public invites: Invite[] = [];

  public setInvites(invites: Invite[]) {
    this.invites = invites;
  }

  public addInvite(invite: Invite) {
    if (!this.invites.includes(invite)) {
      const newInvite = invite;
      newInvite.table = this;
      this.invites.push({ ...invite, ...{ table: undefined } });
    }
  }

  public removeInvite(invite: Invite) {
    this.invites = this.invites.filter(inv => inv.id !== invite.id);
    const newInvite = invite;
    newInvite.table = undefined;
  }
}
