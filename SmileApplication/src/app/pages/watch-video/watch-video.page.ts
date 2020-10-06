import { Component, OnInit, SecurityContext } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { Observable } from 'rxjs';
import { Chapter, Content } from 'src/app/types';
import { MediaContentService } from 'src/app/media-content.service';


@Component({
  selector: 'app-watch-video',
  templateUrl: './watch-video.page.html',
  styleUrls: ['./watch-video.page.scss'],
})

export class WatchVideoPage implements OnInit {

  chapter: Observable<Chapter>;
  content: Observable<Content>;

  constructor(private router: Router,
    mediaContentService: MediaContentService,
    activatedRoute: ActivatedRoute) {
      const topicID = activatedRoute.snapshot.params["topicID"];
      const chapterID = activatedRoute.snapshot.params["chapterID"];
      this.chapter = mediaContentService.getChapter(topicID, chapterID);
      this.content = mediaContentService.getContent(chapterID);
    }

  ngOnInit() {
  }
  
  learningstyle() {
    this.router.navigate(['./tabs/learningstyle'])
  }

}
