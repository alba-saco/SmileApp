import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { ReadTextPageRoutingModule } from './read-text-routing.module';

import { ReadTextPage } from './read-text.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    ReadTextPageRoutingModule
  ],
  declarations: [ReadTextPage]
})
export class ReadTextPageModule {}
