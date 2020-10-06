import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { ReadTextPage } from './read-text.page';

const routes: Routes = [
  {
    path: '',
    component: ReadTextPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class ReadTextPageRoutingModule {}
