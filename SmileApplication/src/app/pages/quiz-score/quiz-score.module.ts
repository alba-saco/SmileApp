import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { QuizScorePageRoutingModule } from './quiz-score-routing.module';

import { QuizScorePage } from './quiz-score.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    QuizScorePageRoutingModule
  ],
  declarations: [QuizScorePage]
})
export class QuizScorePageModule {}
