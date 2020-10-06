import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

import { ToastService } from './../../services/toast.service';

import { AuthConstants } from '../../config/auth-constants';
import { AuthService } from './../../services/auth.service';
import { StorageService } from './../../services/storage.service';
import * as CryptoJS from 'crypto-js';

@Component({
  selector: 'app-welcome-page',
  templateUrl: './welcome-page.page.html',
  styleUrls: ['./welcome-page.page.scss'],
})
export class WelcomePagePage implements OnInit {

  credential = {
    email: '',
    password: ''
  };

  constructor(
    private router: Router, 
    private authService: AuthService,
    private storageService: StorageService, 
    private toastService: ToastService
    ) { }

  register() {
      this.router.navigate(['./new-user'])
  };

  validateInputs() {
    return (
    this.credential.email.includes('@') &&
    this.credential.email &&
    this.credential.password &&
    this.credential.email.trim().length > 2 &&
    this.credential.password.trim().length > 3
    );
  };
  
  loginAction() {
    if (this.validateInputs()) {
      this.credential.password = CryptoJS.SHA3(this.credential.password).toString(CryptoJS.enc.Base64);
      
      this.authService.login(this.credential).subscribe(
        (res: any) => {
          if (res.success) {

            // Storing the User data.
            this.storageService.store(AuthConstants.AUTH, res.userData);
            this.storageService.store(AuthConstants.firstName, res.firstName);
            this.storageService.store(AuthConstants.lastName, res.lastName);
            this.storageService.store(AuthConstants.email, res.email);
            this.storageService.store(AuthConstants.start_date, res.start_date);
            this.router.navigate(['/tabs']);
          } else {
          this.toastService.presentToast('Incorrect email or password.');
          this.credential.password = '';
        }},
        (error: any) => {
        this.toastService.presentToast('Network Issue. Please try again.');
        this.credential.password = '';
        }
      );
    }
  };

  ngOnInit() {
  };

}
