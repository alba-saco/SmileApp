import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

import { Platform } from '@ionic/angular';
import { FileOpener } from '@ionic-native/file-opener/ngx';
import { DocumentViewer, DocumentViewerOptions } from '@ionic-native/document-viewer/ngx';
import { File } from '@ionic-native/file/ngx';

@Component({
  selector: 'app-privacy-agreement',
  templateUrl: './privacy-agreement.page.html',
  styleUrls: ['./privacy-agreement.page.scss'],
})
export class PrivacyAgreementPage implements OnInit {

    constructor(
      private router: Router,
      private platform: Platform,
      private file: File,
      private fileOpener: FileOpener,
      private document: DocumentViewer, 
      ) { }

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

    setreminder() {
        this.router.navigate(['tabs/reminder-setup'])
    };

  ngOnInit() {
  };

}
