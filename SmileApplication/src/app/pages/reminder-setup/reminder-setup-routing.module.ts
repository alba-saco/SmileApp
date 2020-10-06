import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { ReminderSetupPage } from './reminder-setup.page';

const routes: Routes = [
  {
    path: '',
    component: ReminderSetupPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class ReminderSetupPageRoutingModule {}
