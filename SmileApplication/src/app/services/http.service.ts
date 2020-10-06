import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from '../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class HttpService {

  constructor(private http: HttpClient) { }

  post(serviceName: string, data: any) {
    const headers = new HttpHeaders();
    const options = { headers: headers, withCredintials: false };
    let url = '';
    if (serviceName === "login") {
      url = environment.loginUrl;
    } else if (serviceName === "stats") {
      url = environment.questionnaire_stats;
    } else {
      url = environment.manageUrl;
    };
    return this.http.post(url, JSON.stringify(data), options);
  }
}