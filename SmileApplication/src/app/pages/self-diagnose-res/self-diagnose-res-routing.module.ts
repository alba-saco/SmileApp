import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { SelfDiagnoseResPage } from './self-diagnose-res.page';

const routes: Routes = [
  {
    path: '',
    component: SelfDiagnoseResPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class SelfDiagnoseResPageRoutingModule {}
