import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { IonicModule } from '@ionic/angular';

import { QuizScorePage } from './quiz-score.page';

describe('QuizScorePage', () => {
  let component: QuizScorePage;
  let fixture: ComponentFixture<QuizScorePage>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ QuizScorePage ],
      imports: [IonicModule.forRoot()]
    }).compileComponents();

    fixture = TestBed.createComponent(QuizScorePage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
