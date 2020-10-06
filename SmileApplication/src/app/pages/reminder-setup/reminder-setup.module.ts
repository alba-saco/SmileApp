import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { ReminderSetupPageRoutingModule } from './reminder-setup-routing.module';

import { ReminderSetupPage } from './reminder-setup.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    ReminderSetupPageRoutingModule
  ],
  declarations: [ReminderSetupPage]
})
export class ReminderSetupPageModule {}
