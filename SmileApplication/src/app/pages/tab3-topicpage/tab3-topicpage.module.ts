import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { Tab3TopicpagePageRoutingModule } from './tab3-topicpage-routing.module';

import { Tab3TopicpagePage } from './tab3-topicpage.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    Tab3TopicpagePageRoutingModule
  ],
  declarations: [Tab3TopicpagePage]
})
export class Tab3TopicpagePageModule {}
