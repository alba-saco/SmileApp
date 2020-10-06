import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { MediaContentService } from 'src/app/media-content.service';
import { Observable } from 'rxjs';
import { Chapter, Content } from 'src/app/types';

@Component({
  selector: 'app-read-text',
  templateUrl: './read-text.page.html',
  styleUrls: ['./read-text.page.scss'],
})
export class ReadTextPage implements OnInit {

  chapter: Observable<Chapter>;
  content: Observable<Content>;
  readingImage: Object = {};

  constructor(private router: Router,
    mediaContentService: MediaContentService,
    activatedRoute: ActivatedRoute) {
      const topicID = activatedRoute.snapshot.params["topicID"];
      const chapterID = activatedRoute.snapshot.params["chapterID"];
      this.chapter = mediaContentService.getChapter(topicID, chapterID);
      //get content
      this.content = mediaContentService.getContent(chapterID);
      //get image
      mediaContentService.getContent(chapterID).subscribe(reading => {
        mediaContentService.getReadingImage(reading.reading_image_url).subscribe(image => {
          this.readingImage['image'] = image;
        });
      })
    }

  ngOnInit() {
  }
  
  learningstyle() {
    this.router.navigate(['./tabs/learningstyle'])
  }

}
