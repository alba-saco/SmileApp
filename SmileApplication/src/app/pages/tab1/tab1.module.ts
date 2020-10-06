import { IonicModule } from '@ionic/angular';
import { RouterModule } from '@angular/router';
import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Tab1Page } from './tab1.page';
import { NgCircleProgressModule } from 'ng-circle-progress';

@NgModule({
  imports: [
    IonicModule,
    CommonModule,
    FormsModule,
    RouterModule.forChild([{ path: '', component: Tab1Page }]),
   // Specify ng-circle-progress as an import
   NgCircleProgressModule.forRoot({
    radius: 100,
    outerStrokeWidth: 16,
    innerStrokeWidth: 8,
    outerStrokeColor: "#8000FF",
    animationDuration: 300,
    animation: false,
    responsive: true,
    innerStrokeColor: "#C7E596",
    renderOnClick: false,
    title: "03:00"
  })
],
  declarations: [Tab1Page]
})
export class Tab1PageModule {}
