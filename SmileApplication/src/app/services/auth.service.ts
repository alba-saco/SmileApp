import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { BehaviorSubject, Observable } from 'rxjs';
import { HttpService } from './http.service';
import { StorageService } from './storage.service';
import { AuthConstants } from '../config/auth-constants';
import { LoginCredential, PostData, ChangeInfo, ChangePassword, UpdateStats } from '../types';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  userData$ = new BehaviorSubject<any>([]);

  constructor(
    private httpService: HttpService,
    private storageService: StorageService,
    private router: Router, ) { }

    getUserData() {
      this.storageService.get(AuthConstants.AUTH).then(res => {
        this.userData$.next(res);
      });
    };

    login(credential: LoginCredential): Observable<any> {
      return this.httpService.post('login', {
        email: credential.email, 
        password: credential.password,
      });
    };
    
    signup(postData: PostData): Observable<any> {
      return this.httpService.post('signup', {
        first_name: postData.firstName, 
        last_name: postData.lastName, 
        email: postData.email, 
        password: postData.password, 
        start_date: postData.start_date, 
        key: 'signup',
      });
    };

    updateName(changeInfo: ChangeInfo): Observable<any> {
      return this.httpService.post('updateName', {
        userID: changeInfo.userID, 
        first_name: changeInfo.firstName, 
        last_name: changeInfo.lastName, 
        email: changeInfo.email, 
        key: 'updateName',
      });
    };

    updatePassword(changePassword: ChangePassword): Observable<any> {
      return this.httpService.post('updatePassword', {
        userID: changePassword.userID, 
        password: changePassword.password, 
        new_password: changePassword.new_password, 
        key: 'updatePassword',
      });
    };

    updateStats(stats: UpdateStats): Observable<any> {
      return this.httpService.post('stats', {
        total_count_message_A: stats.total_count_message_A, 
        Q1_count_message_A: stats.Q1_count_message_A, 
        Q2_count_message_A: stats.Q2_count_message_A,
        Q4_count_message_A: stats.Q4_count_message_A,
        Q5_count_message_A: stats.Q5_count_message_A,
        Q6_count_message_A: stats.Q6_count_message_A,
        Q7_count_message_C: stats.Q7_count_message_C,
        Q8_count_message_D: stats.Q8_count_message_D,
      });
    };
    
    logout() {
      this.storageService.clear().then(res => {
      this.router.navigate(['']);
      });
    };
}
