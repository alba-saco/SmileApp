import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { IonicModule } from '@ionic/angular';

import { Tab3TopicpagePage } from './tab3-topicpage.page';

describe('Tab3TopicpagePage', () => {
  let component: Tab3TopicpagePage;
  let fixture: ComponentFixture<Tab3TopicpagePage>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ Tab3TopicpagePage ],
      imports: [IonicModule.forRoot()]
    }).compileComponents();

    fixture = TestBed.createComponent(Tab3TopicpagePage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
