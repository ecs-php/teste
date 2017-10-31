import { Injectable } from '@angular/core';
import { Winners } from './winners';
import { Observable } from 'rxjs/Observable';
import { Response } from '@angular/http';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/catch';
import 'rxjs/add/operator/do';

@Injectable()
export class ApiService {
  private url = 'http://localhost/api/winners';

  constructor (private http: HttpClient) { }

  getWinners(): Observable<Winners> {
    return this.http.get(this.url,
      {
        headers: new HttpHeaders().set('Content-Type', 'application/json').set('Authorization', '1029371929182'),
      })
      .map((response: Response) => response.json())
      .do(data => console.log('All: ' + JSON.stringify(data)))
      .catch(this.handleError);
  }

  private handleError(error: Response) {
    console.error(error);
    return Observable.throw(error.json().error || 'Server error');
  }
}
