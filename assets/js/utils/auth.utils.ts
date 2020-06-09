export default class AuthUtils {
  /**
   * Parse JWT troken
   * @param token
   * @returns any
   */
  public static parseJwt(token: string): any {
    const base64Url = token.split('.')[1];
    const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
    const jsonPayload = decodeURIComponent(atob(base64).split('').map(c => `%${(`00${c.charCodeAt(0).toString(16)}`).slice(-2)}`).join(''));
  
    return JSON.parse(jsonPayload);
  }
  
  /**
   * Return if JWT Token is valid
   * 
   * @param authorization 
   */
  public static validJwt(authorization: string | null) {
    return !!authorization && (AuthUtils.parseJwt(authorization).exp - (new Date().getTime() / 1000) > 0);
  }

  /**
   * Get JWT Token
   * @returns string
   */
  public static getTocken(): string{
    return sessionStorage.getItem('Authorization') || '';
  }

  /**
   * Set JWT Token
   * @param token 
   */
  public static setToken(token: string): void {
    sessionStorage.setItem('Authorization', token);
  }

  /**
   * Remove JWT Token
   */
  public static removeToken(): void {
    sessionStorage.removeItem('Authorization');
  }

  /**
   * Return if user is authenticated
   */
  public static isAuthenticated() : boolean {
    const authorization = AuthUtils.getTocken();
    return AuthUtils.validJwt(authorization);
  }

  /**
   * Return datas from actuel JWT token
   */
  public static getTokenData(): any {
    return AuthUtils.parseJwt(AuthUtils.getTocken())
  }

  /**
   * Disconnect user by remove JWT tocken
   */
  public static disconnect(): void {
    AuthUtils.removeToken();
  }
}