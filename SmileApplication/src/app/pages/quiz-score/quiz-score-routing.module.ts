import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { QuizScorePage } from './quiz-score.page';

const routes: Routes = [
  {
    path: '',
    component: QuizScorePage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class QuizScorePageRoutingModule {}
