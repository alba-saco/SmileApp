import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { IonicModule } from '@ionic/angular';

import { SelfDiagnoseResPage } from './self-diagnose-res.page';

describe('SelfDiagnoseResPage', () => {
  let component: SelfDiagnoseResPage;
  let fixture: ComponentFixture<SelfDiagnoseResPage>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ SelfDiagnoseResPage ],
      imports: [IonicModule.forRoot()]
    }).compileComponents();

    fixture = TestBed.createComponent(SelfDiagnoseResPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
