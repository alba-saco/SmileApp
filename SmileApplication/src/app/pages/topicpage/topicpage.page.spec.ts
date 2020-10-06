import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { IonicModule } from '@ionic/angular';

import { TopicpagePage } from './topicpage.page';

describe('TopicpagePage', () => {
  let component: TopicpagePage;
  let fixture: ComponentFixture<TopicpagePage>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ TopicpagePage ],
      imports: [IonicModule.forRoot()]
    }).compileComponents();

    fixture = TestBed.createComponent(TopicpagePage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
