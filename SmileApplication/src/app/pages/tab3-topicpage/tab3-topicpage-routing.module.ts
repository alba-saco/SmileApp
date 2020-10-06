import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { Tab3TopicpagePage } from './tab3-topicpage.page';

const routes: Routes = [
  {
    path: '',
    component: Tab3TopicpagePage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class Tab3TopicpagePageRoutingModule {}
