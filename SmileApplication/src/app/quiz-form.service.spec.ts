import { TestBed } from '@angular/core/testing';

import { QuizFormService } from './quiz-form.service';

describe('QuizFormService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: QuizFormService = TestBed.get(QuizFormService);
    expect(service).toBeTruthy();
  });
});
