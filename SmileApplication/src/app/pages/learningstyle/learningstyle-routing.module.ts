import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { LearningstylePage } from './learningstyle.page';

const routes: Routes = [
  {
    path: '',
    component: LearningstylePage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class LearningstylePageRoutingModule {}
