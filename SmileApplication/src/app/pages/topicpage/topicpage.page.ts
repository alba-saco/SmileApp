import { Component, OnInit } from '@angular/core';
import { Platform } from '@ionic/angular';
import { Router, ActivatedRoute } from '@angular/router';
import { Observable } from 'rxjs';
import { Category, Chapter } from 'src/app/types';
import { MediaContentService } from 'src/app/media-content.service';

@Component({
  selector: 'app-topicpage',
  templateUrl: './topicpage.page.html',
  styleUrls: ['./topicpage.page.scss'],
})
export class TopicpagePage implements OnInit {
  chapterList: Array<Object> = [];
  categoryName: Observable<Category>;
  public chapterList_dummy: Array<Object> = [];

  constructor(private platform: Platform,
    private router: Router,
    mediaContentService: MediaContentService,
    activatedRoute: ActivatedRoute) {

      const topicID = activatedRoute.snapshot.params["topicID"];
      this.categoryName = mediaContentService.getCategory(topicID);
      mediaContentService.getAllChapters(topicID).subscribe(topicList => {
        topicList.forEach(topic => {
          var topicObject= {};
          mediaContentService.getChapterImage(topic.chapter_image_url).subscribe(image => {
            topicObject['chapter_image_url'] = image;
          });
          topicObject['chapter_id'] = topic.chapter_id;
          topicObject['chapter_number'] = topic.chapter_number;
          topicObject['chapter_title'] = topic.chapter_title;
          this.chapterList.push(topicObject);
        })
      })
  }

  ngOnInit() {
  }

  learningstyle() {
    this.router.navigate(['./tabs/learningstyle'])
  }

  tab2() {
    this.router.navigate(['./tabs/tab2'])
  }

  goBack() {
    window.history.back();
  }


  

}
