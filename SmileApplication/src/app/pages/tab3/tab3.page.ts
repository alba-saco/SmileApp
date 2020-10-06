import { Component } from '@angular/core';
import { Platform } from '@ionic/angular';

import { Router } from '@angular/router';
import { Observable } from 'rxjs';
import { Category } from '../../types';
import { MediaContentService } from '../../media-content.service';

@Component({
  selector: 'app-tab3',
  templateUrl: 'tab3.page.html',
  styleUrls: ['tab3.page.scss']
})
export class Tab3Page {
  topicsList: Array<Object> = [];

    constructor(private platform: Platform,
      private router: Router,
      private mediaContentService: MediaContentService) {
        
        mediaContentService.getAllCategories().subscribe(categoryList => {
          categoryList.forEach(category => {
            var categoryObject = {};
            mediaContentService.getCategoryImage(category.category_image_url).subscribe(image => {
              categoryObject['category_image_url'] = image;
            });
            categoryObject['category_id'] = category.category_id;
            categoryObject['category_name'] = category.category_name;
            this.topicsList.push(categoryObject);
          })
        })
    }

    settings() {
        this.router.navigate(['tabs/settings'])
    }

    getAllCategories() {
      return this.mediaContentService.getAllCategories();
    }

}
