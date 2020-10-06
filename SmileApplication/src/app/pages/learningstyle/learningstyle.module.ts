import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { LearningstylePageRoutingModule } from './learningstyle-routing.module';

import { LearningstylePage } from './learningstyle.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    LearningstylePageRoutingModule
  ],
  declarations: [LearningstylePage]
})
export class LearningstylePageModule {}
