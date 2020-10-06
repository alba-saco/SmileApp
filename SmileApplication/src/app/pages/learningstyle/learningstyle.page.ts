import { Component, OnInit } from '@angular/core';
import { ReadTextPage } from '../read-text/read-text.page';
import { NavController } from '@ionic/angular';
import { Router, ActivatedRoute } from '@angular/router';
import { MediaContentService } from 'src/app/media-content.service';
import { Observable } from 'rxjs';
import { Chapter } from 'src/app/types';
import { StatsService } from 'src/app/stats.service';


@Component({
  selector: 'app-learningstyle',
  templateUrl: './learningstyle.page.html',
  styleUrls: ['./learningstyle.page.scss'],
})
export class LearningstylePage implements OnInit {
  public statsService: StatsService;

  chapter: Observable<Chapter>;

  constructor(public navCtrl: NavController,
    private router: Router,
    mediaContentService: MediaContentService,
    activatedRoute: ActivatedRoute,
    statsService: StatsService) {
    this.statsService = statsService;

    const topicID = activatedRoute.snapshot.params["topicID"];
    const chapterID = activatedRoute.snapshot.params["chapterID"];
    this.chapter = mediaContentService.getChapter(topicID, chapterID);
  }

  ngOnInit() {
  }

  readCount() {
    this.statsService.addReading();
  }

  videoCount() {
    this.statsService.addVideo();
  }

}
