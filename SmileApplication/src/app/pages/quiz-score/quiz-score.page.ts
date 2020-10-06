import { Component, OnInit } from '@angular/core';

import { Platform } from '@ionic/angular';
import { MediaContentService } from 'src/app/media-content.service';
import { ActivatedRoute } from '@angular/router';
import { Chapter, Quiz } from 'src/app/types';
import { Observable } from 'rxjs';

@Component({
  selector: 'app-quiz-score',
  templateUrl: './quiz-score.page.html',
  styleUrls: ['./quiz-score.page.scss'],
})
export class QuizScorePage implements OnInit {
  public questionList: Array<Object>
  chapter: Observable<Chapter>;
  quiz: Observable<Quiz>;
  score: number;

  constructor(private platfrom: Platform,
    mediaContentService: MediaContentService,
    activatedRoute: ActivatedRoute) {
      const topicID = activatedRoute.snapshot.params["topicID"];
      const chapterID = activatedRoute.snapshot.params["chapterID"];
      this.score = activatedRoute.snapshot.params["score"];
      this.chapter = mediaContentService.getChapter(topicID, chapterID);
      mediaContentService.getQuiz(chapterID).subscribe(quiz => { this.questionList = [
        {
          questionNo: 1,
          question: quiz.question1,
          ans: quiz.answer_1
        },
        {
          questionNo: 2,
          question: quiz.question2,
          ans: quiz.answer_2
        },
        {
          questionNo: 3,
          question: quiz.question3,
          ans: quiz.answer_3
        },
        {
          questionNo: 4,
          question: quiz.question4,
          ans: quiz.answer_4
        }, {
          questionNo: 5,
          question: quiz.question5,
          ans: quiz.answer_5
        }
      ]
    });
  }

  ngOnInit() {
  }



}
