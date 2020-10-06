import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { PrivacyAgreementPageRoutingModule } from './privacy-agreement-routing.module';

import { PrivacyAgreementPage } from './privacy-agreement.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    PrivacyAgreementPageRoutingModule
  ],
  declarations: [PrivacyAgreementPage]
})
export class PrivacyAgreementPageModule {}
