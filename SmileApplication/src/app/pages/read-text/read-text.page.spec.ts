import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { IonicModule } from '@ionic/angular';

import { ReadTextPage } from './read-text.page';

describe('ReadTextPage', () => {
  let component: ReadTextPage;
  let fixture: ComponentFixture<ReadTextPage>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ReadTextPage ],
      imports: [IonicModule.forRoot()]
    }).compileComponents();

    fixture = TestBed.createComponent(ReadTextPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
