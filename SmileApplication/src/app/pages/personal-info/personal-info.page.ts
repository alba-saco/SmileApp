import { Component, OnInit } from '@angular/core';
import { Location } from '@angular/common';
import { Router } from '@angular/router';

import { BehaviorSubject } from 'rxjs';
import { StorageService } from 'src/app/services/storage.service';
import { ToastService } from 'src/app/services/toast.service';
import { AuthService } from 'src/app/services/auth.service';

@Component({
  selector: 'app-personal-info',
  templateUrl: './personal-info.page.html',
  styleUrls: ['./personal-info.page.scss'],
})
export class PersonalInfoPage implements OnInit {

  userData$ = new BehaviorSubject<any>([]);
  firstName$ = new BehaviorSubject<any>([]);
  lastName$ = new BehaviorSubject<any>([]);
  email$ = new BehaviorSubject<any>([]);
  start_date$ = new BehaviorSubject<any>([]);

  constructor(
    private location: Location,
    private storageService: StorageService,
    private toastService: ToastService,
    private authService: AuthService, 
  ) { }

  postData = {
    userID: '',
    firstName: '',
    lastName: '',
    email: '',
  };
  
  back() {
    this.location.back();
  };

  validateInputs() {
    let dataDic = {
      firstName: this.firstName$.value,
      lastName: this.lastName$.value,
      email: this.email$.value,
    };
    let stringDic = ['firstName', 'lastName', 'email']
    for (let i of stringDic) {
      if (this.postData[i] === "") {
        this.postData[i] = dataDic[i]
      }
    };
    return (
      this.postData.email.trim() &&
      this.postData.email.trim().length > 2 &&
      this.postData.email.includes('@')
    );
  };

  saveChanges() {
    this.postData['userID'] = this.userData$.value

    if (this.validateInputs()) {
      this.authService.updateName(this.postData).subscribe(
        (res: any) => {
          if (res.userData) {
            
            // Succeful message
            this.toastService.presentToast(
              'Information changed successfully. Please login with the new information.'
            )
            this.authService.logout();
          } else {
              this.toastService.presentToast(
                'The email you entered already exists. Please try again.'
              );
              this.postData.email = '';
          }
        },
        (error: any) => {
          this.toastService.presentToast('Network Issue. Please try again.');
        });} else {
          this.toastService.presentToast('Please enter a correct email format.');
          this.postData.email = this.email$.value;
          }
  };

  ngOnInit() {
    this.storageService.get('userData').then(res => {
      this.userData$.next(res);
    });
    this.storageService.get('firstName').then(res => {
      this.firstName$.next(res);
    });
    this.storageService.get('lastName').then(res => {
      this.lastName$.next(res);
    });
    this.storageService.get('email').then(res => {
      this.email$.next(res);
    });
    this.storageService.get('start_date').then(res => {
      this.start_date$.next(res);
    });
  };

};
