import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { PrivacyAgreementPage } from './privacy-agreement.page';

const routes: Routes = [
  {
    path: '',
    component: PrivacyAgreementPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class PrivacyAgreementPageRoutingModule {}
