import { Component, OnInit, NgZone } from '@angular/core';
import { Platform } from '@ionic/angular';
import { Observable } from 'rxjs';
import { Chapter, Quiz } from 'src/app/types';
import { MediaContentService } from 'src/app/media-content.service';
import { ActivatedRoute } from '@angular/router';
import { QuizFormService } from 'src/app/quiz-form.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-quiz',
  templateUrl: './quiz.page.html',
  styleUrls: ['./quiz.page.scss'],
})
export class QuizPage implements OnInit {
  public question: string = '';
  public answerArray: Array<Object> = [];
  public vals: Array<string> = [];
  public ans_1: string;
  public ans_2: string;
  public ans_3: string;
  chapter: Observable<Chapter>;
  quiz: Observable<Quiz>;
  public questionList: Array<Object> = [];
  public quizFormService: QuizFormService;
  public chapterID: number = 0;
  public score: number = 0;
  public activatedRoute: ActivatedRoute;
  public quizExist: boolean = false;
  
  responseData = {
    'answer1': '',
    'answer2': '',
    'answer3': '',
    'answer4': '',
    'answer5': ''
  };

  constructor(private plaftorm: Platform,
    mediaContentService: MediaContentService,
    activatedRoute: ActivatedRoute,
    quizFormService: QuizFormService,
    private router: Router) {

    this.vals = ['ans', 'false_ans1', 'false_ans2', 'false_ans3'];

    const topicID = activatedRoute.snapshot.params["topicID"];
    this.chapterID = activatedRoute.snapshot.params["chapterID"];
    this.chapter = mediaContentService.getChapter(topicID, this.chapterID);
    this.quizFormService = quizFormService;

    this.activatedRoute = activatedRoute;

    mediaContentService.getQuiz(this.chapterID).subscribe(quiz => {
      if (quiz.question1) {
        this.quizExist = true;
      }
      this.questionList = [
      {
        questionNo: '1',
        question: quiz.question1,
        ans: quiz.answer_1,
        false_ans1: quiz.falseAnswer1_1,
        false_ans2: quiz.falseAnswer1_2,
        false_ans3: quiz.falseAnswer1_3,
        answerArray: this.randomizeAnswers()
      },
      {
        questionNo: '2',
        question: quiz.question2,
        ans: quiz.answer_2,
        false_ans1: quiz.falseAnswer2_1,
        false_ans2: quiz.falseAnswer2_2,
        false_ans3: quiz.falseAnswer2_3,
        answerArray: this.randomizeAnswers()
      },
      {
        questionNo: '3',
        question: quiz.question3,
        ans: quiz.answer_3,
        false_ans1: quiz.falseAnswer3_1,
        false_ans2: quiz.falseAnswer3_2,
        false_ans3: quiz.falseAnswer3_3,
        answerArray: this.randomizeAnswers()
      },
      {
        questionNo: '4',
        question: quiz.question4,
        ans: quiz.answer_4,
        false_ans1: quiz.falseAnswer4_1,
        false_ans2: quiz.falseAnswer4_2,
        false_ans3: quiz.falseAnswer4_3,
        answerArray: this.randomizeAnswers()
      },
      {
        questionNo: '5',
        question: quiz.question5,
        ans: quiz.answer_5,
        false_ans1: quiz.falseAnswer5_1,
        false_ans2: quiz.falseAnswer5_2,
        false_ans3: quiz.falseAnswer5_3,
        answerArray: this.randomizeAnswers()
      }
    ]
  });

    
  }
  ngOnInit() {
  }

  shuffle(a) {
    var j, x, i;
    for (i = a.length - 1; i > 0; i--) {
        j = Math.floor(Math.random() * (i + 1));
        x = a[i];
        a[i] = a[j];
        a[j] = x;
    }
    return a;
};

  randomizeAnswers(){
    this.answerArray = this.shuffle(this.vals);
    return this.answerArray.slice();
  };

  allSelected(){
    return (this.responseData['answer1'] !== '' &&
    this.responseData['answer2'] !== ''  &&
    this.responseData['answer3'] !== ''  &&
    this.responseData['answer4'] !== '' &&
    this.responseData['answer5'] !== ''  );
  };

  checkAnswers(){
      if (this.allSelected()) {
       this.postResponses(this.responseData, this.chapterID);
      };
  };

  postResponses(responses, chapterID){
    this.quizFormService.postResponses(responses, this.chapterID).subscribe(response => {
        this.score = response;
        this.router.navigate(['quiz-score', this.score], { relativeTo: this.activatedRoute });
      }
    )
  };

}
