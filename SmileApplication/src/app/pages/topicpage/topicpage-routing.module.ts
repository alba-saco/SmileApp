import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { TopicpagePage } from './topicpage.page';

const routes: Routes = [
  {
    path: '',
    component: TopicpagePage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class TopicpagePageRoutingModule {}
