import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { IonicModule } from '@ionic/angular';

import { LearningstylePage } from './learningstyle.page';

describe('LearningstylePage', () => {
  let component: LearningstylePage;
  let fixture: ComponentFixture<LearningstylePage>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ LearningstylePage ],
      imports: [IonicModule.forRoot()]
    }).compileComponents();

    fixture = TestBed.createComponent(LearningstylePage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
