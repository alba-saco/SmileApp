import { Component, OnInit } from '@angular/core';

import { Router } from '@angular/router';
import { Location } from '@angular/common';
import { AuthService } from 'src/app/services/auth.service';
import { StorageService } from 'src/app/services/storage.service';

import { Platform } from '@ionic/angular';
import { FileOpener } from '@ionic-native/file-opener/ngx';
import { DocumentViewer, DocumentViewerOptions } from '@ionic-native/document-viewer/ngx';
import { File } from '@ionic-native/file/ngx';

@Component({
  selector: 'app-settings',
  templateUrl: './settings.page.html',
  styleUrls: ['./settings.page.scss'],
})
export class SettingsPage implements OnInit {

    constructor(
        private router: Router, 
        private location: Location,
        private authService: AuthService,
        private storageService: StorageService,
        private platform: Platform,
        private file: File,
        private fileOpener: FileOpener,
        private document: DocumentViewer, 
    ) { }

    back() {
        this.location.back();
    };

    logout() {
        this.authService.logout();
    };

    reminders() {
        this.router.navigate(['tabs/reminders']);
    };

    personalInfo() {
        this.router.navigate(['tabs/personal-info']);
    };

    managePassword() {
        this.router.navigate(['tabs/manage-password']);
    };

    privacyAgreement() {
        let GDPR = this.file.applicationDirectory + 'public/assets/';
        if (this.platform.is('android')) {
          let tempName = Date.now();
          this.file.copyFile(GDPR, 'Smile_GDPR_UCL_Eastman.pdf', this.file.dataDirectory, `${tempName}.pdf`).then(result => {
            this.fileOpener.open(result.nativeURL, 'application/pdf');
          });
        } else {
          const options: DocumentViewerOptions = {
            title: 'Smile. Privacy Agreement'
          }
          this.document.viewDocument(`${GDPR}/Smile_GDPR_UCL_Eastman.pdf`, 'application/pdf', options);
        }
    };

  ngOnInit() {
  }

}
