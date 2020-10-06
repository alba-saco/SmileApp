import { TestBed } from '@angular/core/testing';

import { MediaContentService } from './media-content.service';

describe('MediaContentService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: MediaContentService = TestBed.get(MediaContentService);
    expect(service).toBeTruthy();
  });
});
