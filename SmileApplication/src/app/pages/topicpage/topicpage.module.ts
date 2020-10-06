import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { TopicpagePageRoutingModule } from './topicpage-routing.module';

import { TopicpagePage } from './topicpage.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    TopicpagePageRoutingModule
  ],
  declarations: [TopicpagePage]
})
export class TopicpagePageModule {}
