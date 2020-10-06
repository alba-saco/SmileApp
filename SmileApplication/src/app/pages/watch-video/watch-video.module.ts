import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { WatchVideoPageRoutingModule } from './watch-video-routing.module';

import { WatchVideoPage } from './watch-video.page';

import { Pipe, PipeTransform } from '@angular/core';
import { DomSanitizer} from '@angular/platform-browser';

@Pipe({ name: 'safe' })
export class SafePipe implements PipeTransform {
  constructor(private sanitizer: DomSanitizer) {}
  transform(url) {
    console.log(this.sanitizer.bypassSecurityTrustResourceUrl(url));
    return this.sanitizer.bypassSecurityTrustResourceUrl(url);
  }
} 

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    WatchVideoPageRoutingModule
  ],
  declarations: [WatchVideoPage,
  SafePipe]
})
export class WatchVideoPageModule {}
