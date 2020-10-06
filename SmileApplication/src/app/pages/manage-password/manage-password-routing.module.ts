import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { ManagePasswordPage } from './manage-password.page';

const routes: Routes = [
  {
    path: '',
    component: ManagePasswordPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class ManagePasswordPageRoutingModule {}
