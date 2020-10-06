import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { ManagePasswordPageRoutingModule } from './manage-password-routing.module';

import { ManagePasswordPage } from './manage-password.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    ManagePasswordPageRoutingModule
  ],
  declarations: [ManagePasswordPage]
})
export class ManagePasswordPageModule {}
