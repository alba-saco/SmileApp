import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Location } from '@angular/common';

import { StorageService } from 'src/app/services/storage.service';
import { ToastService } from 'src/app/services/toast.service';
import { AuthService } from 'src/app/services/auth.service';
import { BehaviorSubject } from 'rxjs';

import * as CryptoJS from 'crypto-js';

@Component({
  selector: 'app-manage-password',
  templateUrl: './manage-password.page.html',
  styleUrls: ['./manage-password.page.scss'],
})
export class ManagePasswordPage implements OnInit {

  userData$ = new BehaviorSubject<any>([]);

  constructor(
    private router: Router,
    private location: Location,
    private storageService: StorageService,
    private toastService: ToastService,
    private authService: AuthService,
  ) { }

  
  postData = {
    userID: '',
    password: '',
    new_password: '',
    confirm_password: '',
  };

  back() {
    this.location.back();
  };

  validateInputs() {
    return (
      this.postData.password.trim() &&
      this.postData.new_password.trim() &&
      this.postData.confirm_password.trim() &&
      this.postData.password.trim().length > 3 &&
      this.postData.new_password.trim().length > 3 &&
      this.postData.new_password.trim() === this.postData.confirm_password.trim()
    );
  };

  claerInput() {
    this.postData = {
      userID: '',
      password: '',
      new_password: '',
      confirm_password: '',
    };
  };

  saveChanges() {
    this.postData['userID'] = this.userData$.value

    if (this.validateInputs()) {
      this.postData.password = CryptoJS.SHA3(this.postData.password).toString(CryptoJS.enc.Base64);
      this.postData.new_password = CryptoJS.SHA3(this.postData.new_password).toString(CryptoJS.enc.Base64);
      this.authService.updatePassword(this.postData).subscribe(
        (res: any) => {
          if (res.userData) {
            
            // Succeful message
            this.toastService.presentToast(
              'Password succcessfully updated! Please login with the new information.'
            )
            this.authService.logout();
          } else {
              this.toastService.presentToast(
                'Current password is incorrect. Please try again.'
              );
              this.claerInput();
          }
        },
        (error: any) => {
          this.toastService.presentToast('Network Issue. Please try again');
        });} else {
          this.toastService.presentToast('New password connot be the same as the old password. Please try again.');
          };
          this.claerInput();
  };

  ngOnInit() {
    this.storageService.get('userData').then(res => {
      this.userData$.next(res);
    });
  };

}
