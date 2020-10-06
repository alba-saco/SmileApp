import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { SelfDiagnoseResPageRoutingModule } from './self-diagnose-res-routing.module';

import { SelfDiagnoseResPage } from './self-diagnose-res.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    SelfDiagnoseResPageRoutingModule
  ],
  declarations: [SelfDiagnoseResPage]
})
export class SelfDiagnoseResPageModule {}
