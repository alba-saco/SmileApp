import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Location } from '@angular/common';
import { AuthConstants } from './../../config/auth-constants';
import { AuthService } from './../../services/auth.service';
import { StorageService } from './../../services/storage.service';
import { ToastService } from './../../services/toast.service';
import * as CryptoJS from 'crypto-js';

@Component({
  selector: 'app-new-user',
  templateUrl: './new-user.page.html',
  styleUrls: ['./new-user.page.scss'],
})
export class NewUserPage implements OnInit {

  monthNames = ["January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
  ];
  today = new Date();
  date = this.today.getDate()+' '+this.monthNames[this.today.getMonth()]+' '+this.today.getFullYear();

  postData = {
    firstName: '',
    lastName: '',
    email: '',
    password: '',
    confirmPassword: '',
    start_date: this.date,
  };

  constructor(
    private router: Router, 
    private location: Location,
    private authService: AuthService,
    private toastService: ToastService,
    private storageService: StorageService, ) { }

  back() {
      this.location.back();
  };

  validateInputs() {
    return (
      this.postData.firstName.trim() &&
      this.postData.lastName.trim() &&
      this.postData.email.trim() &&
      this.postData.password.trim() &&
      this.postData.firstName.trim().length > 0 &&
      this.postData.lastName.trim().length > 0 &&
      this.postData.email.trim().length > 2 &&
      this.postData.email.includes('@') &&
      this.postData.password.trim().length > 3 &&
      this.postData.password.trim() === this.postData.confirmPassword.trim()
    );
  };

  claerInput() {
    this.postData.email = '';
    this.postData.password = '';
    this.postData.confirmPassword = '';
  };
    
  Signup() {
    if (this.validateInputs()) {
      this.postData.password = CryptoJS.SHA3(this.postData.password).toString(CryptoJS.enc.Base64);

      this.authService.signup(this.postData).subscribe(
        (res: any) => {
          if (res.success) {
            
            // Storing the User data.
            this.storageService.store(AuthConstants.AUTH, res.userData);
            this.storageService.store(AuthConstants.firstName, res.firstName);
            this.storageService.store(AuthConstants.lastName, res.lastName);
            this.storageService.store(AuthConstants.email, res.email);
            this.storageService.store(AuthConstants.start_date, this.postData.start_date);
            this.storageService.store(AuthConstants.AUTH, res.userData).then(res => {
            this.router.navigate(['tabs/privacy-agreement']);
            });} else {
              this.toastService.presentToast(
                'This email address is alreay used. Please try another email address.'
              );
              this.claerInput();
          }
        },
        (error: any) => {
          this.toastService.presentToast('Network Issue. Please try again.');
          this.claerInput();
        });};
  };

  ngOnInit() {
  };

}
