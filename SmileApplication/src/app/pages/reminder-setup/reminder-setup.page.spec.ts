import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { IonicModule } from '@ionic/angular';

import { ReminderSetupPage } from './reminder-setup.page';

describe('ReminderSetupPage', () => {
  let component: ReminderSetupPage;
  let fixture: ComponentFixture<ReminderSetupPage>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ReminderSetupPage ],
      imports: [IonicModule.forRoot()]
    }).compileComponents();

    fixture = TestBed.createComponent(ReminderSetupPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
